<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('groomers')) {
            Schema::create('groomers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->string('nombre', 100);
                $table->string('apellido', 100)->nullable();
                $table->string('telefono', 30)->nullable();
                $table->string('especialidad', 150)->nullable();
                $table->tinyInteger('capacidad_simultanea')->default(1);
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('groomers');
    }
};