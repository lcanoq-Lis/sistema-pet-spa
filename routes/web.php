<?php

// 1. CONTROLADORES DE AUTENTICACIÓN Y SISTEMA
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\PasswordController;

// 2. CONTROLADORES POR ROLES / MÓDULOS
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\NotificacionController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\ProductoController;

use App\Http\Controllers\Recepcion\CitaController as RecepcionCitaController;
use App\Http\Controllers\Recepcion\PagoController;
use App\Http\Controllers\Recepcion\CalendarioController;

use App\Http\Controllers\Groomer\AgendaController;
use App\Http\Controllers\Groomer\FichaController;

use App\Http\Controllers\Cliente\MascotaController;
use App\Http\Controllers\Cliente\CitaController;
use App\Http\Controllers\Cliente\TiendaController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Recepcion\ClienteController as RecepcionClienteController;

use Illuminate\Support\Facades\Schedule;

use App\Http\Controllers\Admin\PromocionController;

use App\Http\Controllers\Cliente\PerfilController;

Schedule::command('citas:recordatorios')->dailyAt('08:00');
Schedule::command('recordatorios:enviar')->hourly();
Schedule::command('groomers:alerta-consumo')->dailyAt('07:00');
/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin necesidad de Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Autenticación tradicional
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Recuperación de Contraseña
Route::get('/recuperar-password', [PasswordController::class, 'showRecuperar'])->name('password.recuperar');
Route::post('/recuperar-password', [PasswordController::class, 'recuperar'])->name('password.recuperar.post');
Route::get('/reset-password', [PasswordController::class, 'showReset'])->name('password.reset.form');
Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.reset.post');

