<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UsuariosPage extends Component
{
    use WithPagination;

    public string $buscar = '';

    public bool $modalCreate = false;
    public bool $modalEdit = false;

    public ?int $usuarioEditId = null;

    public string $nombre_completo = '';
    public string $email = '';
    public string $dni = '';
    public string $rol = 'usuario';
    public string $estado = 'activo';

    public ?string $passwordTemporal = null;

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function abrirCrear(): void
    {
        $this->resetForm();
        $this->modalCreate = true;
    }

    public function abrirEditar(int $usuarioId): void
    {
        $usuario = Usuario::with('rol')->findOrFail($usuarioId);

        $this->usuarioEditId = $usuario->id;
        $this->nombre_completo = trim($usuario->nombre . ' ' . $usuario->apellido);
        $this->email = $usuario->email;
        $this->dni = $usuario->dni;
        $this->rol = $usuario->rol?->nombre ?? 'usuario';
        $this->estado = $usuario->bloqueado ? 'bloqueado' : 'activo';

        $this->modalEdit = true;
    }

    public function cerrarModales(): void
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->resetValidation();
    }

    public function crear(): void
    {
        $this->validate([
            'nombre_completo' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email'],
            'dni' => ['required', 'string', 'max:20', 'unique:usuarios,dni'],
            'rol' => ['required', 'in:usuario,administrador'],
            'estado' => ['required', 'in:activo,bloqueado'],
        ], [
            'nombre_completo.required' => 'Ingresá el nombre completo.',
            'email.required' => 'Ingresá el email.',
            'email.email' => 'Ingresá un email válido.',
            'email.unique' => 'Ese email ya está registrado.',
            'dni.required' => 'Ingresá el DNI.',
            'dni.unique' => 'Ese DNI ya está registrado.',
        ]);

        [$nombre, $apellido] = $this->dividirNombreCompleto();

        $rol = Role::where('nombre', $this->rol)->firstOrFail();

        $this->passwordTemporal = 'Mora' . random_int(100000, 999999);

        Usuario::create([
            'rol_id' => $rol->id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $this->dni,
            'email' => $this->email,
            'telefono' => null,
            'password_hash' => Hash::make($this->passwordTemporal),
            'bloqueado' => $this->estado === 'bloqueado',
            'fecha_bloqueo' => $this->estado === 'bloqueado' ? now() : null,
        ]);

        $this->cerrarModales();
        $this->resetForm(false);

        session()->flash('success', 'Usuario creado correctamente. Contraseña temporal: ' . $this->passwordTemporal);
    }

    public function actualizar(): void
    {
        $usuario = Usuario::findOrFail($this->usuarioEditId);

        $this->validate([
            'nombre_completo' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email,' . $usuario->id],
            'dni' => ['required', 'string', 'max:20', 'unique:usuarios,dni,' . $usuario->id],
            'rol' => ['required', 'in:usuario,administrador'],
            'estado' => ['required', 'in:activo,bloqueado'],
        ]);

        if ($usuario->id === auth()->id() && $this->rol !== 'administrador') {
            session()->flash('error', 'No podés quitarte tu propio rol de administrador.');
            return;
        }

        if ($usuario->id === auth()->id() && $this->estado === 'bloqueado') {
            session()->flash('error', 'No podés bloquear tu propia cuenta.');
            return;
        }

        [$nombre, $apellido] = $this->dividirNombreCompleto();

        $rol = Role::where('nombre', $this->rol)->firstOrFail();

        $usuario->update([
            'rol_id' => $rol->id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $this->dni,
            'email' => $this->email,
            'bloqueado' => $this->estado === 'bloqueado',
            'fecha_bloqueo' => $this->estado === 'bloqueado' ? now() : null,
        ]);

        $this->cerrarModales();
        $this->resetForm();

        session()->flash('success', 'Usuario actualizado correctamente.');
    }

    public function cambiarBloqueo(int $usuarioId): void
    {
        $usuario = Usuario::findOrFail($usuarioId);

        if ($usuario->id === auth()->id()) {
            session()->flash('error', 'No podés bloquear tu propia cuenta.');
            return;
        }

        $usuario->update([
            'bloqueado' => ! $usuario->bloqueado,
            'fecha_bloqueo' => $usuario->bloqueado ? null : now(),
        ]);

        session()->flash('success', $usuario->bloqueado ? 'Usuario desbloqueado correctamente.' : 'Usuario bloqueado correctamente.');
    }

    public function eliminar(int $usuarioId): void
    {
        $usuario = Usuario::findOrFail($usuarioId);

        if ($usuario->id === auth()->id()) {
            session()->flash('error', 'No podés eliminar tu propia cuenta.');
            return;
        }

        try {
            $usuario->delete();

            session()->flash('success', 'Usuario eliminado correctamente.');
        } catch (\Throwable $e) {
            session()->flash('error', 'No se puede eliminar este usuario porque tiene compras o registros asociados. Podés bloquearlo.');
        }
    }

    private function dividirNombreCompleto(): array
    {
        $partes = preg_split('/\s+/', trim($this->nombre_completo));

        if (count($partes) === 1) {
            return [$partes[0], ''];
        }

        $nombre = array_shift($partes);
        $apellido = implode(' ', $partes);

        return [$nombre, $apellido];
    }

    private function resetForm(bool $resetPasswordTemporal = true): void
    {
        $this->reset([
            'usuarioEditId',
            'nombre_completo',
            'email',
            'dni',
        ]);

        $this->rol = 'usuario';
        $this->estado = 'activo';

        if ($resetPasswordTemporal) {
            $this->passwordTemporal = null;
        }
    }

    public function render()
    {
        $usuarios = Usuario::query()
            ->with('rol')
            ->withCount('compras')
            ->when($this->buscar !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->buscar . '%')
                        ->orWhere('apellido', 'like', '%' . $this->buscar . '%')
                        ->orWhere('email', 'like', '%' . $this->buscar . '%')
                        ->orWhere('dni', 'like', '%' . $this->buscar . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.admin.usuarios.usuarios-page', [
            'usuarios' => $usuarios,
        ])->layout('components.layouts.admin', [
            'title' => 'Usuarios',
        ]);
    }
}