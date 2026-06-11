<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_productora', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_comercial', 150);
            $table->string('razon_social', 150)->nullable();
            $table->string('cuit', 20)->nullable();
            $table->string('email_contacto', 150)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->text('bio_publica')->nullable();

            $table->text('logo_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('tiktok_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_productora');
    }
};