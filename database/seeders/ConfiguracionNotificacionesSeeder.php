<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracionNotificacion;

class ConfiguracionNotificacionesSeeder extends Seeder
{
    public function run(): void
    {
        ConfiguracionNotificacion::updateOrCreate(
            ['id' => 1],
            [
                'email_comprador_confirmacion' => true,
                'email_admin_nueva_compra' => true,
                'recordatorio_24hs_comprador' => true,
                'alerta_bajo_stock_admin' => true,
            ]
        );
    }
}