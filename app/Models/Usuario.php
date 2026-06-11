<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'rol_id',
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'password_hash',
        'bloqueado',
        'fecha_bloqueo',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'bloqueado' => 'boolean',
        'fecha_bloqueo' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'usuario_id');
    }

    public function eventosCreados()
    {
        return $this->hasMany(Evento::class, 'created_by');
    }

    public function entradasValidadas()
    {
        return $this->hasMany(Entrada::class, 'usada_por_admin_id');
    }

    public function validacionesQr()
    {
        return $this->hasMany(ValidacionQr::class, 'admin_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(NotificacionEnviada::class, 'usuario_id');
    }

    public function esAdministrador()
    {
        return $this->rol && $this->rol->nombre === 'administrador';
    }

    public function esUsuario()
    {
        return $this->rol && $this->rol->nombre === 'usuario';
    }
}