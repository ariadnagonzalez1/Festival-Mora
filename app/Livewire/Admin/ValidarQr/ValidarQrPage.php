<?php

namespace App\Livewire\Admin\ValidarQr;

use App\Models\Entrada;
use App\Models\ValidacionQr;
use Livewire\Component;

class ValidarQrPage extends Component
{
    public string $codigoQr = '';

    public ?array $resultado = null;

    public function validar(): void
    {
        $this->validate([
            'codigoQr' => ['required', 'string', 'max:255'],
        ], [
            'codigoQr.required' => 'Ingresá o escaneá un código QR.',
        ]);

        $codigo = trim($this->codigoQr);

        $entrada = Entrada::query()
            ->with([
                'compra.pagos',
                'evento',
                'tipoEntrada',
                'usuario',
            ])
            ->where('codigo_qr', $codigo)
            ->first();

        if (! $entrada) {
            ValidacionQr::create([
                'entrada_id' => null,
                'admin_id' => auth()->id(),
                'codigo_qr_ingresado' => $codigo,
                'resultado' => 'invalida',
                'mensaje' => 'El código QR no existe.',
                'fecha_validacion' => now(),
                'created_at' => now(),
            ]);

            $this->resultado = [
                'tipo' => 'error',
                'titulo' => 'Entrada inválida',
                'mensaje' => 'El código QR no existe o no pertenece a ninguna entrada.',
                'datos' => null,
            ];

            return;
        }

        if ($entrada->estado_uso === 'usada') {
            ValidacionQr::create([
                'entrada_id' => $entrada->id,
                'admin_id' => auth()->id(),
                'codigo_qr_ingresado' => $codigo,
                'resultado' => 'ya_usada',
                'mensaje' => 'La entrada ya fue usada.',
                'fecha_validacion' => now(),
                'created_at' => now(),
            ]);

            $this->resultado = [
                'tipo' => 'warning',
                'titulo' => 'Entrada ya usada',
                'mensaje' => 'Esta entrada ya fue validada anteriormente.',
                'datos' => $this->datosEntrada($entrada),
            ];

            return;
        }

        if ($entrada->compra?->estado !== 'aprobada') {
            ValidacionQr::create([
                'entrada_id' => $entrada->id,
                'admin_id' => auth()->id(),
                'codigo_qr_ingresado' => $codigo,
                'resultado' => 'pago_no_aprobado',
                'mensaje' => 'El pago de la compra no está aprobado.',
                'fecha_validacion' => now(),
                'created_at' => now(),
            ]);

            $this->resultado = [
                'tipo' => 'warning',
                'titulo' => 'Pago no aprobado',
                'mensaje' => 'La entrada existe, pero la compra todavía no está aprobada.',
                'datos' => $this->datosEntrada($entrada),
            ];

            return;
        }

        $entrada->update([
            'estado_uso' => 'usada',
            'fecha_uso' => now(),
            'usada_por_admin_id' => auth()->id(),
        ]);

        ValidacionQr::create([
            'entrada_id' => $entrada->id,
            'admin_id' => auth()->id(),
            'codigo_qr_ingresado' => $codigo,
            'resultado' => 'valida',
            'mensaje' => 'Entrada validada correctamente.',
            'fecha_validacion' => now(),
            'created_at' => now(),
        ]);

        $entrada->refresh();

        $this->resultado = [
            'tipo' => 'success',
            'titulo' => 'Entrada válida',
            'mensaje' => 'Acceso autorizado. La entrada fue marcada como usada.',
            'datos' => $this->datosEntrada($entrada),
        ];

        $this->codigoQr = '';
    }

    public function limpiarResultado(): void
    {
        $this->codigoQr = '';
        $this->resultado = null;
        $this->resetValidation();
    }

    private function datosEntrada(Entrada $entrada): array
    {
        return [
            'codigo_qr' => $entrada->codigo_qr,
            'evento' => $entrada->evento?->titulo ?? 'Sin evento',
            'fecha_evento' => $entrada->evento?->fecha_inicio?->format('d/m/Y H:i'),
            'tipo_entrada' => $entrada->tipoEntrada?->nombre ?? $entrada->sector_nombre ?? 'Entrada',
            'ubicacion' => $entrada->ubicacion_texto ?? $entrada->tipoEntrada?->ubicacion_descripcion ?? '-',
            'precio' => $entrada->precio_pagado,
            'comprador' => trim(($entrada->nombre_comprador ?? '') . ' ' . ($entrada->apellido_comprador ?? '')),
            'dni' => $entrada->dni_comprador ?? '-',
            'email' => $entrada->email_comprador ?? '-',
            'estado_compra' => $entrada->compra?->estado ?? '-',
            'estado_uso' => $entrada->estado_uso,
            'fecha_uso' => $entrada->fecha_uso?->format('d/m/Y H:i'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.validar-qr.validar-qr-page')
            ->layout('components.layouts.admin', [
                'title' => 'Validar QR',
            ]);
    }
}