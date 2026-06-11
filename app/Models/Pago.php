<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'compra_id',
        'tipo_integracion',
        'mercado_pago_preference_id',
        'mercado_pago_payment_id',
        'mercado_pago_order_id',
        'mercado_pago_qr_id',
        'external_reference',
        'estado_pago',
        'qr_pago_estado',
        'qr_pago_payload',
        'monto',
        'moneda',
        'metodo_pago',
        'tipo_pago',
        'nombre_receptor',
        'concepto_pago',
        'fecha_aprobacion',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_aprobacion' => 'datetime',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function estaAprobado()
    {
        return $this->estado_pago === 'aprobado';
    }

    public function estaPendiente()
    {
        return $this->estado_pago === 'pendiente';
    }

    public function fuePagadoPorQr()
    {
        return $this->tipo_integracion === 'qr_mercado_pago';
    }
}