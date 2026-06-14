<?php

namespace App\Livewire\Admin\Eventos;

use App\Models\Evento;
use App\Models\TipoEntrada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EventosPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $buscar = '';

    public bool $modalCreate = false;
    public bool $modalEdit = false;

    public ?int $eventoEditId = null;

    public string $titulo = '';
    public string $descripcion = '';
    public string $fecha_inicio = '';
    public string $fecha_fin = '';
    public string $lugar = '';
    public string $ciudad = '';
    public string $provincia = '';
    public $imagen_file = null;
    public string $imagen_url = '';
    public string $estado = 'publicado';

    public bool $mostrar_en_banner = false;
    public bool $mostrar_en_inicio = true;

    public array $tipos = [];

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function abrirCrear(): void
    {
        $this->resetForm();

        $this->tipos = [
    [
        'nombre' => 'General',
        'descripcion' => 'Entrada general. Venta online con QR de Mercado Pago.',
        'precio' => 15000,
        'stock_disponible' => 500,
        'activo' => true,
        'venta_online' => true,
        'venta_fisica' => false,
        'metodo_pago' => 'qr_mercado_pago',
        'ubicacion_descripcion' => 'Sector General',
    ],
    [
        'nombre' => 'VIP Plata de pie',
        'descripcion' => 'Entrada VIP Plata de pie. Venta online con QR de Mercado Pago.',
        'precio' => 20000,
        'stock_disponible' => 300,
        'activo' => true,
        'venta_online' => true,
        'venta_fisica' => false,
        'metodo_pago' => 'qr_mercado_pago',
        'ubicacion_descripcion' => 'Sector VIP Plata de pie',
    ],
    [
        'nombre' => 'VIP Oro',
        'descripcion' => 'Entrada VIP Oro. Solo venta presencial en efectivo.',
        'precio' => 0,
        'stock_disponible' => 0,
        'activo' => true,
        'venta_online' => false,
        'venta_fisica' => true,
        'metodo_pago' => 'efectivo',
        'ubicacion_descripcion' => 'Sector VIP Oro - venta presencial',
    ],
];

        $this->modalCreate = true;
    }

    public function cerrarModales(): void
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->resetValidation();
    }

    public function agregarTipo(): void
{
    $this->tipos[] = [
        'nombre' => '',
        'descripcion' => '',
        'precio' => 0,
        'stock_disponible' => 0,
        'activo' => true,
        'venta_online' => true,
        'venta_fisica' => false,
        'metodo_pago' => 'qr_mercado_pago',
        'ubicacion_descripcion' => '',
    ];
}

    public function quitarTipo(int $index): void
    {
        unset($this->tipos[$index]);
        $this->tipos = array_values($this->tipos);
    }

    public function crear(): void
    {
        $this->validarFormulario();

        DB::transaction(function () {
            $evento = Evento::create([
                'titulo' => $this->titulo,
                'slug' => $this->generarSlug($this->titulo),
                'descripcion' => $this->descripcion ?: null,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => null,
                'lugar' => $this->lugar ?: null,
                'ciudad' => $this->ciudad ?: null,
                'provincia' => $this->provincia ?: null,
                'imagen_url' => $this->guardarImagen(),
                'estado' => 'publicado',
                'mostrar_en_banner' => $this->mostrar_en_banner,
                'mostrar_en_inicio' => $this->mostrar_en_inicio,
                'created_by' => auth()->id(),
            ]);

            $this->guardarTipos($evento);
        });

        $this->cerrarModales();
        $this->resetForm();

        session()->flash('success', 'Evento creado correctamente.');
    }

    public function abrirEditar(int $eventoId): void
    {
        $evento = Evento::with('tiposEntradas')->findOrFail($eventoId);

        $this->eventoEditId = $evento->id;

        $this->titulo = $evento->titulo;
        $this->descripcion = $evento->descripcion ?? '';
        $this->fecha_inicio = optional($evento->fecha_inicio)->format('Y-m-d\TH:i') ?? '';
        $this->lugar = $evento->lugar ?? '';
        $this->ciudad = $evento->ciudad ?? '';
        $this->provincia = $evento->provincia ?? '';
        $this->imagen_url = $evento->imagen_url ?? '';
        $this->mostrar_en_banner = (bool) $evento->mostrar_en_banner;
        $this->mostrar_en_inicio = (bool) $evento->mostrar_en_inicio;

        $this->tipos = $evento->tiposEntradas->map(function ($tipo) {
    return [
        'id' => $tipo->id,
        'nombre' => $tipo->nombre,
        'descripcion' => $tipo->descripcion,
        'precio' => $tipo->precio,
        'stock_disponible' => $tipo->stock_disponible,
        'activo' => (bool) $tipo->activo,
        'venta_online' => (bool) $tipo->venta_online,
        'venta_fisica' => (bool) $tipo->venta_fisica,
        'metodo_pago' => $tipo->metodo_pago,
        'ubicacion_descripcion' => $tipo->ubicacion_descripcion,
    ];
})->toArray();

        $this->modalEdit = true;
    }

    public function actualizar(): void
    {
        $this->validarFormulario();

        $evento = Evento::findOrFail($this->eventoEditId);

        DB::transaction(function () use ($evento) {
            $evento->update([
                'titulo' => $this->titulo,
                'slug' => $this->generarSlug($this->titulo, $evento->id),
                'descripcion' => $this->descripcion ?: null,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => null,
                'lugar' => $this->lugar ?: null,
                'ciudad' => $this->ciudad ?: null,
                'provincia' => $this->provincia ?: null,
                'imagen_url' => $this->guardarImagen($evento),
                'estado' => 'publicado',
                'mostrar_en_banner' => $this->mostrar_en_banner,
                'mostrar_en_inicio' => $this->mostrar_en_inicio,
            ]);

            $idsEnFormulario = collect($this->tipos)
                ->pluck('id')
                ->filter()
                ->values()
                ->toArray();

            $evento->tiposEntradas()
                ->whereNotIn('id', $idsEnFormulario)
                ->delete();

            $this->guardarTipos($evento);
        });

        $this->cerrarModales();
        $this->resetForm();

        session()->flash('success', 'Evento actualizado correctamente.');
    }

    public function duplicar(int $eventoId): void
    {
        $evento = Evento::with('tiposEntradas')->findOrFail($eventoId);

        DB::transaction(function () use ($evento) {
            $nuevo = $evento->replicate();
            $nuevo->titulo = $evento->titulo . ' - copia';
            $nuevo->slug = $this->generarSlug($nuevo->titulo);
            $nuevo->estado = 'borrador';
            $nuevo->mostrar_en_banner = false;
            $nuevo->created_by = auth()->id();
            $nuevo->save();

            foreach ($evento->tiposEntradas as $tipo) {
                $nuevoTipo = $tipo->replicate();
                $nuevoTipo->evento_id = $nuevo->id;
                $nuevoTipo->stock_vendido = 0;
                $nuevoTipo->stock_reservado = 0;
                $nuevoTipo->save();
            }
        });

        session()->flash('success', 'Evento duplicado como borrador.');
    }

    public function eliminar(int $eventoId): void
    {
        try {
            Evento::findOrFail($eventoId)->delete();

            session()->flash('success', 'Evento eliminado correctamente.');
        } catch (\Throwable $e) {
            session()->flash('error', 'No se puede eliminar este evento porque tiene compras, entradas o ventas asociadas.');
        }
    }

    private function guardarTipos(Evento $evento): void
    {
        foreach ($this->tipos as $tipo) {
            TipoEntrada::updateOrCreate(
                [
                    'id' => $tipo['id'] ?? null,
                ],
                [
                    'evento_id' => $evento->id,
                    'nombre' => $tipo['nombre'],
                    'descripcion' => $tipo['descripcion'] ?: null,
                    'precio' => $tipo['precio'] ?: 0,
                    'stock_total' => (int) ($tipo['stock_disponible'] ?? 0),
                    'stock_disponible' => (int) ($tipo['stock_disponible'] ?? 0),
                    'stock_reservado' => 0,
                    'stock_vendido' => 0,
                    'umbral_bajo_stock' => max(5, ceil(((int) ($tipo['stock_disponible'] ?? 0)) * 0.10)),
                    'activo' => (bool) $tipo['activo'],
                    'venta_online' => (bool) $tipo['venta_online'],
                    'venta_fisica' => (bool) $tipo['venta_fisica'],
                    'metodo_pago' => $tipo['metodo_pago'],
                    'ubicacion_descripcion' => $tipo['ubicacion_descripcion'] ?: null,
                ]
            );
        }
    }

    private function validarFormulario(): void
    {
        $this->validate([
    'titulo' => ['required', 'string', 'max:200'],
    'descripcion' => ['nullable', 'string'],
    'fecha_inicio' => ['required', 'date'],
    'lugar' => ['nullable', 'string', 'max:200'],
    'ciudad' => ['nullable', 'string', 'max:100'],
    'provincia' => ['nullable', 'string', 'max:100'],
    'imagen_file' => ['nullable', 'image', 'max:2048'],
    'tipos' => ['required', 'array', 'min:1'],
    'tipos.*.nombre' => ['required', 'string', 'max:100'],
    'tipos.*.precio' => ['required', 'numeric', 'min:0'],
    'tipos.*.stock_disponible' => ['required', 'integer', 'min:0'],
    'tipos.*.metodo_pago' => ['required', 'in:qr_mercado_pago,efectivo,ambos'],
]);
    }

    private function generarSlug(string $titulo, ?int $ignorarId = null): string
    {
        $base = Str::slug($titulo);
        $slug = $base;
        $contador = 1;

        while (
            Evento::where('slug', $slug)
                ->when($ignorarId, fn ($query) => $query->where('id', '!=', $ignorarId))
                ->exists()
        ) {
            $slug = $base . '-' . $contador;
            $contador++;
        }

        return $slug;
    }

    private function resetForm(): void
    {
    
    $this->reset([
    'eventoEditId',
    'titulo',
    'descripcion',
    'fecha_inicio',
    'fecha_fin',
    'lugar',
    'ciudad',
    'provincia',
    'imagen_url',
    'imagen_file',
    'tipos',
]);

        $this->estado = 'publicado';
        $this->mostrar_en_banner = false;
        $this->mostrar_en_inicio = true;
    }

    private function guardarImagen(?Evento $evento = null): ?string
{
    if ($this->imagen_file) {
        $path = $this->imagen_file->store('eventos', 'public');

        return 'storage/' . $path;
    }

    return $evento?->imagen_url ?: null;
}

    public function render()
    {
        $eventos = Evento::query()
            ->with('tiposEntradas')
            ->when($this->buscar !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('titulo', 'like', '%' . $this->buscar . '%')
                        ->orWhere('ciudad', 'like', '%' . $this->buscar . '%')
                        ->orWhere('lugar', 'like', '%' . $this->buscar . '%');
                });
            })
            ->orderByDesc('fecha_inicio')
            ->paginate(8);

        return view('livewire.admin.eventos.eventos-page', [
            'eventos' => $eventos,
        ])->layout('components.layouts.admin', [
            'title' => 'Eventos',
        ]);
    }
}