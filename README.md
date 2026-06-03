# Sistema Web para Spa de Mascotas — Pet Spa

## Integrante

| Nombre | Responsabilidad |
|--------|----------------|
| Cano Quispe Lisbeth Nicole | Desarrollo completo del sistema (Frontend, Backend, Base de datos) |

---

## Descripcion del Proyecto

Sistema web para la gestion integral de un Spa de Mascotas, desarrollado con **Laravel 13** y **MySQL 8.4**. Permite gestionar citas, mascotas, servicios, grooming, inventario, pagos, promociones y notificaciones automaticas por email.

---

## Roles del Sistema

| Rol | Descripcion |
|-----|-------------|
| Administrador | Gestion total del sistema, reportes, personal, horarios, configuracion y promociones |
| Recepcion | Gestion de citas, clientes, pagos, calendario maestro y cierre de caja |
| Groomer | Agenda personal, fichas tecnicas, fotos e insumos |
| Cliente | Registro de mascotas, solicitud y cancelacion de citas, perfil editable |

---

## Modulos Desarrollados

### Autenticacion y Seguridad
- [x] Login con email y contrasena
- [x] Registro de usuarios con validacion fuerte de contrasena
- [x] OAuth 2.0 con Google
- [x] Autenticacion de dos factores (2FA - TOTP)
- [x] Bloqueo por intentos fallidos y auto-logout
- [x] Recuperacion de contrasena por email
- [x] Control de acceso por roles (RBAC) - Error 403 para accesos no autorizados

### Mascotas
- [x] Registro completo (especie, raza, peso, temperamento, alergias)
- [x] Editar y eliminar mascotas
- [x] Alertas de alergias y restricciones medicas
- [x] Carnet de vacunas con archivo adjunto
- [x] Multiples mascotas por cliente

### Agenda y Citas
- [x] Solicitar citas con seleccion de mascota, servicio, groomer y horario
- [x] Validacion de solapamiento de horarios
- [x] Validacion de capacidad simultanea por groomer
- [x] Ajuste automatico de duracion por tamano de mascota
- [x] Confirmar, iniciar, completar y cancelar citas
- [x] Reprogramar citas con validacion de disponibilidad
- [x] Politica de cancelacion configurable (minimo de horas de anticipacion)
- [x] Historial de servicios del cliente

### Horarios y Bloqueos
- [x] Horario laboral configurable por dia de la semana
- [x] Bloqueos de agenda (feriados, vacaciones, mantenimiento, ausencias)
- [x] Bloqueos globales y por groomer especifico
- [x] Validacion automatica al crear y reprogramar citas

### Calendario Maestro (FullCalendar)
- [x] Vista semanal interactiva con FullCalendar.js
- [x] Drag & drop para reprogramar citas arrastrando
- [x] Filtro por groomer especifico
- [x] Navegacion entre semanas
- [x] Modal con detalle de cada cita
- [x] Validacion de horarios y bloqueos al reprogramar

### Grooming
- [x] Agenda personal del groomer con KPIs
- [x] Ficha tecnica de atencion (estado inicial y final)
- [x] Checklist configurable por tipo de servicio
- [x] Obligatorio completar checklist antes de cerrar ficha
- [x] Galeria de fotos antes/despues con camara en vivo y drag & drop
- [x] Registro de insumos con estados: usado, devuelto, desperdiciado
- [x] Descuento automatico de stock al registrar insumos
- [x] Cierre de ficha y notificacion automatica al cliente

### Inventario y Tienda
- [x] Gestion de productos y categorias
- [x] Control de stock con alertas de bajo inventario
- [x] Tienda virtual con busqueda y filtros
- [x] Pedidos por WhatsApp con producto y precio

### Notificaciones
- [x] Email de confirmacion de cita al cliente
- [x] Email al groomer al asignarle una cita
- [x] Email de reprogramacion al cliente y groomer
- [x] Email de mascota lista para recoger al cerrar ficha
- [x] Recordatorio automatico 24h antes de la cita
- [x] Recordatorio automatico 2h antes de la cita
- [x] Alerta de alto consumo de insumos por groomer (email al admin)

### Pagos y Facturacion
- [x] Registro de pagos (efectivo, QR, transferencia bancaria)
- [x] Aplicacion de promociones y descuentos
- [x] Generacion de facturas imprimibles
- [x] Anulacion de pagos e historial
- [x] Cierre de caja diario con resumen por metodo de pago

### Promociones
- [x] Descuento por porcentaje
- [x] Descuento por monto fijo
- [x] Descuento por cliente frecuente
- [x] Por servicio especifico o todos los servicios
- [x] Vigencia por fechas configurable
- [x] Activar/desactivar promociones

### Clientes (Recepcion)
- [x] Lista completa con busqueda en tiempo real
- [x] Registro de nuevos clientes con verificacion de email
- [x] Registro de mascotas desde recepcion
- [x] Detalle con mascotas e historial de citas

### Reportes
- [x] Dashboard ejecutivo con KPIs en tiempo real por rol
- [x] Citas por estado, groomer y servicio
- [x] Ingresos del mes y top servicios
- [x] Control de consumo de insumos por groomer

### Configuracion del Sistema
- [x] Limite de insumos por groomer/semana configurable
- [x] Horas minimas para cancelar cita configurable
- [x] Checklist por tipo de servicio configurable

---

## Tecnologias Utilizadas

| Capa | Tecnologia |
|------|-----------|
| Backend | Laravel 13 / PHP 8.3 |
| Frontend | Blade + Tailwind CSS + FullCalendar.js |
| Base de datos | MySQL 8.4 |
| Autenticacion | OAuth 2.0 (Google), 2FA (TOTP) |
| Email | Gmail SMTP |
| Control de versiones | Git + GitHub |

---

## Instalacion

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

## Cronograma de Desarrollo

### Semana 1 (17-23 mayo)

| Fecha | Modulo | Estado |
|-------|--------|--------|
| Dom 17 mayo | Organizacion inicial | Completo |
| Lun 18 mayo | Presentacion del sistema | Completo |
| Mar 19 mayo | Modulo de agenda y citas | Completo |
| Mie 20 mayo | Formularios del cliente | Completo |
| Jue 21 mayo | Modulo de recepcion | Completo |
| Vie 22 mayo | Modulo de grooming | Completo |
| Sab 23 mayo | Revision semanal | Completo |

### Semana 2 (24-31 mayo)

| Fecha | Modulo | Estado |
|-------|--------|--------|
| Dom 24 mayo | Organizacion segunda semana | Completo |
| Lun 25 mayo | Inventario y tienda | Completo |
| Mar 26 mayo | Seguridad del sistema | Completo |
| Mie 27 mayo | Notificaciones y reportes | Completo |
| Jue 28 mayo | Pruebas del sistema | Completo |
| Vie 29 mayo | Correcciones finales | Completo |
| Sab 30 mayo | Ensayo de presentacion | Completo |
| Dom 31 mayo | Presentacion final | Completo |

---

## Base de Datos
https://drive.google.com/drive/folders/1bhTQSH8sCfB4rSX1Y21QMdqNb-c_XfHc?usp=sharing

## Repositorio
https://github.com/lcanoq-Lis/sistema-pet-spa
