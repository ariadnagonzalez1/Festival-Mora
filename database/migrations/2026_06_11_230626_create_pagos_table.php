<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compra_id')
                ->constrained('compras')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('tipo_integracion', ['qr_mercado_pago', 'checkout_pro'])
                ->default('qr_mercado_pago');

            $table->string('mercado_pago_preference_id', 255)->nullable();
            $table->string('mercado_pago_payment_id', 255)->nullable()->unique();
            $table->string('mercado_pago_order_id', 255)->nullable();
            $table->string('mercado_pago_qr_id', 255)->nullable();

            $table->string('external_reference', 150)->nullable();

            $table->enum('estado_pago', ['pendiente', 'aprobado', 'rechazado', 'cancelado', 'reembolsado'])
                ->default('pendiente');

            $table->enum('qr_pago_estado', ['generado', 'escaneado', 'pagado', 'expirado', 'cancelado'])
                ->default('generado');

            $table->longText('qr_pago_payload')->nullable();

            $table->decimal('monto', 12, 2)->default(0.00);
            $table->string('moneda', 10)->default('ARS');

            $table->string('metodo_pago', 100)->nullable();
            $table->string('tipo_pago', 100)->nullable();

            $table->string('nombre_receptor', 150)->nullable();
            $table->string('concepto_pago', 255)->nullable();

            $table->dateTime('fecha_aprobacion')->nullable();

            $table->timestamps();

            $table->index('estado_pago');
            $table->index('external_reference');
            $table->index('compra_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};