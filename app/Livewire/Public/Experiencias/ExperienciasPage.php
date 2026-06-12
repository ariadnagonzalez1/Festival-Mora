<?php

namespace App\Livewire\Public\Experiencias;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evento;
use App\Models\Entrada;
use App\Models\Artista;

class ExperienciasPage extends Component
{
    use WithPagination;

    public string $buscar = '';
    public string $anio = '';

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function updatedAnio(): void
    {
        $this->resetPage();
    }

    public function limpiarFiltros(): void
    {
        $this->reset('buscar', 'anio');
        $this->resetPage();
    }

    private function queryExperiencias()
    {
        return Evento::query()
            ->where(function ($query) {
                $query->where('estado', 'finalizado')
                    ->orWhere(function ($subquery) {
                        $subquery->where('fecha_inicio', '<=', now())
                            ->where('estado', 'publicado');
                    });
            })
            ->where('estado', '!=', 'cancelado');
    }

    public function render()
    {
        $anios = $this->queryExperiencias()
            ->selectRaw('YEAR(fecha_inicio) as anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        $experiencias = $this->queryExperiencias()
            ->with(['artistas'])
            ->when($this->buscar !== '', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('titulo', 'like', '%' . $this->buscar . '%')
                        ->orWhere('descripcion', 'like', '%' . $this->buscar . '%')
                        ->orWhere('lugar', 'like', '%' . $this->buscar . '%')
                        ->orWhere('ciudad', 'like', '%' . $this->buscar . '%');
                });
            })
            ->when($this->anio !== '', function ($query) {
                $query->whereYear('fecha_inicio', $this->anio);
            })
            ->orderByDesc('fecha_inicio')
            ->paginate(4);

        $eventosRealizados = $this->queryExperiencias()->count();

        $asistentesTotales = Entrada::query()
            ->whereHas('evento', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('estado', 'finalizado')
                        ->orWhere(function ($q) {
                            $q->where('fecha_inicio', '<=', now())
                                ->where('estado', 'publicado');
                        });
                });
            })
            ->count();

        $ciudadesRecorridas = $this->queryExperiencias()
            ->whereNotNull('ciudad')
            ->distinct('ciudad')
            ->count('ciudad');

        $artistasPresentados = Artista::query()
            ->whereHas('eventos', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('estado', 'finalizado')
                        ->orWhere(function ($q) {
                            $q->where('fecha_inicio', '<=', now())
                                ->where('estado', 'publicado');
                        });
                });
            })
            ->count();

        return view('livewire.public.experiencias.experiencias-page', [
            'experiencias' => $experiencias,
            'anios' => $anios,
            'eventosRealizados' => $eventosRealizados,
            'asistentesTotales' => $asistentesTotales,
            'ciudadesRecorridas' => $ciudadesRecorridas,
            'artistasPresentados' => $artistasPresentados,
        ])->layout('components.layouts.public', [
            'title' => 'Experiencias Mora',
        ]);
    }
}