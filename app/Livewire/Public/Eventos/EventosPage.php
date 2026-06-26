<?php

namespace App\Livewire\Public\Eventos;

use App\Models\Evento;
use Livewire\Component;

class EventosPage extends Component
{
    public string $buscar = '';
    public string $ciudad = '';

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
    $ciudades = Evento::query()
        ->where('estado', 'publicado')
        ->where('fecha_inicio', '>', now())
        ->whereNotNull('ciudad')
        ->where('ciudad', '!=', '')
        ->distinct()
        ->orderBy('ciudad')
        ->pluck('ciudad');

    $eventos = Evento::query()
        ->with([
            'tiposEntradas' => function ($query) {
                $query
                    ->where('activo', true)
                    ->orderBy('precio');
            },
        ])
        ->where('estado', 'publicado')
        ->where('fecha_inicio', '>', now())
        ->when($this->buscar !== '', function ($query) {
            $query->where(function ($q) {
                $q->where('titulo', 'like', '%' . $this->buscar . '%')
                    ->orWhere('ciudad', 'like', '%' . $this->buscar . '%')
                    ->orWhere('lugar', 'like', '%' . $this->buscar . '%');
            });
        })
        ->when($this->ciudad !== '', function ($query) {
            $query->where('ciudad', $this->ciudad);
        })
        ->orderBy('fecha_inicio')
        ->get();

    return view('livewire.public.eventos.eventos-page', [
        'eventos' => $eventos,
        'ciudades' => $ciudades,
    ])->layout('components.layouts.public', [
        'title' => 'Eventos',
    ]);
}
}