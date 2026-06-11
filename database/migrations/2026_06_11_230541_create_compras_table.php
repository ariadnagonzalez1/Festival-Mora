<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('codigo_compra', 100)->unique();
            $table->string('external_reference', 150)->unique();

            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada', 'expirada'])
                ->default('pendiente');

            $table->decimal('total', 12, 2)->default(0.00);

            $table->string('comprador_nombre', 100)->nullable();
            $table->string('comprador_apellido', 100)->nullable();
            $table->string('comprador_dni', 20)->nullable();
            $table->string('comprador_email', 150)->nullable();
            $table->string('comprador_telefono', 30)->nullable();

            $table->timestamps();

            $table->index('usuario_id');
            $table->index('estado');
            $table->index('external_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};