<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracionProductora;

class ConfiguracionProductoraSeeder extends Seeder
{
    public function run(): void
    {
        ConfiguracionProductora::updateOrCreate(
            ['id' => 1],
            [
                'nombre_comercial' => 'Mora Producciones',
                'razon_social' => 'Mora Producciones',
                'cuit' => '00-00000000-0',
                'email_contacto' => 'contacto@moraproducciones.com',
                'telefono' => '3704000000',
                'direccion' => 'Formosa, Argentina',
                'bio_publica' => 'Productora de eventos, festivales y experiencias en vivo.',
                'logo_url' => null,
                'instagram_url' => 'https://instagram.com/moraproducciones',
                'facebook_url' => null,
                'tiktok_url' => null,
            ]
        );
    }
}