<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Pago;
use App\Models\Entrada;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Compra;

class DashboardPage extends Component
{
    public function render()
    {
        $ingresos = Pago::query()
            ->where('estado_pago', 'aprobado')
            ->sum('monto');

        $entradasVendidas = Entrada::query()
            ->count();

        $eventosActivos = Evento::query()
            ->where('estado', 'publicado')
            ->where('fecha_inicio', '>', now())
            ->count();

        $compradores = Usuario::query()
            ->whereHas('rol', function ($query) {
                $query->where('nombre', 'usuario');
            })
            ->whereHas('compras')
            ->count();

        $ventasPorEvento = Evento::query()
            ->withCount('entradas')
            ->where('estado', 'publicado')
            ->orderBy('fecha_inicio')
            ->limit(5)
            ->get();

        $maxEntradasEvento = max($ventasPorEvento->max('entradas_count') ?? 1, 1);

        $ultimasCompras = Compra::query()
            ->with(['usuario', 'pagos'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.admin.dashboard.dashboard-page', [
            'ingresos' => $ingresos,
            'entradasVendidas' => $entradasVendidas,
            'eventosActivos' => $eventosActivos,
            'compradores' => $compradores,
            'ventasPorEvento' => $ventasPorEvento,
            'maxEntradasEvento' => $maxEntradasEvento,
            'ultimasCompras' => $ultimasCompras,
        ])->layout('components.layouts.admin', [
            'title' => 'Dashboard',
        ]);
    }
}