<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfiguracionProductora extends Model
{
    use HasFactory;

    protected $table = 'configuracion_productora';

    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'cuit',
        'email_contacto',
        'telefono',
        'direccion',
        'bio_publica',
        'logo_url',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
    ];
}