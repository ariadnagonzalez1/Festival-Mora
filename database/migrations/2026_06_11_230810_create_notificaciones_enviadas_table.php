<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones_enviadas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('compra_id')
                ->nullable()
                ->constrained('compras')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('evento_id')
                ->nullable()
                ->constrained('eventos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('tipo', [
                'confirmacion_compra',
                'nueva_compra_admin',
                'recordatorio_24hs',
                'bajo_stock'
            ]);

            $table->string('email_destino', 150);

            $table->string('asunto', 255)->nullable();
            $table->text('cuerpo')->nullable();

            $table->enum('estado_envio', ['pendiente', 'enviado', 'fallido'])
                ->default('pendiente');

            $table->dateTime('fecha_envio')->nullable();
            $table->text('mensaje_error')->nullable();

            $table->timestamps();

            $table->index('tipo');
            $table->index('estado_envio');
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones_enviadas');
    }
};