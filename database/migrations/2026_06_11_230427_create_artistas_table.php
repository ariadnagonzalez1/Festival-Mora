<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artistas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 150);
            $table->string('genero', 100)->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('foto_url')->nullable();
            $table->text('bio')->nullable();

            $table->boolean('destacado')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artistas');
    }
};