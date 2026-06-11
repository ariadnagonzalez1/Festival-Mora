<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\TipoEntrada;

class TiposEntradasSeeder extends Seeder
{
    public function run(): void
    {
        $evento = Evento::where('slug', 'festival-mora-2026')->first();

        if (!$evento) {
            return;
        }

        TipoEntrada::updateOrCreate(
            [
                'evento_id' => $evento->id,
                'nombre' => 'VIP Plata de pie',
            ],
            [
                'descripcion' => 'Entrada VIP Plata de pie. Venta online con QR de Mercado Pago.',
                'precio' => 20000.00,
                'stock_total' => 300,
                'stock_disponible' => 300,
                'stock_reservado' => 0,
                'stock_vendido' => 0,
                'umbral_bajo_stock' => 20,
                'activo' => true,
                'venta_online' => true,
                'venta_fisica' => false,
                'metodo_pago' => 'qr_mercado_pago',
                'ubicacion_descripcion' => 'Sector VIP Plata de pie',
            ]
        );

        TipoEntrada::updateOrCreate(
            [
                'evento_id' => $evento->id,
                'nombre' => 'General',
            ],
            [
                'descripcion' => 'Entrada general. Venta online con QR de Mercado Pago.',
                'precio' => 15000.00,
                'stock_total' => 500,
                'stock_disponible' => 500,
                'stock_reservado' => 0,
                'stock_vendido' => 0,
                'umbral_bajo_stock' => 30,
                'activo' => true,
                'venta_online' => true,
                'venta_fisica' => false,
                'metodo_pago' => 'qr_mercado_pago',
                'ubicacion_descripcion' => 'Sector General',
            ]
        );

        TipoEntrada::updateOrCreate(
            [
                'evento_id' => $evento->id,
                'nombre' => 'VIP Oro',
            ],
            [
                'descripcion' => 'Entrada VIP Oro. Solo venta presencial en efectivo.',
                'precio' => 0.00,
                'stock_total' => 0,
                'stock_disponible' => 0,
                'stock_reservado' => 0,
                'stock_vendido' => 0,
                'umbral_bajo_stock' => 10,
                'activo' => true,
                'venta_online' => false,
                'venta_fisica' => true,
                'metodo_pago' => 'efectivo',
                'ubicacion_descripcion' => 'Sector VIP Oro - venta presencial',
            ]
        );
    }
}