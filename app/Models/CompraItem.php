<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompraItem extends Model
{
    use HasFactory;

    protected $table = 'compra_items';

    protected $fillable = [
        'compra_id',
        'evento_id',
        'tipo_entrada_id',
        'cantidad',
        'nombre_evento',
        'nombre_tipo_entrada',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function tipoEntrada()
    {
        return $this->belongsTo(TipoEntrada::class, 'tipo_entrada_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'compra_item_id');
    }
}