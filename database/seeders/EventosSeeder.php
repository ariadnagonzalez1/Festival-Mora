<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Artista;

class EventosSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Usuario::whereHas('rol', function ($query) {
            $query->where('nombre', 'administrador');
        })->first();

        $evento = Evento::updateOrCreate(
            ['slug' => 'festival-mora-2026'],
            [
                'titulo' => 'Festival Mora 2026',
                'descripcion' => 'Una experiencia única con artistas en vivo, música, fiesta y producción integral de Mora Producciones.',
                'fecha_inicio' => Carbon::now()->addDays(20)->setTime(22, 0),
                'fecha_fin' => Carbon::now()->addDays(21)->setTime(3, 0),
                'lugar' => 'Predio principal',
                'ciudad' => 'Formosa',
                'provincia' => 'Formosa',
                'imagen_url' => null,
                'estado' => 'publicado',
                'mostrar_en_banner' => true,
                'mostrar_en_inicio' => true,
                'created_by' => $admin?->id,
            ]
        );

        $eventoPasado = Evento::updateOrCreate(
            ['slug' => 'experiencia-mora-anterior'],
            [
                'titulo' => 'Experiencia Mora Anterior',
                'descripcion' => 'Evento anterior organizado por Mora Producciones.',
                'fecha_inicio' => Carbon::now()->subDays(15)->setTime(22, 0),
                'fecha_fin' => Carbon::now()->subDays(14)->setTime(3, 0),
                'lugar' => 'Club Social',
                'ciudad' => 'Formosa',
                'provincia' => 'Formosa',
                'imagen_url' => null,
                'estado' => 'finalizado',
                'mostrar_en_banner' => false,
                'mostrar_en_inicio' => false,
                'created_by' => $admin?->id,
            ]
        );

        $artistas = Artista::take(3)->get();

        foreach ($artistas as $index => $artista) {
            $evento->artistas()->syncWithoutDetaching([
                $artista->id => ['orden' => $index + 1],
            ]);

            $eventoPasado->artistas()->syncWithoutDetaching([
                $artista->id => ['orden' => $index + 1],
            ]);
        }
    }
}