<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'rol_id')) {
                $table->unsignedInteger('rol_id')->nullable();
                $table->foreign('rol_id')->references('id')->on('roles')->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'ci'))
                $table->string('ci', 20)->nullable();
            if (!Schema::hasColumn('users', 'proveedor_oauth'))
                $table->string('proveedor_oauth', 50)->nullable();
            if (!Schema::hasColumn('users', 'oauth_id'))
                $table->string('oauth_id', 255)->nullable();
            if (!Schema::hasColumn('users', 'email_verificado'))
                $table->boolean('email_verificado')->default(false);
            if (!Schema::hasColumn('users', 'token_verificacion'))
                $table->string('token_verificacion', 255)->nullable();
            if (!Schema::hasColumn('users', 'token_expira_en'))
                $table->dateTime('token_expira_en')->nullable();
            if (!Schema::hasColumn('users', 'intentos_fallidos'))
                $table->tinyInteger('intentos_fallidos')->default(0);
            if (!Schema::hasColumn('users', 'bloqueado_hasta'))
                $table->dateTime('bloqueado_hasta')->nullable();
            if (!Schema::hasColumn('users', 'two_factor_secret'))
                $table->string('two_factor_secret', 100)->nullable();
            if (!Schema::hasColumn('users', 'two_factor_enabled'))
                $table->boolean('two_factor_enabled')->default(false);
            if (!Schema::hasColumn('users', 'ultimo_acceso'))
                $table->dateTime('ultimo_acceso')->nullable();
            if (!Schema::hasColumn('users', 'activo'))
                $table->boolean('activo')->default(true);
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'rol_id', 'ci', 'proveedor_oauth', 'oauth_id',
                'email_verificado', 'token_verificacion', 'token_expira_en',
                'intentos_fallidos', 'bloqueado_hasta', 'two_factor_secret',
                'two_factor_enabled', 'ultimo_acceso', 'activo'
            ]);
        });
    }
};