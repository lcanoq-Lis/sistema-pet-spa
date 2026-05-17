<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 50)->unique();
                $table->string('descripcion', 255)->nullable();
                $table->timestamps();
            });

            DB::table('roles')->insert([
                ['nombre' => 'admin',     'descripcion' => 'Acceso total al sistema'],
                ['nombre' => 'recepcion', 'descripcion' => 'Gestión de citas y caja'],
                ['nombre' => 'groomer',   'descripcion' => 'Acceso a sus citas y fichas'],
                ['nombre' => 'cliente',   'descripcion' => 'Autogestión de cuenta'],
            ]);
        }
    }

    public function down(): void {
        Schema::dropIfExists('roles');
    }
};