<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compra_id')
                ->constrained('compras')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('evento_id')
                ->constrained('eventos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('tipo_entrada_id')
                ->constrained('tipos_entradas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('cantidad')->default(1);

            $table->string('nombre_evento', 200);
            $table->string('nombre_tipo_entrada', 100);

            $table->decimal('precio_unitario', 12, 2)->default(0.00);
            $table->decimal('subtotal', 12, 2)->default(0.00);

            $table->timestamps();

            $table->index('compra_id');
            $table->index('evento_id');
            $table->index('tipo_entrada_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_items');
    }
};