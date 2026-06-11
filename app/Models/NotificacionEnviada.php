<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificacionEnviada extends Model
{
    use HasFactory;

    protected $table = 'notificaciones_enviadas';

    protected $fillable = [
        'usuario_id',
        'compra_id',
        'evento_id',
        'tipo',
        'email_destino',
        'asunto',
        'cuerpo',
        'estado_envio',
        'fecha_envio',
        'mensaje_error',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
}