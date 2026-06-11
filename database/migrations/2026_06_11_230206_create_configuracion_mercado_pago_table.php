<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_mercado_pago', function (Blueprint $table) {
            $table->id();

            $table->text('public_key')->nullable();
            $table->text('access_token_encriptado')->nullable();
            $table->text('webhook_url')->nullable();
            $table->text('webhook_secret_encriptado')->nullable();

            $table->string('collector_id', 255)->nullable();
            $table->string('pos_external_id', 255)->nullable();
            $table->string('store_id', 255)->nullable();

            $table->enum('modo', ['test', 'produccion'])->default('test');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_mercado_pago');
    }
};