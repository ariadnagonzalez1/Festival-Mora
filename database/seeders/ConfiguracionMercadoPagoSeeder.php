<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracionMercadoPago;

class ConfiguracionMercadoPagoSeeder extends Seeder
{
    public function run(): void
    {
        ConfiguracionMercadoPago::updateOrCreate(
            ['id' => 1],
            [
                'public_key' => null,
                'access_token_encriptado' => null,
                'webhook_url' => null,
                'webhook_secret_encriptado' => null,
                'collector_id' => null,
                'pos_external_id' => null,
                'store_id' => null,
                'modo' => 'test',
            ]
        );
    }
}