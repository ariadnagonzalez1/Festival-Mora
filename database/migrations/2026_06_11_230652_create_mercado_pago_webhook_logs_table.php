<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mercado_pago_webhook_logs', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_evento', 100)->nullable();
            $table->string('mercado_pago_id', 255)->nullable();

            $table->longText('payload')->nullable();

            $table->boolean('firma_valida')->default(false);
            $table->boolean('procesado')->default(false);

            $table->text('mensaje_error')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index('mercado_pago_id');
            $table->index('procesado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mercado_pago_webhook_logs');
    }
};