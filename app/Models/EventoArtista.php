<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventoArtista extends Model
{
    use HasFactory;

    protected $table = 'evento_artistas';

    protected $fillable = [
        'evento_id',
        'artista_id',
        'orden',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function artista()
    {
        return $this->belongsTo(Artista::class, 'artista_id');
    }
}