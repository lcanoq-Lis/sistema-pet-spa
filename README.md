# 🐾 Sistema Web para Spa de Mascotas — Pet Spa

## 👤 Integrante

| Nombre | Responsabilidad |
|--------|----------------|
| Cano Quispe Lisbeth Nicole | Desarrollo completo del sistema (Frontend, Backend, Base de datos) |

---

## 📋 Descripción del Proyecto

Sistema web para la gestión integral de un Spa de Mascotas, desarrollado con **Laravel 13** y **MySQL 8.4**. Permite gestionar citas, mascotas, servicios, grooming, inventario, pagos, promociones y notificaciones automáticas por email.

---

## 👥 Roles del Sistema

| Rol | Descripción |
|-----|-------------|
| 👑 Administrador | Gestión total del sistema, reportes, personal, horarios y promociones |
| 📋 Recepción | Gestión de citas, clientes, pagos y calendario maestro |
| ✂️ Groomer | Agenda personal, fichas técnicas, fotos e insumos |
| 🐾 Cliente | Registro de mascotas, solicitud y cancelación de citas |

---

## ✅ Módulos Desarrollados

### 🔐 Autenticación y Seguridad
- [x] Login con email y contraseña
- [x] Registro de usuarios
- [x] OAuth 2.0 con Google
- [x] Autenticación de dos factores (2FA — TOTP)
- [x] Bloqueo por intentos fallidos
- [x] Auto-logout por inactividad
- [x] Recuperación de contraseña por email
- [x] Control de acceso por roles (RBAC)

### 🐾 Módulo de Mascotas
- [x] Registro completo (especie, raza, peso, temperamento, alergias)
- [x] Editar y eliminar mascotas
- [x] Alertas de alergias y restricciones médicas
- [x] Carnet de vacunas con archivo adjunto
- [x] Múltiples mascotas por cliente

### 📅 Módulo de Agenda y Citas
- [x] Solicitar citas con selección de mascota, servicio, groomer y horario
- [x] Validación de solapamiento de horarios
- [x] Validación de capacidad simultánea por groomer
- [x] Ajuste automático de duración por tamaño de mascota
- [x] Confirmar, iniciar, completar y cancelar citas
- [x] Reprogramar citas con validación de disponibilidad
- [x] Cancelar citas con motivo
- [x] Historial de servicios del cliente

### ⏰ Módulo de Horarios y Bloqueos
- [x] Horario laboral configurable por día de la semana
- [x] Bloqueos de agenda (feriados, vacaciones, mantenimiento, ausencias)
- [x] Bloqueos globales y por groomer específico
- [x] Validación automática al crear citas

### 📆 Calendario Maestro
- [x] Vista semanal de citas por groomer
- [x] Filtro por groomer específico
- [x] Navegación entre semanas
- [x] Modal con detalle de cada cita

### ✂️ Módulo de Grooming
- [x] Agenda personal del groomer
- [x] Ficha técnica de atención (estado inicial y final)
- [x] Checklist interactivo obligatorio
- [x] Galería de fotos antes/después con cámara en vivo y drag & drop
- [x] Registro de insumos con descuento automático de stock
- [x] Cierre de ficha y notificación automática al cliente

### 📦 Módulo de Inventario y Tienda
- [x] Gestión de productos y categorías
- [x] Control de stock con alertas de bajo inventario
- [x] Tienda virtual con búsqueda y filtros
- [x] Pedidos por WhatsApp

### 🔔 Módulo de Notificaciones
- [x] Email de confirmación de cita al cliente
- [x] Email al groomer al asignarle una cita
- [x] Email de reprogramación al cliente y groomer
- [x] Email de mascota lista para recoger al cerrar ficha
- [x] Recordatorio automático 24h antes de la cita

### 💰 Módulo de Pagos y Facturación
- [x] Registro de pagos (efectivo, QR, transferencia bancaria)
- [x] Aplicación de promociones y descuentos
- [x] Generación de facturas imprimibles
- [x] Anulación de pagos e historial

### 🏷️ Módulo de Promociones
- [x] Descuento por porcentaje
- [x] Descuento por monto fijo
- [x] Descuento por cliente frecuente
- [x] Por servicio específico o todos los servicios
- [x] Vigencia por fechas configurable

### 👥 Módulo de Clientes (Recepción)
- [x] Lista completa con búsqueda en tiempo real
- [x] Detalle con mascotas e historial de citas

### 📊 Módulo de Reportes
- [x] Dashboard ejecutivo con KPIs en tiempo real
- [x] Citas por estado, groomer y servicio
- [x] Ingresos del mes y top servicios

---

## 🛠️ Tecnologías Utilizadas

| Capa | Tecnología |
|------|-----------|
| Backend | Laravel 13 / PHP 8.3 |
| Frontend | Blade + Tailwind CSS |
| Base de datos | MySQL 8.4 |
| Autenticación | OAuth 2.0 (Google), 2FA (TOTP) |
| Email | Gmail SMTP |
| Control de versiones | Git + GitHub |

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
php artisan storage:link
npm run build
php artisan serve
```

---

## 📅 Cronograma de Desarrollo

| Fecha | Módulo | Estado |
|-------|--------|--------|
| Dom 17 mayo | Organización inicial | ✅ |
| Lun 18 mayo | Presentación del sistema | ✅ |
| Mar 19 mayo | Módulo de agenda y citas | ✅ |
| Mié 20 mayo | Formularios del cliente | ✅ |
| Jue 21 mayo | Módulo de recepción | ✅ |
| Vie 22 mayo | Módulo de grooming | ✅ |
| Sáb 23 mayo | Revisión semanal | ✅ |

---

## 🔗 Repositorio

[https://github.com/lcanoq-Lis/sistema-pet-spa](https://github.com/lcanoq-Lis/sistema-pet-spa)