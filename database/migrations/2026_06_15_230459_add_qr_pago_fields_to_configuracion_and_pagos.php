<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('configuracion_mercado_pago', 'pos_external_id')) {
            Schema::table('configuracion_mercado_pago', function (Blueprint $table) {
                $table->string('pos_external_id')->nullable()->after('public_key');
            });
        }

        if (! Schema::hasColumn('configuracion_mercado_pago', 'nombre_receptor')) {
            Schema::table('configuracion_mercado_pago', function (Blueprint $table) {
                $table->string('nombre_receptor')->default('Mora Producciones')->after('pos_external_id');
            });
        }

        if (! Schema::hasColumn('compras', 'external_reference')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->string('external_reference')->nullable()->after('codigo_compra');
            });
        }

        if (! Schema::hasColumn('pagos', 'qr_pago_data')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->longText('qr_pago_data')->nullable()->after('qr_pago_estado');
            });
        }

        if (! Schema::hasColumn('pagos', 'mercado_pago_order_id')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->string('mercado_pago_order_id')->nullable()->after('tipo_integracion');
            });
        }

        if (! Schema::hasColumn('pagos', 'external_reference')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->string('external_reference')->nullable()->after('mercado_pago_order_id');
            });
        }

        if (! Schema::hasColumn('pagos', 'nombre_receptor')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->string('nombre_receptor')->nullable()->after('moneda');
            });
        }

        if (! Schema::hasColumn('pagos', 'concepto_pago')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->string('concepto_pago')->nullable()->after('nombre_receptor');
            });
        }
    }

    public function down(): void
    {
        //
    }
};