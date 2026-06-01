<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->string('clave', 100)->primary();
            $table->string('valor', 500);
            $table->string('descripcion', 300)->nullable();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });

        // Valores por defecto
        DB::table('configuracion')->insert([
            ['clave' => 'limite_insumos_semana', 'valor' => '20', 'descripcion' => 'Límite de insumos por groomer por semana antes de generar alerta'],
            ['clave' => 'horas_cancelacion', 'valor' => '24', 'descripcion' => 'Horas mínimas de anticipación para cancelar una cita'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('configuracion');
    }
};