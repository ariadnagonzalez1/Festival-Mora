<?php

namespace App\Livewire\Public\Eventos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evento;

class EventosPage extends Component
{
    use WithPagination;

    public string $buscar = '';
    public string $ciudad = '';

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function updatedCiudad(): void
    {
        $this->resetPage();
    }

    public function limpiarFiltros(): void
    {
        $this->reset('buscar', 'ciudad');
        $this->resetPage();
    }

    public function render()
    {
        $ciudades = Evento::query()
            ->where('estado', 'publicado')
            ->where('fecha_inicio', '>', now())
            ->whereHas('tiposEntradas', function ($query) {
                $query->where('activo', true)
                    ->where('venta_online', true)
                    ->where('stock_disponible', '>', 0);
            })
            ->whereNotNull('ciudad')
            ->select('ciudad')
            ->distinct()
            ->orderBy('ciudad')
            ->pluck('ciudad');

        $eventos = Evento::query()
            ->with(['tiposEntradas' => function ($query) {
                $query->where('activo', true)
                    ->where('venta_online', true)
                    ->where('stock_disponible', '>', 0)
                    ->orderBy('precio');
            }])
            ->where('estado', 'publicado')
            ->where('fecha_inicio', '>', now())
            ->whereHas('tiposEntradas', function ($query) {
                $query->where('activo', true)
                    ->where('venta_online', true)
                    ->where('stock_disponible', '>', 0);
            })
            ->when($this->buscar !== '', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('titulo', 'like', '%' . $this->buscar . '%')
                        ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
                        ->orWhere('lugar', 'like', '%' . $this->buscar . '%')
                        ->orWhere('ciudad', 'like', '%' . $this->buscar . '%');
                });
            })
            ->when($this->ciudad !== '', function ($query) {
                $query->where('ciudad', $this->ciudad);
            })
            ->orderBy('fecha_inicio')
            ->paginate(6);

        return view('livewire.public.eventos.eventos-page', [
            'eventos' => $eventos,
            'ciudades' => $ciudades,
        ])->layout('components.layouts.public', [
            'title' => 'Eventos',
        ]);
    }
}