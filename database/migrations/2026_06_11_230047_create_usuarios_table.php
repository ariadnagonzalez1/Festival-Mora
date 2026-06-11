<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rol_id')
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 20)->unique();
            $table->string('email', 150)->unique();
            $table->string('telefono', 30)->nullable();

            $table->text('password_hash');

            $table->boolean('bloqueado')->default(false);
            $table->dateTime('fecha_bloqueo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};