<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            $table->string('titulo', 200);
            $table->string('slug', 220)->unique();
            $table->text('descripcion')->nullable();

            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();

            $table->string('lugar', 200)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('provincia', 100)->nullable();

            $table->text('imagen_url')->nullable();

            $table->enum('estado', ['borrador', 'publicado', 'cancelado', 'finalizado'])
                ->default('borrador');

            $table->boolean('mostrar_en_banner')->default(false);
            $table->boolean('mostrar_en_inicio')->default(true);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};