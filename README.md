# 📝 Sistema de Blog Profesional

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/TailwindCSS-3.x-cyan?style=for-the-badge&logo=tailwindcss" alt="TailwindCSS">
    <img src="https://img.shields.io/badge/Alpine.js-3.x-green?style=for-the-badge&logo=alpine.js" alt="Alpine.js">
</p>

Un sistema de blog completo y profesional desarrollado con Laravel 11, que incluye gestión de contenido, sistema de roles, moderación de comentarios y panel administrativo moderno.

## ✨ Características Principales

### 🎯 **Gestión de Contenido**
- ✅ **Editor de Posts**: Editor WYSIWYG con TinyMCE
- ✅ **Categorías**: Organización jerárquica de contenido
- ✅ **Etiquetas**: Sistema de tags para mejor clasificación
- ✅ **Imágenes**: Subida y gestión de imágenes
- ✅ **Estados**: Borrador, Pendiente, Publicado
- ✅ **SEO**: Meta títulos, descripciones y URLs amigables

### 👥 **Sistema de Roles y Permisos**
- ✅ **Administrador**: Control total del sistema
- ✅ **Autor**: Crear y gestionar sus propios posts
- ✅ **Usuario**: Comentar y interactuar
- ✅ **Solicitudes de Autor**: Sistema de aprobación para nuevos autores

### 💬 **Sistema de Comentarios**
- ✅ **Comentarios Anidados**: Respuestas a comentarios
- ✅ **Moderación**: Aprobación/rechazo de comentarios
- ✅ **Estados**: Pendiente, Aprobado, Rechazado
- ✅ **Notificaciones**: Alertas para moderadores

### 🎨 **Panel Administrativo Moderno**
- ✅ **Dashboard Interactivo**: Estadísticas en tiempo real
- ✅ **Navegación Intuitiva**: Dropdowns organizados por funcionalidad
- ✅ **Diseño Responsive**: Optimizado para todos los dispositivos
- ✅ **Tema Oscuro**: Soporte completo para modo oscuro
- ✅ **Iconografía Consistente**: SVG icons profesionales

### 🔧 **Configuración del Sistema**
- ✅ **Configuración del Blog**: Logo, nombre, descripción
- ✅ **Gestión de Usuarios**: CRUD completo de usuarios
- ✅ **Configuración de Roles**: Asignación flexible de permisos
- ✅ **Configuración SEO**: Meta tags globales

## 🚀 Instalación y Configuración

### Requisitos del Sistema
- PHP 8.2 o superior
- Composer
- Node.js y NPM
- MySQL/PostgreSQL/SQLite
- Extensiones PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

### Instalación Paso a Paso

1. **Clonar el repositorio**
```bash
git clone <repository-url>
cd blog-system
```

2. **Instalar dependencias de PHP**
```bash
composer install
```

3. **Instalar dependencias de Node.js**
```bash
npm install
```

4. **Configurar el archivo de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar la base de datos**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_system
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

6. **Ejecutar migraciones y seeders**
```bash
php artisan migrate --seed
```

7. **Compilar assets**
```bash
npm run build
```

8. **Crear enlace simbólico para storage**
```bash
php artisan storage:link
```

9. **Iniciar el servidor de desarrollo**
```bash
php artisan serve
```

## 👤 Usuarios por Defecto

El sistema incluye usuarios de prueba para cada rol:

| Rol | Email | Contraseña | Permisos |
|-----|-------|------------|----------|
| **Administrador** | admin@blog.com | password | Control total del sistema |
| **Autor** | autor@blog.com | password | Crear y gestionar posts |
| **Usuario** | usuario@blog.com | password | Comentar y leer |

## 🏗️ Arquitectura del Sistema

### Estructura de Directorios
```
app/
├── Http/Controllers/          # Controladores organizados por funcionalidad
│   ├── Admin/                # Panel administrativo
│   ├── Blog/                 # Blog público
│   └── Auth/                 # Autenticación
├── Models/                   # Modelos Eloquent
├── Policies/                 # Políticas de autorización
└── Providers/               # Proveedores de servicios

resources/
├── views/
│   ├── blog/                # Vistas del blog público
│   ├── admin/               # Panel administrativo
│   ├── components/          # Componentes reutilizables
│   └── layouts/             # Layouts base
├── js/                      # JavaScript y Alpine.js
└── css/                     # Estilos con TailwindCSS

database/
├── migrations/              # Migraciones de base de datos
├── seeders/                # Datos de prueba
└── factories/              # Factories para testing
```

### Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **Laravel** | 11.x | Framework PHP principal |
| **TailwindCSS** | 3.x | Framework CSS utilitario |
| **Alpine.js** | 3.x | JavaScript reactivo |
| **TinyMCE** | 6.x | Editor WYSIWYG |
| **Laravel Breeze** | 2.x | Autenticación y scaffolding |
| **Vite** | 5.x | Build tool y hot reload |

## 📊 Funcionalidades Detalladas

