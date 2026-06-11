<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'lugar',
        'ciudad',
        'provincia',
        'imagen_url',
        'estado',
        'mostrar_en_banner',
        'mostrar_en_inicio',
        'created_by',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'mostrar_en_banner' => 'boolean',
        'mostrar_en_inicio' => 'boolean',
    ];

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }

    public function artistas()
    {
        return $this->belongsToMany(Artista::class, 'evento_artistas', 'evento_id', 'artista_id')
            ->withPivot('orden')
            ->withTimestamps();
    }

    public function tiposEntradas()
    {
        return $this->hasMany(TipoEntrada::class, 'evento_id');
    }

    public function compraItems()
    {
        return $this->hasMany(CompraItem::class, 'evento_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'evento_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(NotificacionEnviada::class, 'evento_id');
    }

    public function estaDisponibleParaComprar()
    {
        return $this->estado === 'publicado' && now()->lt($this->fecha_inicio);
    }

    public function esExperiencia()
    {
        return now()->gte($this->fecha_inicio);
    }
}