<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoEntrada extends Model
{
    use HasFactory;

    protected $table = 'tipos_entradas';

    protected $fillable = [
        'evento_id',
        'nombre',
        'descripcion',
        'precio',
        'stock_total',
        'stock_disponible',
        'stock_reservado',
        'stock_vendido',
        'umbral_bajo_stock',
        'activo',
        'venta_online',
        'venta_fisica',
        'metodo_pago',
        'ubicacion_descripcion',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
        'venta_online' => 'boolean',
        'venta_fisica' => 'boolean',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function compraItems()
    {
        return $this->hasMany(CompraItem::class, 'tipo_entrada_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'tipo_entrada_id');
    }

    public function esVentaOnline()
    {
        return $this->venta_online && $this->metodo_pago === 'qr_mercado_pago';
    }

    public function esVentaFisica()
    {
        return $this->venta_fisica && $this->metodo_pago === 'efectivo';
    }

    public function hayStock()
    {
        return $this->stock_disponible > 0;
    }

    public function bajoStock()
    {
        return $this->stock_disponible <= $this->umbral_bajo_stock;
    }
}