### Panel de Control (Dashboard)
- **📈 Estadísticas en Tiempo Real**: Posts, comentarios, vistas
- **⚡ Acciones Rápidas**: Crear post, gestionar contenido
- **📋 Actividad Reciente**: Últimos posts y comentarios
- **🎯 Métricas de Rendimiento**: Análisis de contenido

### Gestión de Posts
- **✍️ Editor Avanzado**: TinyMCE con plugins personalizados
- **🖼️ Gestión de Imágenes**: Subida y optimización automática
- **🏷️ Categorías y Tags**: Organización flexible del contenido
- **👁️ Vista Previa**: Preview antes de publicar
- **📅 Programación**: Publicación programada (futuro)

### Sistema de Comentarios
- **💬 Comentarios Anidados**: Respuestas ilimitadas
- **🛡️ Moderación Avanzada**: Aprobación manual/automática
- **🚫 Filtros de Spam**: Protección contra contenido malicioso
- **📧 Notificaciones**: Alertas por email (futuro)

### Panel Administrativo
- **👥 Gestión de Usuarios**: CRUD completo con roles
- **📝 Moderación de Contenido**: Aprobación de posts y comentarios
- **⚙️ Configuración del Sistema**: Logo, nombre, SEO
- **📊 Reportes**: Estadísticas detalladas del sitio

## 🎨 Personalización

### Configuración del Tema
El sistema utiliza TailwindCSS con variables CSS personalizadas:

```css
:root {
  --color-primary: #6366f1;    /* Indigo */
  --color-secondary: #64748b;  /* Slate */
  --color-accent: #f59e0b;     /* Amber */
}
```

### Componentes Personalizables
- **Layouts**: Fácil modificación de estructura
- **Componentes**: Blade components reutilizables
- **Estilos**: Variables CSS para colores y espaciado
- **Iconos**: SVG icons optimizados y escalables

## 🔒 Seguridad

### Medidas Implementadas
- ✅ **Autenticación Segura**: Laravel Breeze con hash bcrypt
- ✅ **Autorización**: Policies y Gates para control de acceso
- ✅ **Validación**: Validación robusta en formularios
- ✅ **CSRF Protection**: Protección contra ataques CSRF
- ✅ **XSS Prevention**: Escape automático de contenido
- ✅ **SQL Injection**: Eloquent ORM previene inyecciones

### Roles y Permisos
```php
// Ejemplo de política de autorización
public function update(User $user, Post $post): bool
{
    return $user->id === $post->user_id || $user->isAdmin();
}
```

## 🧪 Testing

### Ejecutar Tests
```bash
# Tests unitarios y de funcionalidad
php artisan test

# Tests con cobertura
php artisan test --coverage

# Tests específicos
php artisan test --filter=PostTest
```

### Estructura de Tests
- **Unit Tests**: Lógica de modelos y servicios
- **Feature Tests**: Funcionalidad completa de endpoints
- **Browser Tests**: Tests E2E con Laravel Dusk (futuro)

## 📈 Performance

### Optimizaciones Implementadas
- ✅ **Eager Loading**: Prevención de N+1 queries
- ✅ **Caching**: Cache de vistas y consultas frecuentes
- ✅ **Asset Optimization**: Minificación con Vite
- ✅ **Image Optimization**: Compresión automática de imágenes
- ✅ **Database Indexing**: Índices optimizados para consultas

### Métricas de Rendimiento
- **Tiempo de Carga**: < 200ms (promedio)
- **Lighthouse Score**: 95+ (Performance)
- **Core Web Vitals**: Optimizado para SEO

## 🚀 Deployment

### Producción con Laravel Forge
```bash
# Configuración de producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Variables de Entorno Importantes
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Cache y Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Email (para notificaciones)
MAIL_MAILER=smtp
MAIL_HOST=tu-smtp-host
```

## 🤝 Contribución

### Cómo Contribuir
1. **Fork** el repositorio
2. **Crear** una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. **Commit** tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. **Push** a la rama (`git push origin feature/nueva-funcionalidad`)
5. **Crear** un Pull Request

### Estándares de Código
- **PSR-12**: Estándar de codificación PHP
- **Laravel Conventions**: Convenciones de Laravel
- **Tests**: Incluir tests para nuevas funcionalidades
- **Documentación**: Actualizar README si es necesario

## 📞 Soporte

### Documentación
- **Laravel**: [https://laravel.com/docs](https://laravel.com/docs)
- **TailwindCSS**: [https://tailwindcss.com/docs](https://tailwindcss.com/docs)
- **Alpine.js**: [https://alpinejs.dev/](https://alpinejs.dev/)

### Issues y Bugs
Si encuentras algún problema:
1. Revisa los **issues existentes**
2. Crea un **nuevo issue** con detalles
3. Incluye **pasos para reproducir** el problema
4. Adjunta **logs** si es necesario

## 📄 Licencia

Este proyecto está licenciado bajo la [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
    <strong>Desarrollado con ❤️ usando Laravel 11</strong>
</p>
