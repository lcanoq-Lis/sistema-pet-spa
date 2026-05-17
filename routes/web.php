<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Cliente\MascotaController;
use App\Http\Controllers\Cliente\CitaController;
use App\Http\Controllers\Recepcion\CitaController as RecepcionCitaController;
use App\Http\Controllers\Groomer\AgendaController;
use App\Http\Controllers\Groomer\FichaController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\NotificacionController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\ServicioController;

Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('servicios', ServicioController::class)->names([
        'index'   => 'servicios.index',
        'create'  => 'servicios.create',
        'store'   => 'servicios.store',
        'edit'    => 'servicios.edit',
        'update'  => 'servicios.update',
        'destroy' => 'servicios.destroy',
    ]);
});

Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

Route::post('/agenda/{id}/confirmar', [AgendaController::class, 'confirmar'])->name('agenda.confirmar');
Route::post('/agenda/{id}/cancelar', [AgendaController::class, 'cancelar'])->name('agenda.cancelar');
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
});

Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/auditoria', [AuditController::class, 'index'])->name('auditoria.index');
});

// Recuperar contraseña (sin login)
Route::get('/recuperar-password', [PasswordController::class, 'showRecuperar'])->name('password.recuperar');
Route::post('/recuperar-password', [PasswordController::class, 'recuperar'])->name('password.recuperar.post');
Route::get('/reset-password', [PasswordController::class, 'showReset'])->name('password.reset.form');
Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.reset.post');

// Cambiar contraseña (con login)
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->group(function () {
    Route::get('/cambiar-password', [PasswordController::class, 'showCambiar'])->name('password.cambiar');
    Route::post('/cambiar-password', [PasswordController::class, 'cambiar'])->name('password.cambiar.post');
});

Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('groomer')->name('groomer.')->group(function () {
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda/{id}/confirmar', [AgendaController::class, 'confirmar'])->name('agenda.confirmar');
    Route::post('/agenda/{id}/cancelar', [AgendaController::class, 'cancelar'])->name('agenda.cancelar');
    Route::get('/ficha/crear/{citaId}', [FichaController::class, 'create'])->name('ficha.create');
    Route::post('/ficha', [FichaController::class, 'store'])->name('ficha.store');
    Route::get('/ficha/{id}/editar', [FichaController::class, 'edit'])->name('ficha.edit');
    Route::post('/ficha/{id}/actualizar', [FichaController::class, 'update'])->name('ficha.update');
    Route::post('/ficha/{id}/cerrar', [FichaController::class, 'cerrar'])->name('ficha.cerrar');
});

Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('recepcion')->name('recepcion.')->group(function () {
    Route::get('/citas', [RecepcionCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas/{id}/confirmar', [RecepcionCitaController::class, 'confirmar'])->name('citas.confirmar');
    Route::post('/citas/{id}/iniciar', [RecepcionCitaController::class, 'iniciar'])->name('citas.iniciar');
    Route::post('/citas/{id}/completar', [RecepcionCitaController::class, 'completar'])->name('citas.completar');
    Route::post('/citas/{id}/cancelar', [RecepcionCitaController::class, 'cancelar'])->name('citas.cancelar');
});

Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->group(function () {
    Route::get('/cliente/citas', [CitaController::class, 'index'])->name('cliente.citas.index');
    Route::get('/cliente/citas/crear', [CitaController::class, 'create'])->name('cliente.citas.create');
    Route::post('/cliente/citas', [CitaController::class, 'store'])->name('cliente.citas.store');
    Route::delete('/cliente/citas/{id}', [CitaController::class, 'destroy'])->name('cliente.citas.destroy');
});

// Mascotas del cliente
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->group(function () {
    Route::resource('cliente/mascotas', MascotaController::class)
        ->names('cliente.mascotas');
});
// Panel Admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/personal', [PersonalController::class, 'index'])->name('personal.index');
    Route::get('/personal/crear', [PersonalController::class, 'create'])->name('personal.create');
    Route::post('/personal', [PersonalController::class, 'store'])->name('personal.store');
    Route::delete('/personal/{id}', [PersonalController::class, 'destroy'])->name('personal.destroy');
});

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Rutas de Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de Registro
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Verificación de email
Route::get('/verificar-email', [VerificationController::class, 'verificar'])->name('verificar.email');

// Rutas protegidas
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2FA
    Route::get('/2fa/setup', [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/activate', [TwoFactorController::class, 'activate'])->name('2fa.activate');
    Route::get('/2fa/verify', [TwoFactorController::class, 'index'])->name('2fa.verify');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');
});
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Cliente\TiendaController;

// Admin - Productos
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('productos', ProductoController::class)->names([
        'index'   => 'productos.index',
        'create'  => 'productos.create',
        'store'   => 'productos.store',
        'edit'    => 'productos.edit',
        'update'  => 'productos.update',
        'destroy' => 'productos.destroy',
    ]);
});

// Tienda para clientes
Route::middleware(['auth', \App\Http\Middleware\AutoLogout::class])->group(function () {
    Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');
});