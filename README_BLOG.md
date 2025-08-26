# TechBlog - Sistema de Blog con Laravel 10

Un sistema completo de blog desarrollado con Laravel 10.8 y Laravel Breeze, especializado en contenido tecnológico con sistema de roles, moderación y comentarios de usuarios invitados.

## Características Principales

### 🔐 Sistema de Roles
- **Admin**: Control total del sistema, moderación de contenido
- **Autor**: Puede crear y gestionar sus propios posts
- **Usuario Invitado**: Puede comentar en los posts sin registro

### 📝 Gestión de Contenido
- **Posts**: Creación, edición y gestión de artículos
- **Categorías**: Organización por temas (Programación, IA, DevOps, etc.)
- **Tipos de Post**: Tutorial, Artículo, Noticia, Review, Caso de Estudio
- **Comentarios**: Sistema de comentarios con respuestas anidadas

### 🛡️ Sistema de Moderación
- Aprobación/rechazo de posts de autores
- Moderación de comentarios
- Panel de administración centralizado
- Acciones en lote para eficiencia

### 🔍 Funcionalidades Avanzadas
- **Búsqueda**: Sistema de búsqueda avanzada con filtros
- **SEO**: URLs amigables y meta datos
- **Responsive**: Diseño adaptable a todos los dispositivos
- **API**: Endpoints para sugerencias de búsqueda

## Requisitos del Sistema

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL/PostgreSQL/SQLite
- Extensiones PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalación

### 1. Instalar dependencias
```bash
# Dependencias PHP
composer install

# Dependencias Node.js
npm install
```

### 2. Configuración del entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 3. Configurar base de datos
Edita el archivo `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 4. Ejecutar migraciones y seeders
```bash
# Ejecutar migraciones
php artisan migrate

# Poblar base de datos con datos de ejemplo
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=PostTypeSeeder
php artisan db:seed --class=PostSeeder
```

### 5. Compilar assets
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 6. Configurar storage
```bash
php artisan storage:link
```

## Usuarios de Prueba

Después de ejecutar los seeders, tendrás estos usuarios disponibles:

- **Admin**: admin@blog.com / password
- **Autor**: autor@blog.com / password  
- **Invitado**: invitado@blog.com / password

## Estructura del Proyecto

### Modelos Principales
- `User`: Gestión de usuarios con roles
- `Post`: Artículos del blog
- `Category`: Categorías de contenido
- `PostType`: Tipos de publicación
- `Comment`: Sistema de comentarios

### Controladores
- `BlogController`: Frontend público del blog
- `PostController`: Gestión de posts (CRUD)
- `CommentController`: Gestión de comentarios
- `ModerationController`: Panel de moderación
- `SearchController`: API de búsqueda

### Middleware Personalizado
- `RoleMiddleware`: Control de acceso por roles
- `CanPublishMiddleware`: Verificación de permisos de publicación
- `AllowGuestComments`: Gestión de comentarios de invitados

## Comandos Artisan Personalizados

### Limpieza de comentarios
```bash
# Limpiar comentarios rechazados antiguos (30 días por defecto)
php artisan blog:cleanup-comments

# Especificar días personalizados
php artisan blog:cleanup-comments --days=60
```

## API Endpoints

### Búsqueda
```
GET /api/search/suggestions?q=laravel
GET /api/search/popular
```

## Funcionalidades por Rol

### 👑 Administrador
- ✅ Crear, editar, eliminar cualquier post
- ✅ Moderar comentarios (aprobar/rechazar)
- ✅ Gestionar categorías y tipos de post
- ✅ Aprobar/rechazar posts de autores
- ✅ Acceso al panel de moderación
- ✅ Gestión completa de usuarios

### ✍️ Autor
- ✅ Crear y gestionar sus propios posts
- ✅ Posts requieren aprobación del admin para publicarse
- ✅ Ver estadísticas de sus publicaciones
- ❌ No puede moderar contenido de otros

### 👤 Usuario Invitado
- ✅ Comentar en posts sin registro
- ✅ Responder a otros comentarios
- ✅ Navegación completa del blog
- ❌ No puede crear posts

## Configuración de Producción

### 1. Optimizaciones
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2. Variables de entorno importantes
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Configurar email para notificaciones
MAIL_MAILER=smtp
MAIL_HOST=tu-smtp-host
MAIL_PORT=587
MAIL_USERNAME=tu-email
MAIL_PASSWORD=tu-password
```

## Mantenimiento

### Tareas Programadas
Agrega al crontab para ejecutar tareas automáticas:
```bash
* * * * * cd /path/to/blog && php artisan schedule:run >> /dev/null 2>&1
```

### Respaldos
```bash
# Respaldar base de datos
php artisan backup:run

# Limpiar archivos temporales
php artisan cache:clear
php artisan view:clear
```

## Licencia

Este proyecto está bajo la Licencia MIT.

---

Desarrollado con ❤️ usando Laravel 10.8
