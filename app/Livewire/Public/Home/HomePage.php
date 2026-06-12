<?php

namespace App\Livewire\Public\Home;

use Livewire\Component;
use App\Models\Evento;
use App\Models\Artista;

class HomePage extends Component
{
    public function render()
    {
        $bannerEvento = Evento::query()
            ->with(['tiposEntradas' => function ($query) {
                $query->where('activo', true)
                    ->where('venta_online', true);
            }])
            ->where('estado', 'publicado')
            ->where('mostrar_en_banner', true)
            ->where('fecha_inicio', '>', now())
            ->orderBy('fecha_inicio')
            ->first();

        if (!$bannerEvento) {
            $bannerEvento = Evento::query()
                ->with(['tiposEntradas' => function ($query) {
                    $query->where('activo', true)
                        ->where('venta_online', true);
                }])
                ->where('estado', 'publicado')
                ->where('fecha_inicio', '>', now())
                ->orderBy('fecha_inicio')
                ->first();
        }

        $proximosEventos = Evento::query()
            ->with(['tiposEntradas' => function ($query) {
                $query->where('activo', true)
                    ->where('venta_online', true);
            }])
            ->where('estado', 'publicado')
            ->where('mostrar_en_inicio', true)
            ->where('fecha_inicio', '>', now())
            ->orderBy('fecha_inicio')
            ->limit(3)
            ->get();

        $artistasDestacados = Artista::query()
            ->where('destacado', true)
            ->latest()
            ->limit(6)
            ->get();

        return view('livewire.public.home.home-page', [
            'bannerEvento' => $bannerEvento,
            'proximosEventos' => $proximosEventos,
            'artistasDestacados' => $artistasDestacados,
        ])->layout('components.layouts.public', [
            'title' => 'Inicio',
        ]);
    }
}