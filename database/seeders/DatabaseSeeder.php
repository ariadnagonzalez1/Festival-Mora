<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsuariosSeeder::class,
            ConfiguracionProductoraSeeder::class,
            ConfiguracionMercadoPagoSeeder::class,
            ConfiguracionNotificacionesSeeder::class,
            ArtistasSeeder::class,
            EventosSeeder::class,
            TiposEntradasSeeder::class,
        ]);
    }
}