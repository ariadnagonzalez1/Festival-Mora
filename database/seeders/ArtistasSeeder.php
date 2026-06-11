<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artista;

class ArtistasSeeder extends Seeder
{
    public function run(): void
    {
        $artistas = [
            [
                'nombre' => 'Los del Festival',
                'genero' => 'Folklore',
                'instagram_url' => 'https://instagram.com/losdelfestival',
                'foto_url' => null,
                'bio' => 'Grupo invitado para presentaciones en vivo.',
                'destacado' => true,
            ],
            [
                'nombre' => 'DJ Mora',
                'genero' => 'Electrónica / Fiesta',
                'instagram_url' => 'https://instagram.com/djmora',
                'foto_url' => null,
                'bio' => 'DJ invitado para cierre de festival.',
                'destacado' => true,
            ],
            [
                'nombre' => 'Banda Invitada',
                'genero' => 'Pop / Cumbia',
                'instagram_url' => null,
                'foto_url' => null,
                'bio' => 'Artista invitado de la noche.',
                'destacado' => false,
            ],
        ];

        foreach ($artistas as $artista) {
            Artista::updateOrCreate(
                ['nombre' => $artista['nombre']],
                $artista
            );
        }
    }
}