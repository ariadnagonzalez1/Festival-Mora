<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compra_id')
                ->constrained('compras')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('compra_item_id')
                ->constrained('compra_items')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('evento_id')
                ->constrained('eventos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('tipo_entrada_id')
                ->constrained('tipos_entradas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('sector_nombre', 100)->nullable();
            $table->string('ubicacion_texto', 255)->nullable();
            $table->decimal('precio_pagado', 12, 2)->nullable();

            $table->string('codigo_qr', 255)->unique();

            $table->enum('estado_uso', ['no_usada', 'usada'])
                ->default('no_usada');

            $table->dateTime('fecha_uso')->nullable();

            $table->foreignId('usada_por_admin_id')
                ->nullable()
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre_comprador', 100)->nullable();
            $table->string('apellido_comprador', 100)->nullable();
            $table->string('dni_comprador', 20)->nullable();
            $table->string('email_comprador', 150)->nullable();

            $table->timestamps();

            $table->index('usuario_id');
            $table->index('evento_id');
            $table->index('estado_uso');
            $table->index('codigo_qr');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};