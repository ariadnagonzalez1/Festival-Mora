<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artista extends Model
{
    use HasFactory;

    protected $table = 'artistas';

    protected $fillable = [
        'nombre',
        'genero',
        'instagram_url',
        'foto_url',
        'bio',
        'destacado',
    ];

    protected $casts = [
        'destacado' => 'boolean',
    ];

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_artistas', 'artista_id', 'evento_id')
            ->withPivot('orden')
            ->withTimestamps();
    }
}