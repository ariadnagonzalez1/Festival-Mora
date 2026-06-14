<?php

namespace App\Livewire\Admin\Artistas;

use App\Models\Artista;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ArtistasPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $buscar = '';

    public bool $modalCreate = false;
    public bool $modalEdit = false;

    public ?int $artistaEditId = null;

    public string $nombre = '';
    public string $genero = '';
    public string $instagram_url = '';
    public string $bio = '';
    public bool $destacado = true;

    public $foto_file = null;
    public ?string $foto_url = null;

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function abrirCrear(): void
    {
        $this->resetForm();
        $this->modalCreate = true;
    }

    public function cerrarModales(): void
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->resetValidation();
    }

    public function crear(): void
    {
        $this->validarFormulario();

        Artista::create([
            'nombre' => $this->nombre,
            'genero' => $this->genero ?: null,
            'instagram_url' => $this->instagram_url ?: null,
            'foto_url' => $this->guardarFoto(),
            'bio' => $this->bio ?: null,
            'destacado' => $this->destacado,
        ]);

        $this->cerrarModales();
        $this->resetForm();

        session()->flash('success', 'Artista creado correctamente.');
    }

    public function abrirEditar(int $artistaId): void
    {
        $artista = Artista::findOrFail($artistaId);

        $this->artistaEditId = $artista->id;
        $this->nombre = $artista->nombre;
        $this->genero = $artista->genero ?? '';
        $this->instagram_url = $artista->instagram_url ?? '';
        $this->bio = $artista->bio ?? '';
        $this->destacado = (bool) $artista->destacado;
        $this->foto_url = $artista->foto_url;

        $this->modalEdit = true;
    }

    public function actualizar(): void
    {
        $this->validarFormulario();

        $artista = Artista::findOrFail($this->artistaEditId);

        $artista->update([
            'nombre' => $this->nombre,
            'genero' => $this->genero ?: null,
            'instagram_url' => $this->instagram_url ?: null,
            'foto_url' => $this->guardarFoto($artista),
            'bio' => $this->bio ?: null,
            'destacado' => $this->destacado,
        ]);

        $this->cerrarModales();
        $this->resetForm();

        session()->flash('success', 'Artista actualizado correctamente.');
    }

    public function eliminar(int $artistaId): void
    {
        try {
            Artista::findOrFail($artistaId)->delete();

            session()->flash('success', 'Artista eliminado correctamente.');
        } catch (\Throwable $e) {
            session()->flash('error', 'No se puede eliminar este artista porque está asociado a eventos.');
        }
    }

    private function validarFormulario(): void
    {
        $this->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'genero' => ['nullable', 'string', 'max:100'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'destacado' => ['boolean'],
            'foto_file' => ['nullable', 'image', 'max:2048'],
        ], [
            'nombre.required' => 'Ingresá el nombre artístico.',
            'foto_file.image' => 'El archivo debe ser una imagen.',
            'foto_file.max' => 'La imagen no debe superar los 2MB.',
        ]);
    }

    private function guardarFoto(?Artista $artista = null): ?string
    {
        if ($this->foto_file) {
            $path = $this->foto_file->store('artistas', 'public');

            return 'storage/' . $path;
        }

        return $artista?->foto_url;
    }

    private function resetForm(): void
    {
        $this->reset([
            'artistaEditId',
            'nombre',
            'genero',
            'instagram_url',
            'bio',
            'foto_file',
            'foto_url',
        ]);

        $this->destacado = true;
    }

    public function render()
    {
        $artistas = Artista::query()
            ->when($this->buscar !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->buscar . '%')
                        ->orWhere('genero', 'like', '%' . $this->buscar . '%')
                        ->orWhere('instagram_url', 'like', '%' . $this->buscar . '%');
                });
            })
            ->orderByDesc('destacado')
            ->orderBy('nombre')
            ->paginate(9);

        return view('livewire.admin.artistas.artistas-page', [
            'artistas' => $artistas,
        ])->layout('components.layouts.admin', [
            'title' => 'Artistas',
        ]);
    }
}