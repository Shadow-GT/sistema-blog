#!/usr/bin/env bash
#
# Watchdog de MySQL para sistema-blog.
#
# Comprueba cada ejecucion si MySQL responde. Si responde, no hace nada.
# Si no responde, registra el contexto (disco, memoria, OOM killer, ultimas
# lineas del log) y recien entonces lo reinicia. Ese registro es lo que
# permite encontrar la causa real en vez de reiniciar a ciegas.
#
# Instalacion (como root, en el servidor):
#   cp scripts/mysql-watchdog.sh /usr/local/bin/mysql-watchdog.sh
#   chmod +x /usr/local/bin/mysql-watchdog.sh
#   printf '*/2 * * * * root /usr/local/bin/mysql-watchdog.sh\n' > /etc/cron.d/mysql-watchdog
#
# Prueba manual sin reiniciar nada:
#   /usr/local/bin/mysql-watchdog.sh --dry-run
#
set -uo pipefail

DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"
DOCKER_DB_CONTAINER="${DOCKER_DB_CONTAINER:-sistema_blog_db}"
DOCKER_APP_CONTAINER="${DOCKER_APP_CONTAINER:-sistema_blog}"
LOG_FILE="${LOG_FILE:-/var/log/mysql-watchdog.log}"
LOCK_FILE="${LOCK_FILE:-/var/run/mysql-watchdog.lock}"
# Cuantos segundos esperar a que MySQL acepte conexiones tras reiniciarlo.
STARTUP_TIMEOUT="${STARTUP_TIMEOUT:-90}"

DRY_RUN=0
[[ "${1:-}" == "--dry-run" ]] && DRY_RUN=1

log() {
    printf '%s  %s\n' "$(date '+%Y-%m-%d %H:%M:%S')" "$*" >> "$LOG_FILE"
}

# Evita que dos ejecuciones se pisen si un reinicio tarda mas que el intervalo.
exec 9>"$LOCK_FILE" 2>/dev/null || true
if ! flock -n 9 2>/dev/null; then
    exit 0
fi

# --- Deteccion del modo de despliegue -------------------------------------

detectar_modo() {
    if command -v docker >/dev/null 2>&1 \
        && docker inspect "$DOCKER_DB_CONTAINER" >/dev/null 2>&1; then
        echo "docker"
        return
    fi
    for unidad in mysql mysqld mariadb; do
        if systemctl list-unit-files "${unidad}.service" 2>/dev/null | grep -q "^${unidad}.service"; then
            echo "systemd:${unidad}"
            return
        fi
    done
    echo "desconocido"
}

# --- Comprobacion de salud -------------------------------------------------

# Un puerto abierto no garantiza que MySQL responda consultas, pero es la
# senal que le importa a la app: es exactamente lo que falla con
# "SQLSTATE[HY000] [2002] Connection refused".
puerto_responde() {
    timeout 5 bash -c "echo > /dev/tcp/${DB_HOST}/${DB_PORT}" >/dev/null 2>&1
}

esta_sano() {
    if [[ "$MODO" == "docker" ]]; then
        local corriendo
        corriendo="$(docker inspect -f '{{.State.Running}}' "$DOCKER_DB_CONTAINER" 2>/dev/null)"
        [[ "$corriendo" == "true" ]] || return 1
    fi
    puerto_responde
}

# --- Diagnostico -----------------------------------------------------------

registrar_diagnostico() {
    log "--- MySQL NO responde en ${DB_HOST}:${DB_PORT} (modo: ${MODO}) ---"

    local disco
    disco="$(df -h / /var/lib/mysql 2>/dev/null | tail -n +2 | tr -s ' ' | cut -d' ' -f1,5,6 | tr '\n' ' ')"
    log "disco: ${disco:-n/d}"

    local mem
    mem="$(free -m 2>/dev/null | awk '/^Mem:/ {print "total="$2"MB usada="$3"MB libre="$4"MB"}')"
    log "memoria: ${mem:-n/d}"

    # SIGKILL por falta de memoria: la causa mas comun de que MySQL "se muera solo".
    local oom
    oom="$(dmesg 2>/dev/null | grep -i 'killed process' | grep -i mysql | tail -3)"
    [[ -z "$oom" ]] && oom="$(journalctl -k --since '1 hour ago' 2>/dev/null | grep -i 'killed process' | tail -3)"
    if [[ -n "$oom" ]]; then
        log "OOM KILLER detectado -> la causa es falta de memoria:"
        log "  ${oom//$'\n'/ | }"
    fi

    if [[ "$MODO" == "docker" ]]; then
        local salida
        salida="$(docker inspect -f 'ExitCode={{.State.ExitCode}} OOMKilled={{.State.OOMKilled}} Restarts={{.RestartCount}}' "$DOCKER_DB_CONTAINER" 2>/dev/null)"
        log "contenedor: ${salida:-n/d}"
        log "docker logs: $(docker logs --tail 5 "$DOCKER_DB_CONTAINER" 2>&1 | tr '\n' ' | ')"
    else
        for archivo in /var/log/mysql/error.log /var/log/mysqld.log /var/log/mariadb/mariadb.log; do
            if [[ -r "$archivo" ]]; then
                log "${archivo}: $(tail -5 "$archivo" 2>/dev/null | tr '\n' ' | ')"
                break
            fi
        done
    fi
}

# --- Reinicio --------------------------------------------------------------

reiniciar() {
    case "$MODO" in
        docker)
            log "reiniciando contenedor ${DOCKER_DB_CONTAINER}..."
            docker start "$DOCKER_DB_CONTAINER" >/dev/null 2>&1 \
                || docker restart "$DOCKER_DB_CONTAINER" >/dev/null 2>&1
            ;;
        systemd:*)
            log "reiniciando servicio ${MODO#systemd:}..."
            systemctl restart "${MODO#systemd:}" >/dev/null 2>&1
            ;;
        *)
            log "ERROR: no se detecto ni contenedor '${DOCKER_DB_CONTAINER}' ni unidad systemd de MySQL. Sin accion."
            return 1
            ;;
    esac
}

esperar_arranque() {
    local esperado=0
    while (( esperado < STARTUP_TIMEOUT )); do
        if puerto_responde; then
            return 0
        fi
        sleep 3
        (( esperado += 3 ))
    done
    return 1
}

# --- Flujo principal -------------------------------------------------------

MODO="$(detectar_modo)"

if esta_sano; then
    [[ $DRY_RUN -eq 1 ]] && echo "OK: MySQL responde en ${DB_HOST}:${DB_PORT} (modo: ${MODO})"
    exit 0
fi

registrar_diagnostico

if [[ $DRY_RUN -eq 1 ]]; then
    echo "CAIDO: MySQL no responde en ${DB_HOST}:${DB_PORT} (modo: ${MODO}). --dry-run, no se reinicia."
    echo "Diagnostico escrito en ${LOG_FILE}"
    exit 1
fi

reiniciar || exit 1

if esperar_arranque; then
    log "RECUPERADO: MySQL acepta conexiones de nuevo."
    # Con Docker, la app puede quedar con el pool de conexiones muerto.
    if [[ "$MODO" == "docker" ]] && docker inspect "$DOCKER_APP_CONTAINER" >/dev/null 2>&1; then
        docker restart "$DOCKER_APP_CONTAINER" >/dev/null 2>&1 \
            && log "contenedor ${DOCKER_APP_CONTAINER} reiniciado para renovar conexiones."
    fi
    exit 0
fi

log "FALLO: MySQL sigue sin responder tras ${STARTUP_TIMEOUT}s. Requiere revision manual."
exit 1
