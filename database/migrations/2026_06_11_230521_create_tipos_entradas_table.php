<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_entradas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evento_id')
                ->constrained('eventos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();

            $table->decimal('precio', 12, 2)->default(0.00);

            $table->integer('stock_total')->default(0);
            $table->integer('stock_disponible')->default(0);
            $table->integer('stock_reservado')->default(0);
            $table->integer('stock_vendido')->default(0);

            $table->integer('umbral_bajo_stock')->default(10);

            $table->boolean('activo')->default(true);

            $table->boolean('venta_online')->default(true);
            $table->boolean('venta_fisica')->default(false);

            $table->enum('metodo_pago', ['qr_mercado_pago', 'efectivo', 'ambos'])
                ->default('qr_mercado_pago');

            $table->string('ubicacion_descripcion', 255)->nullable();

            $table->timestamps();

            $table->index('evento_id');
            $table->index('venta_online');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_entradas');
    }
};