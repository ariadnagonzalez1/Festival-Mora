<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'usuario_id',
        'codigo_compra',
        'external_reference',
        'estado',
        'total',
        'comprador_nombre',
        'comprador_apellido',
        'comprador_dni',
        'comprador_email',
        'comprador_telefono',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function items()
    {
        return $this->hasMany(CompraItem::class, 'compra_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'compra_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'compra_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(NotificacionEnviada::class, 'compra_id');
    }

    public function estaAprobada()
    {
        return $this->estado === 'aprobada';
    }

    public function estaPendiente()
    {
        return $this->estado === 'pendiente';
    }
}