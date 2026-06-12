<?php

namespace App\Livewire\Auth\Login;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginPage extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Ingresá tu email.',
            'email.email' => 'Ingresá un email válido.',
            'password.required' => 'Ingresá tu contraseña.',
        ]);

        $credenciales = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (! Auth::attempt($credenciales)) {
            throw ValidationException::withMessages([
                'email' => 'El email o la contraseña no son correctos.',
            ]);
        }

        $usuario = Auth::user();

        if ($usuario->bloqueado) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Tu cuenta está bloqueada. Comunicate con Mora Producciones.',
            ]);
        }

        request()->session()->regenerate();

        return redirect()->intended(route('public.inicio'));
    }

    public function render()
    {
        return view('livewire.auth.login.login-page')
            ->layout('components.layouts.public', [
                'title' => 'Ingresar',
            ]);
    }
}