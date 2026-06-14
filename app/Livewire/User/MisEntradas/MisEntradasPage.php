<?php

namespace App\Livewire\User\MisEntradas;

use App\Models\Compra;
use App\Models\Entrada;
use Livewire\Component;

class MisEntradasPage extends Component
{
    public function mount(): void
    {
        if (! auth()->check()) {
            redirect()->route('login');
            return;
        }

        if (! auth()->user()->esUsuario()) {
            abort(403, 'Esta pantalla es solo para usuarios compradores.');
        }
    }

    public function descargarComprobante(int $compraId)
    {
        $compra = Compra::query()
            ->with(['items.evento', 'items.tipoEntrada', 'entradas'])
            ->where('usuario_id', auth()->id())
            ->findOrFail($compraId);

        $contenido = "MORA PRODUCCIONES\n";
        $contenido .= "COMPROBANTE DE COMPRA\n";
        $contenido .= "-----------------------------\n";
        $contenido .= "Código de compra: {$compra->codigo_compra}\n";
        $contenido .= "Estado: {$compra->estado}\n";
        $contenido .= "Fecha: {$compra->created_at?->format('d/m/Y H:i')}\n";
        $contenido .= "Comprador: {$compra->comprador_nombre} {$compra->comprador_apellido}\n";
        $contenido .= "DNI: {$compra->comprador_dni}\n";
        $contenido .= "Email: {$compra->comprador_email}\n\n";

        foreach ($compra->items as $item) {
            $contenido .= "Evento: {$item->nombre_evento}\n";
            $contenido .= "Tipo: {$item->nombre_tipo_entrada}\n";
            $contenido .= "Cantidad: {$item->cantidad}\n";
            $contenido .= "Subtotal: $ " . number_format($item->subtotal, 0, ',', '.') . "\n";
            $contenido .= "-----------------------------\n";
        }

        $contenido .= "\nTOTAL: $ " . number_format($compra->total, 0, ',', '.') . "\n";

        return response()->streamDownload(function () use ($contenido) {
            echo $contenido;
        }, 'comprobante-' . $compra->codigo_compra . '.txt');
    }

    public function render()
    {
        $entradas = Entrada::query()
            ->with(['compra', 'evento', 'tipoEntrada'])
            ->where('usuario_id', auth()->id())
            ->latest()
            ->get();

        $compras = Compra::query()
            ->with(['items.evento', 'items.tipoEntrada'])
            ->where('usuario_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.user.mis-entradas.mis-entradas-page', [
            'entradas' => $entradas,
            'compras' => $compras,
        ])->layout('components.layouts.public', [
            'title' => 'Mis entradas',
        ]);
    }
}