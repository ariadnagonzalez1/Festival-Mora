<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MercadoPagoWebhookLog extends Model
{
    use HasFactory;

    protected $table = 'mercado_pago_webhook_logs';

    public $timestamps = false;

    protected $fillable = [
        'tipo_evento',
        'mercado_pago_id',
        'payload',
        'firma_valida',
        'procesado',
        'mensaje_error',
        'created_at',
    ];

    protected $casts = [
        'firma_valida' => 'boolean',
        'procesado' => 'boolean',
        'created_at' => 'datetime',
    ];
}