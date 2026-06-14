<?php

namespace App\Livewire\Admin\Ventas;

use App\Models\Compra;
use Livewire\Component;
use Livewire\WithPagination;

class VentasPage extends Component
{
    use WithPagination;

    public string $estadoFiltro = '';

    public function filtrarPorEstado(string $estado): void
    {
        $this->estadoFiltro = $estado;
        $this->resetPage();
    }

    public function limpiarFiltro(): void
    {
        $this->estadoFiltro = '';
        $this->resetPage();
    }

    public function render()
    {
        $ventas = Compra::query()
            ->with([
                'usuario',
                'items.evento',
                'items.tipoEntrada',
                'pagos',
                'entradas',
            ])
            ->when($this->estadoFiltro !== '', function ($query) {
                $query->where('estado', $this->estadoFiltro);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.ventas.ventas-page', [
            'ventas' => $ventas,
        ])->layout('components.layouts.admin', [
            'title' => 'Ventas',
        ]);
    }
}