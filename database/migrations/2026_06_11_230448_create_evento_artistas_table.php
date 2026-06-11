<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evento_artistas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evento_id')
                ->constrained('eventos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('artista_id')
                ->constrained('artistas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->integer('orden')->default(0);

            $table->timestamps();

            $table->unique(['evento_id', 'artista_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evento_artistas');
    }
};