// Verificación de email
Route::get('/verificar-email', [VerificationController::class, 'verificar'])->name('verificar.email');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Login y AutoLogout)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->group(function () {

    // Dashboard Común & Seguridad 2FA
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/2fa/setup', [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/activate', [TwoFactorController::class, 'activate'])->name('2fa.activate');
    Route::get('/2fa/verify', [TwoFactorController::class, 'index'])->name('2fa.verify');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');

    // Gestión de perfil (Password interna)
    Route::get('/cambiar-password', [PasswordController::class, 'showCambiar'])->name('password.cambiar');
    Route::post('/cambiar-password', [PasswordController::class, 'cambiar'])->name('password.cambiar.post');

    // --------------------------------------------------------------------
    // GRUPO: CLIENTES
    // --------------------------------------------------------------------
    Route::prefix('cliente')->name('cliente.')->group(function () {
        // Citas e Historial
        Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
        Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
        Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');
        Route::get('/historial', [CitaController::class, 'historial'])->name('historial');

        // Mascotas & Vacunas
        Route::post('/mascotas/{id}/vacuna', [MascotaController::class, 'agregarVacuna'])->name('mascotas.vacuna');
        Route::resource('mascotas', MascotaController::class);
        
        // Tienda dentro del contexto del cliente
        Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');

        Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
        Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
        Route::post('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');
    });

    // --------------------------------------------------------------------
    // GRUPO: GROOMERS
    // --------------------------------------------------------------------
    Route::prefix('groomer')->name('groomer.')->group(function () {
        // Agenda
        Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::post('/agenda/{id}/confirmar', [AgendaController::class, 'confirmar'])->name('agenda.confirmar');
        Route::post('/agenda/{id}/cancelar', [AgendaController::class, 'cancelar'])->name('agenda.cancelar');

        // Fichas de Grooming
        Route::get('/ficha/crear/{citaId}', [FichaController::class, 'create'])->name('ficha.create');
        Route::post('/ficha', [FichaController::class, 'store'])->name('ficha.store');
        Route::get('/ficha/{id}/editar', [FichaController::class, 'edit'])->name('ficha.edit');
        
        // CORREGIDO: Ahora sí acepta PUT para coincidir perfectamente con edit.blade.php
        Route::put('/ficha/{id}/actualizar', [FichaController::class, 'update'])->name('ficha.update'); 
        Route::post('/ficha/{id}/cerrar', [FichaController::class, 'cerrar'])->name('ficha.cerrar');
        
        // Fotos de Evidencia
        Route::post('/ficha/{id}/foto', [FichaController::class, 'agregarFoto'])->name('ficha.foto');
        
        // Ajustado de {fotoId} a {id} para mantener consistencia semántica en los parámetros
        Route::delete('/ficha/foto/{id}', [FichaController::class, 'eliminarFoto'])->name('ficha.foto.eliminar');
    
        // Insumos de la Ficha
        Route::post('/ficha/{id}/insumo', [FichaController::class, 'storeInsumo'])->name('ficha.insumo.store');
        Route::delete('/ficha/{fichaId}/insumo/{insumoId}', [FichaController::class, 'destroyInsumo'])->name('ficha.insumo.destroy');
    });

    // --------------------------------------------------------------------
// GRUPO: RECEPCIÓN
// --------------------------------------------------------------------
Route::prefix('recepcion')->name('recepcion.')->group(function () {

    // Citas
    Route::get('/citas', [RecepcionCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas/{id}/confirmar', [RecepcionCitaController::class, 'confirmar'])->name('citas.confirmar');
    Route::post('/citas/{id}/iniciar', [RecepcionCitaController::class, 'iniciar'])->name('citas.iniciar');
    Route::post('/citas/{id}/completar', [RecepcionCitaController::class, 'completar'])->name('citas.completar');
    Route::post('/citas/{id}/cancelar', [RecepcionCitaController::class, 'cancelar'])->name('citas.cancelar');
    Route::post('/citas/{id}/reprogramar', [RecepcionCitaController::class, 'reprogramar'])->name('citas.reprogramar');
    Route::get('/solicitudes', [RecepcionCitaController::class, 'solicitudes'])->name('solicitudes.index');

    // Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');
    Route::get('/calendario/eventos', [CalendarioController::class, 'eventos'])->name('calendario.eventos');
    Route::patch('/citas/{id}/mover', [CalendarioController::class, 'moverCita'])->name('citas.mover');

    // Pagos
    Route::post('/pagos/promo-calcular', [PagoController::class, 'calcularPromocion'])->name('pagos.promo.calcular');
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/pagos/cita/{citaId}', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos/cita/{citaId}', [PagoController::class, 'store'])->name('pagos.store');
    Route::get('/pagos/cierre', [PagoController::class, 'cierreCaja'])->name('pagos.cierre');
    Route::get('/pagos/{pagoId}/factura', [PagoController::class, 'factura'])->name('pagos.factura');
    Route::patch('/pagos/{pagoId}/anular', [PagoController::class, 'anular'])->name('pagos.anular');

    // Clientes
    Route::get('/clientes', [RecepcionClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [RecepcionClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [RecepcionClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}/mascota/crear', [RecepcionClienteController::class, 'createMascota'])->name('clientes.mascota.create');
    Route::post('/clientes/{id}/mascota', [RecepcionClienteController::class, 'storeMascota'])->name('clientes.mascota.store');
    Route::get('/clientes/{id}', [RecepcionClienteController::class, 'show'])->name('clientes.show');

});

    // --------------------------------------------------------------------
    // GRUPO: ADMINISTRACIÓN (ADMIN)
    // --------------------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/promociones', [PromocionController::class, 'index'])->name('promociones.index');
        Route::post('/promociones', [PromocionController::class, 'store'])->name('promociones.store');
        Route::patch('/promociones/{id}/toggle', [PromocionController::class, 'toggle'])->name('promociones.toggle');
        Route::delete('/promociones/{id}', [PromocionController::class, 'destroy'])->name('promociones.destroy');
        // CRUDs Estándar
        Route::resource('servicios', ServicioController::class);
        Route::resource('productos', ProductoController::class);

        // Gestión de Personal
        Route::get('/personal', [PersonalController::class, 'index'])->name('personal.index');
        Route::get('/personal/crear', [PersonalController::class, 'create'])->name('personal.create');
        Route::post('/personal', [PersonalController::class, 'store'])->name('personal.store');
        Route::delete('/personal/{id}', [PersonalController::class, 'destroy'])->name('personal.destroy');

        // Horarios de atención y bloqueos
        Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
        Route::post('/horarios/actualizar', [HorarioController::class, 'actualizarHorario'])->name('horarios.actualizar');
        Route::post('/horarios/bloqueo', [HorarioController::class, 'storeBloqueo'])->name('horarios.bloqueo.store');
        Route::delete('/horarios/bloqueo/{id}', [HorarioController::class, 'destroyBloqueo'])->name('horarios.bloqueo.destroy');

        // Paneles de control y reportes
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::get('/auditoria', [AuditController::class, 'index'])->name('auditoria.index');
        Route::post('/configuracion', [HorarioController::class, 'guardarConfiguracion'])->name('configuracion.guardar');
        Route::get('/servicios/{id}/checklist', [ServicioController::class, 'checklist'])->name('servicios.checklist');
Route::post('/servicios/{id}/checklist', [ServicioController::class, 'guardarChecklist'])->name('servicios.checklist.guardar');
    });

});