<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $rolAdmin = Role::where('nombre', 'administrador')->first();
        $rolUsuario = Role::where('nombre', 'usuario')->first();

        Usuario::updateOrCreate(
            ['email' => 'admin@moraproducciones.com'],
            [
                'rol_id' => $rolAdmin->id,
                'nombre' => 'Mora',
                'apellido' => 'Producciones',
                'dni' => '00000000',
                'telefono' => '3704000000',
                'password_hash' => Hash::make('admin1234'),
                'bloqueado' => false,
            ]
        );

        Usuario::updateOrCreate(
            ['email' => 'usuario@test.com'],
            [
                'rol_id' => $rolUsuario->id,
                'nombre' => 'Usuario',
                'apellido' => 'Prueba',
                'dni' => '12345678',
                'telefono' => '3704111111',
                'password_hash' => Hash::make('usuario1234'),
                'bloqueado' => false,
            ]
        );
    }
}