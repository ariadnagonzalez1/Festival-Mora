<?php

namespace App\Livewire\Public\Home;

use App\Models\Artista;
use App\Models\Evento;
use Livewire\Component;

class HomePage extends Component
{
    public bool $mostrarModalEntradas = false;

    public $eventoSeleccionado = null;

    public function abrirEntradas(int $eventoId): void
    {
        $this->eventoSeleccionado = Evento::with([
            'tiposEntradas' => function ($query) {
                $query
                    ->where('activo', true)
                    ->orderByDesc('precio');
            },
        ])->findOrFail($eventoId);

        $this->mostrarModalEntradas = true;
    }

    public function cerrarEntradas(): void
    {
        $this->mostrarModalEntradas = false;
        $this->eventoSeleccionado = null;
    }

    public function getPuedeVerQrProperty(): bool
    {
        return auth()->check() && auth()->user()->esUsuario();
    }

    public function render()
    {
        $bannerEvento = Evento::query()
            ->with([
                'tiposEntradas' => function ($query) {
                    $query
                        ->where('activo', true)
                        ->orderBy('precio');
                },
            ])
            ->where('estado', 'publicado')
            ->where('mostrar_en_banner', true)
            ->where('fecha_inicio', '>', now())
            ->orderBy('fecha_inicio')
            ->first();

        if (! $bannerEvento) {
            $bannerEvento = Evento::query()
                ->with([
                    'tiposEntradas' => function ($query) {
                        $query
                            ->where('activo', true)
                            ->orderBy('precio');
                    },
                ])
                ->where('estado', 'publicado')
                ->where('fecha_inicio', '>', now())
                ->orderBy('fecha_inicio')
                ->first();
        }

        $proximosEventos = Evento::query()
            ->with([
                'tiposEntradas' => function ($query) {
                    $query
                        ->where('activo', true)
                        ->orderBy('precio');
                },
            ])
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