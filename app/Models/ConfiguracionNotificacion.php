<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfiguracionNotificacion extends Model
{
    use HasFactory;

    protected $table = 'configuracion_notificaciones';

    protected $fillable = [
        'email_comprador_confirmacion',
        'email_admin_nueva_compra',
        'recordatorio_24hs_comprador',
        'alerta_bajo_stock_admin',
    ];

    protected $casts = [
        'email_comprador_confirmacion' => 'boolean',
        'email_admin_nueva_compra' => 'boolean',
        'recordatorio_24hs_comprador' => 'boolean',
        'alerta_bajo_stock_admin' => 'boolean',
    ];
}