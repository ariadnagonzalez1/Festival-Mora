<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_notificaciones', function (Blueprint $table) {
            $table->id();

            $table->boolean('email_comprador_confirmacion')->default(true);
            $table->boolean('email_admin_nueva_compra')->default(true);
            $table->boolean('recordatorio_24hs_comprador')->default(true);
            $table->boolean('alerta_bajo_stock_admin')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_notificaciones');
    }
};