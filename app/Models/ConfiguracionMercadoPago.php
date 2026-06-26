<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionMercadoPago extends Model
{
    protected $table = 'configuracion_mercado_pago';

    protected $fillable = [
        'public_key',
        'pos_external_id',
        'nombre_receptor',
        'access_token_encriptado',
        'webhook_url',
        'webhook_secret_encriptado',
        'modo',
    ];
}