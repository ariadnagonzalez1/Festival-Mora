<?php

namespace App\Livewire\Admin\Configuracion;

use App\Models\ConfiguracionMercadoPago;
use App\Models\ConfiguracionNotificacion;
use App\Models\ConfiguracionProductora;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ConfiguracionPage extends Component
{
    public string $nombre_comercial = '';
    public string $razon_social = '';
    public string $cuit = '';
    public string $email_contacto = '';
    public string $telefono = '';
    public string $direccion = '';
    public string $bio_publica = '';

    public string $public_key = '';
    public string $access_token = '';
    public string $webhook_url = '';
    public string $webhook_secret = '';
    public bool $modo_sandbox = true;

    public bool $email_comprador_confirmacion = true;
    public bool $email_admin_nueva_compra = true;
    public bool $recordatorio_24hs_comprador = true;
    public bool $alerta_bajo_stock_admin = true;

    public string $password_actual = '';
    public string $password_nueva = '';
    public string $password_nueva_confirmation = '';

    public function mount(): void
    {
        $productora = ConfiguracionProductora::firstOrCreate(
            ['id' => 1],
            ['nombre_comercial' => 'Mora Producciones']
        );

        $mercadoPago = ConfiguracionMercadoPago::firstOrCreate(
            ['id' => 1],
            ['modo' => 'test']
        );

        $notificaciones = ConfiguracionNotificacion::firstOrCreate(
            ['id' => 1],
            [
                'email_comprador_confirmacion' => true,
                'email_admin_nueva_compra' => true,
                'recordatorio_24hs_comprador' => true,
                'alerta_bajo_stock_admin' => true,
            ]
        );

        $this->nombre_comercial = $productora->nombre_comercial ?? '';
        $this->razon_social = $productora->razon_social ?? '';
        $this->cuit = $productora->cuit ?? '';
        $this->email_contacto = $productora->email_contacto ?? '';
        $this->telefono = $productora->telefono ?? '';
        $this->direccion = $productora->direccion ?? '';
        $this->bio_publica = $productora->bio_publica ?? '';

        $this->public_key = $mercadoPago->public_key ?? '';
        $this->webhook_url = $mercadoPago->webhook_url ?? '';
        $this->modo_sandbox = $mercadoPago->modo === 'test';

        $this->email_comprador_confirmacion = (bool) $notificaciones->email_comprador_confirmacion;
        $this->email_admin_nueva_compra = (bool) $notificaciones->email_admin_nueva_compra;
        $this->recordatorio_24hs_comprador = (bool) $notificaciones->recordatorio_24hs_comprador;
        $this->alerta_bajo_stock_admin = (bool) $notificaciones->alerta_bajo_stock_admin;
    }

    public function guardarConfiguracion(): void
    {
        $this->validate([
            'nombre_comercial' => ['required', 'string', 'max:150'],
            'razon_social' => ['nullable', 'string', 'max:150'],
            'cuit' => ['nullable', 'string', 'max:20'],
            'email_contacto' => ['nullable', 'email', 'max:150'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'bio_publica' => ['nullable', 'string'],

            'public_key' => ['nullable', 'string'],
            'access_token' => ['nullable', 'string'],
            'webhook_url' => ['nullable', 'string'],
            'webhook_secret' => ['nullable', 'string'],
        ]);

        ConfiguracionProductora::updateOrCreate(
            ['id' => 1],
            [
                'nombre_comercial' => $this->nombre_comercial,
                'razon_social' => $this->razon_social ?: null,
                'cuit' => $this->cuit ?: null,
                'email_contacto' => $this->email_contacto ?: null,
                'telefono' => $this->telefono ?: null,
                'direccion' => $this->direccion ?: null,
                'bio_publica' => $this->bio_publica ?: null,
            ]
        );

        $mercadoPago = ConfiguracionMercadoPago::firstOrCreate(['id' => 1]);

        $dataMercadoPago = [
            'public_key' => $this->public_key ?: null,
            'webhook_url' => $this->webhook_url ?: null,
            'modo' => $this->modo_sandbox ? 'test' : 'produccion',
        ];

        if ($this->access_token !== '') {
            $dataMercadoPago['access_token_encriptado'] = Crypt::encryptString($this->access_token);
        }

        if ($this->webhook_secret !== '') {
            $dataMercadoPago['webhook_secret_encriptado'] = Crypt::encryptString($this->webhook_secret);
        }

        $mercadoPago->update($dataMercadoPago);

        ConfiguracionNotificacion::updateOrCreate(
            ['id' => 1],
            [
                'email_comprador_confirmacion' => $this->email_comprador_confirmacion,
                'email_admin_nueva_compra' => $this->email_admin_nueva_compra,
                'recordatorio_24hs_comprador' => $this->recordatorio_24hs_comprador,
                'alerta_bajo_stock_admin' => $this->alerta_bajo_stock_admin,
            ]
        );

        $this->access_token = '';
        $this->webhook_secret = '';

        session()->flash('success', 'Configuración guardada correctamente.');
    }

    public function cambiarPassword(): void
    {
        $this->validate([
            'password_actual' => ['required'],
            'password_nueva' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_actual.required' => 'Ingresá tu contraseña actual.',
            'password_nueva.required' => 'Ingresá una nueva contraseña.',
            'password_nueva.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password_nueva.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = auth()->user();

        if (! Hash::check($this->password_actual, $usuario->password_hash)) {
            $this->addError('password_actual', 'La contraseña actual no es correcta.');
            return;
        }

        $usuario->update([
            'password_hash' => Hash::make($this->password_nueva),
        ]);

        $this->reset([
            'password_actual',
            'password_nueva',
            'password_nueva_confirmation',
        ]);

        session()->flash('success', 'Contraseña actualizada correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.configuracion.configuracion-page')
            ->layout('components.layouts.admin', [
                'title' => 'Configuración',
            ]);
    }
}