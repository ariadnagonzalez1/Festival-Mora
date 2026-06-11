<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validaciones_qr', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entrada_id')
                ->nullable()
                ->constrained('entradas')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('admin_id')
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('codigo_qr_ingresado', 255);

            $table->enum('resultado', [
                'valida',
                'ya_usada',
                'invalida',
                'pago_no_aprobado',
                'evento_no_corresponde'
            ]);

            $table->text('mensaje')->nullable();

            $table->dateTime('fecha_validacion')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamp('created_at')->useCurrent();

            $table->index('codigo_qr_ingresado');
            $table->index('resultado');
            $table->index('admin_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validaciones_qr');
    }
};