# 🐾 Sistema Web para Spa de Mascotas - Pet Spa

## 👤 Integrante
| Nombre | Responsabilidad |
|--------|----------------|
| Cano Quispe Lisbeth Nicole | Desarrollo completo del sistema (Frontend, Backend, Base de datos) |

---

## 📋 Descripción del Proyecto
Sistema web para la gestión integral de un Spa de Mascotas, desarrollado con Laravel 13 y MySQL. Permite gestionar citas, mascotas, servicios, grooming, inventario, pagos y notificaciones.

---

## ✅ Módulos Desarrollados

### 🔐 Módulo de Autenticación
- [x] Registro de clientes con verificación por email
- [x] Login con bloqueo tras 5 intentos fallidos
- [x] Login con Google (OAuth 2.0)
- [x] 2FA para administrador (Google Authenticator)
- [x] Sesión automática de 30 minutos
- [x] Recuperar y cambiar contraseña
- [x] Control de acceso por roles (RBAC)
- [x] Panel de auditoría y logs completo

### 👥 Módulo de Roles
- [x] Administrador — acceso total
- [x] Recepción — gestión de citas, clientes y pagos
- [x] Groomer — agenda, fichas y checklist
- [x] Cliente — mascotas, citas e historial

### 🐾 Módulo de Mascotas
- [x] Registro completo (especie, raza, peso, temperamento, alergias)
- [x] Editar y eliminar mascotas
- [x] Alertas de alergias y restricciones médicas
- [x] Carnet de vacunas con archivo adjunto (PDF/imagen)
- [x] Múltiples mascotas por cliente

### 📅 Módulo de Agenda y Citas
- [x] Solicitar citas con selección de mascota, servicio, groomer y horario
- [x] Estado inicial "En revisión"
- [x] Validación de solapamiento de horarios
- [x] Validación de capacidad simultánea por groomer
- [x] Ajuste automático de duración por tamaño de mascota
- [x] Ajuste por temperamento nervioso/agresivo (+20%)
- [x] Confirmar, iniciar, completar y cancelar citas (recepción)
- [x] Reprogramar citas con validación
- [x] Bandeja de solicitudes pendientes
- [x] Cancelar citas con motivo y política de cancelación (cliente)
- [x] Historial de servicios del cliente

### 📅 Módulo de Horarios y Bloqueos
- [x] Configuración de horarios de trabajo por groomer
- [x] Bloqueos de agenda (feriados, vacaciones, mantenimiento, ausencias)
- [x] Bloqueos globales y por groomer específico
- [x] Calendario maestro semanal para recepción

### ✂️ Módulo de Grooming
- [x] Agenda personal del groomer
- [x] Ficha técnica de atención (estado inicial y final)
- [x] Checklist interactivo obligatorio antes de cerrar
- [x] Fotos antes/después desde dispositivo móvil
- [x] Registro de insumos usados
- [x] Cierre de ficha y notificación automática al cliente

### 📦 Módulo de Inventario y Tienda
- [x] Gestión de productos y categorías
- [x] Control de stock con alertas de bajo inventario
- [x] Tienda virtual con búsqueda y filtros
- [x] Pedidos por WhatsApp con número del spa

### ✂️ Módulo de Servicios
- [x] Gestión de servicios y precios base
- [x] Precios automáticos por tamaño de mascota
- [x] Duración configurable por servicio

### 🔔 Módulo de Notificaciones
- [x] Email de confirmación de cita al cliente
- [x] Email al groomer cuando le asignan una cita
- [x] Email a recepción cuando llega una solicitud
- [x] Email de "mascota lista para recoger" al cerrar ficha
- [x] Recordatorio automático 24h antes de la cita
- [x] Panel de historial de notificaciones

### 💰 Módulo de Pagos y Facturación
- [x] Registro de pagos (efectivo, QR, transferencia)
- [x] Generación de facturas
- [x] Anulación de pagos
- [x] Historial de pagos

### 📊 Módulo de Reportes
- [x] Dashboard ejecutivo con KPIs en tiempo real
- [x] Citas por estado, groomer y servicio
- [x] Ingresos del mes
- [x] Top servicios más solicitados
- [x] Productos con bajo stock

### 👥 Módulo de Clientes (Recepción)
- [x] Lista completa de clientes con búsqueda
- [x] Detalle de cliente con mascotas e historial de citas

---

## ⏳ Funcionalidades Pendientes
- [ ] Gestión de pagos y facturas
- [ ] Registro de insumos usados por servicio

---

## 🛠️ Tecnologías Utilizadas
- **Backend:** Laravel 13 (PHP 8.3)
- **Frontend:** Blade + Tailwind CSS
- **Base de datos:** MySQL 8.4
- **Autenticación:** JWT, OAuth 2.0 (Google), 2FA (TOTP)
- **Email:** Gmail SMTP
- **Control de versiones:** Git + GitHub

---

## ⚙️ Instalación

```bash
git clone https://github.com/lcanoq-Lis/sistema-pet-spa.git
cd sistema-pet-spa
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



