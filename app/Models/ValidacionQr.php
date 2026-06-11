<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ValidacionQr extends Model
{
    use HasFactory;

    protected $table = 'validaciones_qr';

    public $timestamps = false;

    protected $fillable = [
        'entrada_id',
        'admin_id',
        'codigo_qr_ingresado',
        'resultado',
        'mensaje',
        'fecha_validacion',
        'created_at',
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'entrada_id');
    }

    public function admin()
    {
        return $this->belongsTo(Usuario::class, 'admin_id');
    }
}