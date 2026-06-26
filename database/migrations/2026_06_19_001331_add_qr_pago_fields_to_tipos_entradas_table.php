<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tipos_entradas', function (Blueprint $table) {
            $table->string('qr_pago_codigo')->nullable()->unique()->after('venta_online');
            $table->longText('qr_pago_data')->nullable()->after('qr_pago_codigo');
            $table->string('qr_pago_receptor')->nullable()->after('qr_pago_data');
            $table->string('qr_pago_concepto')->nullable()->after('qr_pago_receptor');
            $table->decimal('qr_pago_monto', 12, 2)->nullable()->after('qr_pago_concepto');
            $table->string('qr_pago_estado')->default('generado')->after('qr_pago_monto');
            $table->timestamp('qr_pago_generado_at')->nullable()->after('qr_pago_estado');
        });
    }

    public function down(): void
    {
        Schema::table('tipos_entradas', function (Blueprint $table) {
            $table->dropColumn([
                'qr_pago_codigo',
                'qr_pago_data',
                'qr_pago_receptor',
                'qr_pago_concepto',
                'qr_pago_monto',
                'qr_pago_estado',
                'qr_pago_generado_at',
            ]);
        });
    }
};