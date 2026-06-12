<?php

namespace App\Livewire\Auth\Register;

use Livewire\Component;
use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterPage extends Component
{
    public string $nombre = '';
    public string $apellido = '';
    public string $dni = '';
    public string $email = '';
    public string $telefono = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'dni' => ['required', 'string', 'max:20', 'unique:usuarios,dni'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nombre.required' => 'Ingresá tu nombre.',
            'apellido.required' => 'Ingresá tu apellido.',
            'dni.required' => 'Ingresá tu DNI.',
            'dni.unique' => 'Ese DNI ya está registrado.',
            'email.required' => 'Ingresá tu email.',
            'email.email' => 'Ingresá un email válido.',
            'email.unique' => 'Ese email ya está registrado.',
            'password.required' => 'Ingresá una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $rolUsuario = Role::where('nombre', 'usuario')->firstOrFail();

        $usuario = Usuario::create([
            'rol_id' => $rolUsuario->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'email' => $this->email,
            'telefono' => $this->telefono ?: null,
            'password_hash' => Hash::make($this->password),
            'bloqueado' => false,
        ]);

        Auth::login($usuario);

        request()->session()->regenerate();

        return redirect()->route('public.inicio');
    }

    public function render()
    {
        return view('livewire.auth.register.register-page')
            ->layout('components.layouts.public', [
                'title' => 'Registrarme',
            ]);
    }
}