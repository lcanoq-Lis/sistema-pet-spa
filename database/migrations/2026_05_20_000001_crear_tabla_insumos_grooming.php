<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('insumos_grooming', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ficha_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('cantidad', 8, 2)->default(1);
            $table->string('unidad', 30)->default('unidad')->comment('unidad, ml, g, etc');
            $table->string('observacion', 200)->nullable();
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    public function down(): void {
        Schema::dropIfExists('insumos_grooming');
    }
};
