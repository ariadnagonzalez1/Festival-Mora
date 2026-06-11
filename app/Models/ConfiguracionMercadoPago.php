<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfiguracionMercadoPago extends Model
{
    use HasFactory;

    protected $table = 'configuracion_mercado_pago';

    protected $fillable = [
        'public_key',
        'access_token_encriptado',
        'webhook_url',
        'webhook_secret_encriptado',
        'collector_id',
        'pos_external_id',
        'store_id',
        'modo',
    ];
}