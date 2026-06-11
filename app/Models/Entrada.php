<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrada extends Model
{
    use HasFactory;

    protected $table = 'entradas';

    protected $fillable = [
        'compra_id',
        'compra_item_id',
        'usuario_id',
        'evento_id',
        'tipo_entrada_id',
        'sector_nombre',
        'ubicacion_texto',
        'precio_pagado',
        'codigo_qr',
        'estado_uso',
        'fecha_uso',
        'usada_por_admin_id',
        'nombre_comprador',
        'apellido_comprador',
        'dni_comprador',
        'email_comprador',
    ];

    protected $casts = [
        'precio_pagado' => 'decimal:2',
        'fecha_uso' => 'datetime',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function compraItem()
    {
        return $this->belongsTo(CompraItem::class, 'compra_item_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function tipoEntrada()
    {
        return $this->belongsTo(TipoEntrada::class, 'tipo_entrada_id');
    }

    public function usadaPorAdmin()
    {
        return $this->belongsTo(Usuario::class, 'usada_por_admin_id');
    }

    public function validaciones()
    {
        return $this->hasMany(ValidacionQr::class, 'entrada_id');
    }

    public function estaUsada()
    {
        return $this->estado_uso === 'usada';
    }

    public function estaDisponible()
    {
        return $this->estado_uso === 'no_usada';
    }
}