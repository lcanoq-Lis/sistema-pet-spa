<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bloqueos_agenda', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('tipo', ['feriado', 'mantenimiento', 'ausencia', 'otro'])->default('otro');
            $table->string('motivo', 200);
            $table->unsignedBigInteger('groomer_id')->nullable();
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bloqueos_agenda');
    }
};