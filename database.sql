-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2026 at 01:50 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spa_mascotas`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` int UNSIGNED DEFAULT NULL,
  `tabla` varchar(100) NOT NULL,
  `registro_id` int UNSIGNED NOT NULL,
  `accion` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `datos_anteriores` json DEFAULT NULL,
  `datos_nuevos` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `ejecutado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logs`
--

CREATE TABLE `auth_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `rol` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `evento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bloqueos_agenda`
--

CREATE TABLE `bloqueos_agenda` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tipo` enum('feriado','mantenimiento','ausencia','otro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'otro',
  `motivo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groomer_id` bigint UNSIGNED DEFAULT NULL,
  `creado_por` bigint UNSIGNED DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bloqueos_calendario`
--

CREATE TABLE `bloqueos_calendario` (
  `id` int UNSIGNED NOT NULL,
  `groomer_id` int UNSIGNED DEFAULT NULL,
  `tipo` enum('feriado','vacaciones','mantenimiento','ausencia') NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carritos`
--

CREATE TABLE `carritos` (
  `id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `session_token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorias_productos`
--

CREATE TABLE `categorias_productos` (
  `id` int UNSIGNED NOT NULL,
  `padre_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorias_productos`
--

INSERT INTO `categorias_productos` (`id`, `padre_id`, `nombre`, `descripcion`, `activo`) VALUES
(1, NULL, 'Alimentos', 'Comida para mascotas', 1),
(2, NULL, 'Shampoos', 'Productos de baño', 1),
(3, NULL, 'Juguetes', 'Juguetes para mascotas', 1),
(4, NULL, 'Accesorios', 'Collares y correas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checklist_items_catalogo`
--

CREATE TABLE `checklist_items_catalogo` (
  `id` int UNSIGNED NOT NULL,
  `servicio_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `requiere_observacion` tinyint(1) NOT NULL DEFAULT '0',
  `orden` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checklist_items_catalogo`
--

INSERT INTO `checklist_items_catalogo` (`id`, `servicio_id`, `nombre`, `descripcion`, `requiere_observacion`, `orden`, `activo`) VALUES
(1, NULL, 'Baño', NULL, 0, 1, 1),
(2, NULL, 'Corte', NULL, 0, 2, 1),
(3, NULL, 'Uñas', NULL, 1, 3, 1),
(4, NULL, 'Limpieza de oídos', NULL, 1, 4, 1),
(5, NULL, 'Glándulas', NULL, 1, 5, 1),
(6, NULL, 'Perfume / secado', NULL, 0, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id` int UNSIGNED NOT NULL,
  `mascota_id` int UNSIGNED NOT NULL,
  `groomer_id` int UNSIGNED NOT NULL,
  `servicio_id` int UNSIGNED NOT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `creado_por_usuario_id` bigint UNSIGNED DEFAULT NULL,
  `estado` enum('en_revision','agendada','confirmada','en_progreso','completada','cancelada','no_asistio') NOT NULL DEFAULT 'en_revision',
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin_estimada` datetime NOT NULL,
  `duracion_real_minutos` smallint UNSIGNED DEFAULT NULL,
  `precio_acordado` decimal(10,2) NOT NULL,
  `notas_cliente` text,
  `motivo_cancelacion` text,
  `reprogramada_desde_id` int UNSIGNED DEFAULT NULL,
  `reprogramada_por_id` bigint UNSIGNED DEFAULT NULL,
  `reprogramada_en` datetime DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `canal_notificacion` enum('email','whatsapp','sms','telegram') DEFAULT 'whatsapp',
  `horario_preferido` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consumo_insumos_ficha`
--

CREATE TABLE `consumo_insumos_ficha` (
  `id` int UNSIGNED NOT NULL,
  `ficha_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `variante_id` int UNSIGNED DEFAULT NULL,
  `cantidad` decimal(8,3) NOT NULL,
  `registrado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `id` int UNSIGNED NOT NULL,
  `carrito_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `variante_id` int UNSIGNED DEFAULT NULL,
  `cantidad` smallint UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id` int UNSIGNED NOT NULL,
  `factura_id` int UNSIGNED NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` smallint UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int UNSIGNED NOT NULL,
  `pedido_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `variante_id` int UNSIGNED DEFAULT NULL,
  `cantidad` smallint UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `disponibilidad_groomer`
--

CREATE TABLE `disponibilidad_groomer` (
  `id` int UNSIGNED NOT NULL,
  `groomer_id` int UNSIGNED NOT NULL,
  `dia_semana` tinyint UNSIGNED NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `intervalo_descanso` json DEFAULT NULL,
  `buffer_minutos` tinyint UNSIGNED NOT NULL DEFAULT '15'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `encuestas_satisfaccion`
--

CREATE TABLE `encuestas_satisfaccion` (
  `id` int UNSIGNED NOT NULL,
  `cita_id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `calificacion` tinyint UNSIGNED NOT NULL,
  `comentario` text,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `facturas`
--

CREATE TABLE `facturas` (
  `id` int UNSIGNED NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `cita_id` int UNSIGNED DEFAULT NULL,
  `pedido_id` int UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `impuesto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('pendiente','pagada','cancelada') NOT NULL DEFAULT 'pendiente',
  `metodo_pago` enum('efectivo','qr','transferencia') NOT NULL DEFAULT 'efectivo',
  `fecha_emision` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fichas_checklist`
--

CREATE TABLE `fichas_checklist` (
  `id` int UNSIGNED NOT NULL,
  `ficha_id` int UNSIGNED NOT NULL,
  `item_id` int UNSIGNED NOT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT '0',
  `observacion` text,
  `completado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fichas_grooming`
--

CREATE TABLE `fichas_grooming` (
  `id` int UNSIGNED NOT NULL,
  `cita_id` int UNSIGNED NOT NULL,
  `raza_momento` varchar(100) DEFAULT NULL,
  `tamano_momento` enum('xs','s','m','l','xl') DEFAULT NULL,
  `temperatura_ingreso` decimal(4,1) DEFAULT NULL,
  `estado_inicial` text,
  `estado_final` text,
  `notas_internas` text,
  `consumido_inventario` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_cierre` datetime DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fotos_grooming`
--

CREATE TABLE `fotos_grooming` (
  `id` int UNSIGNED NOT NULL,
  `ficha_id` int UNSIGNED NOT NULL,
  `tipo` enum('antes','despues') NOT NULL,
  `url` varchar(500) NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groomers`
--

CREATE TABLE `groomers` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `especialidad` varchar(150) DEFAULT NULL,
  `capacidad_simultanea` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `horario_trabajo` json DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historial_mascotas`
--

CREATE TABLE `historial_mascotas` (
  `id` int UNSIGNED NOT NULL,
  `mascota_id` int UNSIGNED NOT NULL,
  `tipo_evento` enum('servicio','recomendacion','alerta','cancelacion','otro') NOT NULL,
  `descripcion` text NOT NULL,
  `referencia_id` int UNSIGNED DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horarios_spa`
--

CREATE TABLE `horarios_spa` (
  `id` bigint UNSIGNED NOT NULL,
  `dia_semana` tinyint UNSIGNED NOT NULL COMMENT '0=Dom, 1=Lun, 2=Mar, 3=Mie, 4=Jue, 5=Vie, 6=Sab',
  `hora_apertura` time NOT NULL DEFAULT '09:00:00',
  `hora_cierre` time NOT NULL DEFAULT '18:00:00',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'false = día cerrado',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insumos_grooming`
--

CREATE TABLE `insumos_grooming` (
  `id` bigint UNSIGNED NOT NULL,
  `ficha_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` decimal(8,2) NOT NULL DEFAULT '1.00',
  `unidad` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unidad' COMMENT 'unidad, ml, g, etc',
  `observacion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_notificaciones`
--

CREATE TABLE `log_notificaciones` (
  `id` int UNSIGNED NOT NULL,
  `notificacion_id` int UNSIGNED NOT NULL,
  `intento` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `exitoso` tinyint(1) NOT NULL DEFAULT '0',
  `respuesta` text,
  `ejecutado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mascotas`
--

CREATE TABLE `mascotas` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especie` varchar(50) NOT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `tamano` enum('xs','s','m','l','xl') NOT NULL DEFAULT 'm',
  `peso_kg` decimal(5,2) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `temperamento` varchar(100) DEFAULT NULL,
  `alergias` text,
  `restricciones_medicas` text,
  `foto_url` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mascota_dueno`
--

CREATE TABLE `mascota_dueno` (
  `mascota_id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED NOT NULL,
  `es_primario` tinyint(1) NOT NULL DEFAULT '0',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `cita_id` int UNSIGNED DEFAULT NULL,
  `tipo_evento` enum('confirmacion','recordatorio_24h','recordatorio_2h','listo_recoger','encuesta','promocion') NOT NULL,
  `canal` enum('email','whatsapp','sms','telegram') NOT NULL,
  `destino` varchar(150) NOT NULL,
  `contenido` text,
  `fecha_programacion` datetime NOT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `estado` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
  `intentos` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `cita_id` bigint UNSIGNED NOT NULL,
  `metodo` enum('efectivo','qr','transferencia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `monto` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `referencia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nro. de transferencia o QR',
  `observaciones` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('pendiente','pagado','anulado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `registrado_por` bigint UNSIGNED DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int UNSIGNED NOT NULL,
  `carrito_id` int UNSIGNED DEFAULT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `estado` enum('pendiente','enviado','confirmado','pagado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `metodo_contacto` enum('whatsapp','telegram') NOT NULL DEFAULT 'whatsapp',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notas` text,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int UNSIGNED NOT NULL,
  `categoria_id` int UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `sku` varchar(100) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `stock_minimo` int UNSIGNED NOT NULL DEFAULT '0',
  `imagen_url` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `promociones`
--

CREATE TABLE `promociones` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('porcentaje','monto_fijo','cliente_frecuente') COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `servicio_id` bigint UNSIGNED DEFAULT NULL,
  `min_citas` int DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_por` bigint UNSIGNED DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `creado_en`) VALUES
(1, 'admin', 'Acceso total al sistema', '2026-05-01 21:57:56'),
(2, 'recepcion', 'Gestión de citas, clientes y caja', '2026-05-01 21:57:56'),
(3, 'groomer', 'Acceso a sus citas y fichas de grooming', '2026-05-01 21:57:56'),
(4, 'cliente', 'Autogestión: citas, mascotas, facturas', '2026-05-01 21:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE `servicios` (
  `id` int UNSIGNED NOT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `duracion_base_minutos` smallint UNSIGNED NOT NULL,
  `factor_tamano_raza` json DEFAULT NULL,
  `consumo_insumos` json DEFAULT NULL,
  `permite_doble_booking` tinyint(1) NOT NULL DEFAULT '0',
  `requiere_bloqueo_consecutivo` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`id`, `sucursal_id`, `nombre`, `descripcion`, `precio_base`, `duracion_base_minutos`, `factor_tamano_raza`, `consumo_insumos`, `permite_doble_booking`, `requiere_bloqueo_consecutivo`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, NULL, 'Baño rápido', 'Baño básico con secado', 50.00, 30, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:46', '2026-05-15 20:19:46'),
(2, NULL, 'Baño completo', 'Baño, secado y perfume', 80.00, 60, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:46', '2026-05-15 20:19:46'),
(3, NULL, 'Corte y peinado', 'Corte de pelo y peinado profesional', 100.00, 90, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:47', '2026-05-15 20:19:47'),
(4, NULL, 'Servicio completo', 'Baño, corte, peinado y perfume', 150.00, 120, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:49', '2026-05-15 20:19:49'),
(5, NULL, 'Baño rápido', 'Baño básico con secado', 50.00, 30, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:20:27', '2026-05-17 22:39:05'),
(6, NULL, 'Baño completo', 'Baño, secado y perfume', 80.00, 60, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:20:53', '2026-05-17 22:39:05'),
(7, NULL, 'Corte y peinado', 'Corte de pelo y peinado profesional', 100.00, 90, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:21:05', '2026-05-17 22:39:05'),
(8, NULL, 'Servicio completo', 'Baño, corte, peinado y perfume', 150.00, 120, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:21:16', '2026-05-17 22:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `sesiones_usuario`
--

CREATE TABLE `sesiones_usuario` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` int UNSIGNED NOT NULL,
  `token_jwt` text NOT NULL,
  `refresh_token` varchar(512) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol_id` bigint UNSIGNED DEFAULT NULL,
  `ci` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedor_oauth` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL DEFAULT '0',
  `token_verificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expira_en` datetime DEFAULT NULL,
  `intentos_fallidos` tinyint NOT NULL DEFAULT '0',
  `bloqueado_hasta` datetime DEFAULT NULL,
  `two_factor_secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_acceso` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int UNSIGNED NOT NULL,
  `rol_id` int UNSIGNED DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `two_factor_secret` varchar(100) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_acceso` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacunas_mascota`
--

CREATE TABLE `vacunas_mascota` (
  `id` int UNSIGNED NOT NULL,
  `mascota_id` int UNSIGNED NOT NULL,
  `nombre_vacuna` varchar(100) NOT NULL,
  `fecha_aplicacion` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variantes_producto`
--

CREATE TABLE `variantes_producto` (
  `id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `sku_variante` varchar(100) NOT NULL,
  `atributo` varchar(50) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `precio_extra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_usuario` (`usuario_id`);

--
-- Indexes for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_logs_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `bloqueos_agenda`
--
ALTER TABLE `bloqueos_agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bloqueos_calendario`
--
ALTER TABLE `bloqueos_calendario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bloqueo_groomer` (`groomer_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `fk_carrito_cliente` (`cliente_id`),
  ADD KEY `idx_carrito_expires` (`expires_at`);

--
-- Indexes for table `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cat_padre` (`padre_id`);

--
-- Indexes for table `checklist_items_catalogo`
--
ALTER TABLE `checklist_items_catalogo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_checklist_cat_servicio` (`servicio_id`);

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_groomer_inicio` (`groomer_id`,`fecha_hora_inicio`),
  ADD KEY `fk_citas_servicio` (`servicio_id`),
  ADD KEY `fk_citas_sucursal` (`sucursal_id`),
  ADD KEY `fk_citas_reprog_id` (`reprogramada_desde_id`),
  ADD KEY `idx_citas_mascota` (`mascota_id`),
  ADD KEY `idx_citas_groomer_fecha` (`groomer_id`,`fecha_hora_inicio`),
  ADD KEY `idx_citas_estado` (`estado`),
  ADD KEY `idx_citas_fecha` (`fecha_hora_inicio`),
  ADD KEY `fk_citas_creador` (`creado_por_usuario_id`),
  ADD KEY `fk_citas_reprog_usr` (`reprogramada_por_id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_clientes_sucursal` (`sucursal_id`);

--
-- Indexes for table `consumo_insumos_ficha`
--
ALTER TABLE `consumo_insumos_ficha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumo_ficha` (`ficha_id`),
  ADD KEY `fk_consumo_producto` (`producto_id`),
  ADD KEY `fk_consumo_variante` (`variante_id`);

--
-- Indexes for table `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_carrito_carrito` (`carrito_id`),
  ADD KEY `fk_det_carrito_producto` (`producto_id`),
  ADD KEY `fk_det_carrito_variante` (`variante_id`);

--
-- Indexes for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_factura` (`factura_id`);

--
-- Indexes for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_pedido_pedido` (`pedido_id`),
  ADD KEY `fk_det_pedido_producto` (`producto_id`),
  ADD KEY `fk_det_pedido_variante` (`variante_id`);

--
-- Indexes for table `disponibilidad_groomer`
--
ALTER TABLE `disponibilidad_groomer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_disp_groomer_dia` (`groomer_id`,`dia_semana`);

--
-- Indexes for table `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cita_id` (`cita_id`),
  ADD KEY `fk_encuesta_cliente` (`cliente_id`);

--
-- Indexes for table `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_factura` (`numero_factura`),
  ADD KEY `fk_factura_cita` (`cita_id`),
  ADD KEY `fk_factura_pedido` (`pedido_id`),
  ADD KEY `fk_factura_sucursal` (`sucursal_id`),
  ADD KEY `idx_facturas_cliente` (`cliente_id`),
  ADD KEY `idx_facturas_estado` (`estado`),
  ADD KEY `idx_facturas_fecha` (`fecha_emision`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fichas_checklist`
--
ALTER TABLE `fichas_checklist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ficha_item` (`ficha_id`,`item_id`),
  ADD KEY `fk_fichas_checklist_item` (`item_id`);

--
-- Indexes for table `fichas_grooming`
--
ALTER TABLE `fichas_grooming`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cita_id` (`cita_id`);

--
-- Indexes for table `fotos_grooming`
--
ALTER TABLE `fotos_grooming`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fotos_ficha` (`ficha_id`);

--
-- Indexes for table `groomers`
--
ALTER TABLE `groomers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_groomers_sucursal` (`sucursal_id`);

--
-- Indexes for table `historial_mascotas`
--
ALTER TABLE `historial_mascotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_historial_mascota` (`mascota_id`,`creado_en`);

--
-- Indexes for table `horarios_spa`
--
ALTER TABLE `horarios_spa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insumos_grooming`
--
ALTER TABLE `insumos_grooming`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_notificaciones`
--
ALTER TABLE `log_notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_noti` (`notificacion_id`);

--
-- Indexes for table `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mascota_dueno`
--
ALTER TABLE `mascota_dueno`
  ADD PRIMARY KEY (`mascota_id`,`cliente_id`),
  ADD KEY `fk_md_cliente` (`cliente_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_noti_cita` (`cita_id`),
  ADD KEY `idx_noti_programacion` (`fecha_programacion`,`estado`),
  ADD KEY `idx_noti_cliente` (`cliente_id`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_carrito` (`carrito_id`),
  ADD KEY `fk_pedido_sucursal` (`sucursal_id`),
  ADD KEY `idx_pedidos_cliente` (`cliente_id`),
  ADD KEY `idx_pedidos_estado` (`estado`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `fk_productos_sucursal` (`sucursal_id`),
  ADD KEY `idx_prod_categoria` (`categoria_id`),
  ADD KEY `idx_prod_stock` (`stock`,`stock_minimo`);

--
-- Indexes for table `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicios_sucursal` (`sucursal_id`);

--
-- Indexes for table `sesiones_usuario`
--
ALTER TABLE `sesiones_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `refresh_token` (`refresh_token`),
  ADD KEY `fk_sesiones_usuario` (`usuario_id`),
  ADD KEY `idx_sesiones_token` (`refresh_token`),
  ADD KEY `idx_sesiones_expiracion` (`fecha_expiracion`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_rol` (`rol_id`);

--
-- Indexes for table `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vacunas_mascota` (`mascota_id`);

--
-- Indexes for table `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku_variante` (`sku_variante`),
  ADD KEY `fk_variante_producto` (`producto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_logs`
--
ALTER TABLE `auth_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bloqueos_agenda`
--
ALTER TABLE `bloqueos_agenda`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bloqueos_calendario`
--
ALTER TABLE `bloqueos_calendario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checklist_items_catalogo`
--
ALTER TABLE `checklist_items_catalogo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consumo_insumos_ficha`
--
ALTER TABLE `consumo_insumos_ficha`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disponibilidad_groomer`
--
ALTER TABLE `disponibilidad_groomer`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fichas_checklist`
--
ALTER TABLE `fichas_checklist`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fichas_grooming`
--
ALTER TABLE `fichas_grooming`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fotos_grooming`
--
ALTER TABLE `fotos_grooming`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groomers`
--
ALTER TABLE `groomers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historial_mascotas`
--
ALTER TABLE `historial_mascotas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horarios_spa`
--
ALTER TABLE `horarios_spa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insumos_grooming`
--
ALTER TABLE `insumos_grooming`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_notificaciones`
--
ALTER TABLE `log_notificaciones`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sesiones_usuario`
--
ALTER TABLE `sesiones_usuario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variantes_producto`
--
ALTER TABLE `variantes_producto`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `fk_audit_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD CONSTRAINT `auth_logs_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bloqueos_calendario`
--
ALTER TABLE `bloqueos_calendario`
  ADD CONSTRAINT `fk_bloqueo_groomer` FOREIGN KEY (`groomer_id`) REFERENCES `groomers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `fk_carrito_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD CONSTRAINT `fk_cat_padre` FOREIGN KEY (`padre_id`) REFERENCES `categorias_productos` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `checklist_items_catalogo`
--
ALTER TABLE `checklist_items_catalogo`
  ADD CONSTRAINT `fk_checklist_cat_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_creador` FOREIGN KEY (`creado_por_usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_citas_groomer` FOREIGN KEY (`groomer_id`) REFERENCES `groomers` (`id`),
  ADD CONSTRAINT `fk_citas_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_citas_reprog_id` FOREIGN KEY (`reprogramada_desde_id`) REFERENCES `citas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_citas_reprog_usr` FOREIGN KEY (`reprogramada_por_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_citas_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `fk_citas_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_clientes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consumo_insumos_ficha`
--
ALTER TABLE `consumo_insumos_ficha`
  ADD CONSTRAINT `fk_consumo_ficha` FOREIGN KEY (`ficha_id`) REFERENCES `fichas_grooming` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_consumo_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_consumo_variante` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `fk_det_carrito_carrito` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_det_carrito_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_det_carrito_variante` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `fk_det_factura` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_det_pedido_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_det_pedido_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_det_pedido_variante` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `disponibilidad_groomer`
--
ALTER TABLE `disponibilidad_groomer`
  ADD CONSTRAINT `fk_disp_groomer` FOREIGN KEY (`groomer_id`) REFERENCES `groomers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  ADD CONSTRAINT `fk_encuesta_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_encuesta_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_factura_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_factura_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_factura_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_factura_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fichas_checklist`
--
ALTER TABLE `fichas_checklist`
  ADD CONSTRAINT `fk_fichas_checklist_ficha` FOREIGN KEY (`ficha_id`) REFERENCES `fichas_grooming` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fichas_checklist_item` FOREIGN KEY (`item_id`) REFERENCES `checklist_items_catalogo` (`id`);

--
-- Constraints for table `fichas_grooming`
--
ALTER TABLE `fichas_grooming`
  ADD CONSTRAINT `fk_fichas_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fotos_grooming`
--
ALTER TABLE `fotos_grooming`
  ADD CONSTRAINT `fk_fotos_ficha` FOREIGN KEY (`ficha_id`) REFERENCES `fichas_grooming` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groomers`
--
ALTER TABLE `groomers`
  ADD CONSTRAINT `fk_groomers_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_groomers_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `historial_mascotas`
--
ALTER TABLE `historial_mascotas`
  ADD CONSTRAINT `fk_historial_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_notificaciones`
--
ALTER TABLE `log_notificaciones`
  ADD CONSTRAINT `fk_log_noti` FOREIGN KEY (`notificacion_id`) REFERENCES `notificaciones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mascota_dueno`
--
ALTER TABLE `mascota_dueno`
  ADD CONSTRAINT `fk_md_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_md_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_noti_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_noti_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_carrito` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pedido_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_productos_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sesiones_usuario`
--
ALTER TABLE `sesiones_usuario`
  ADD CONSTRAINT `fk_sesiones_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD CONSTRAINT `fk_vacunas_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD CONSTRAINT `fk_variante_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
