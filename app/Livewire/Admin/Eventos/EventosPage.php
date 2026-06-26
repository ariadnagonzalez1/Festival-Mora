<?php

namespace App\Livewire\Admin\Eventos;

use App\Models\Evento;
use App\Models\TipoEntrada;
use App\Services\TipoEntradaQrPagoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

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
                'descripcion' => 'Entrada general. Venta online con QR de pago.',
                'precio' => 15000,
                'stock_disponible' => 500,
                'activo' => true,
                'venta_online' => true,
                'venta_fisica' => false,
                'metodo_pago' => 'qr_mercado_pago',
                'ubicacion_descripcion' => 'Sector General',

                'qr_pago_codigo' => null,
                'qr_pago_data' => null,
                'qr_pago_receptor' => null,
                'qr_pago_concepto' => null,
                'qr_pago_monto' => null,
                'qr_pago_estado' => null,
                'qr_pago_generado_at' => null,
            ],
            [
                'nombre' => 'VIP Plata de pie',
                'descripcion' => 'Entrada VIP Plata de pie. Venta online con QR de pago.',
                'precio' => 20000,
                'stock_disponible' => 300,
                'activo' => true,
                'venta_online' => true,
                'venta_fisica' => false,
                'metodo_pago' => 'qr_mercado_pago',
                'ubicacion_descripcion' => 'Sector VIP Plata de pie',

                'qr_pago_codigo' => null,
                'qr_pago_data' => null,
                'qr_pago_receptor' => null,
                'qr_pago_concepto' => null,
                'qr_pago_monto' => null,
                'qr_pago_estado' => null,
                'qr_pago_generado_at' => null,
            ],
            [
                'nombre' => 'VIP Oro',
                'descripcion' => 'Entrada VIP Oro. Venta online con QR de pago.',
                'precio' => 30000,
                'stock_disponible' => 100,
                'activo' => true,
                'venta_online' => true,
                'venta_fisica' => false,
                'metodo_pago' => 'qr_mercado_pago',
                'ubicacion_descripcion' => 'Sector VIP Oro',

                'qr_pago_codigo' => null,
                'qr_pago_data' => null,
                'qr_pago_receptor' => null,
                'qr_pago_concepto' => null,
                'qr_pago_monto' => null,
                'qr_pago_estado' => null,
                'qr_pago_generado_at' => null,
            ],
        ];

        $this->modalCreate = true;
    }

    public function abrirEditar(int $eventoId): void
    {
        $evento = Evento::with('tiposEntradas')->findOrFail($eventoId);

        $this->eventoEditId = $evento->id;

        $this->titulo = $evento->titulo;
        $this->descripcion = $evento->descripcion ?? '';
        $this->fecha_inicio = optional($evento->fecha_inicio)->format('Y-m-d\TH:i') ?? '';
        $this->fecha_fin = '';
        $this->lugar = $evento->lugar ?? '';
        $this->ciudad = $evento->ciudad ?? '';
        $this->provincia = $evento->provincia ?? '';
        $this->imagen_url = $evento->imagen_url ?? '';
        $this->estado = $evento->estado ?? 'publicado';
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

                'qr_pago_codigo' => $tipo->qr_pago_codigo,
                'qr_pago_data' => $tipo->qr_pago_data,
                'qr_pago_receptor' => $tipo->qr_pago_receptor,
                'qr_pago_concepto' => $tipo->qr_pago_concepto,
                'qr_pago_monto' => $tipo->qr_pago_monto,
                'qr_pago_estado' => $tipo->qr_pago_estado,
                'qr_pago_generado_at' => $tipo->qr_pago_generado_at,
            ];
        })->toArray();

        $this->modalEdit = true;
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

            'qr_pago_codigo' => null,
            'qr_pago_data' => null,
            'qr_pago_receptor' => null,
            'qr_pago_concepto' => null,
            'qr_pago_monto' => null,
            'qr_pago_estado' => null,
            'qr_pago_generado_at' => null,
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

        session()->flash('success', 'Evento creado correctamente. Los QR de pago fueron generados.');
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

        session()->flash('success', 'Evento actualizado correctamente. Los QR de pago fueron actualizados.');
    }

    public function duplicar(int $eventoId): void
    {
        $evento = Evento::with('tiposEntradas')->findOrFail($eventoId);

        DB::transaction(function () use ($evento) {
            $nuevo = $evento->replicate();
            $nuevo->titulo = $evento->titulo . ' - copia';
            $nuevo->slug = $this->generarSlug($nuevo->titulo);
            $nuevo->estado = 'publicado';
            $nuevo->mostrar_en_banner = false;
            $nuevo->created_by = auth()->id();
            $nuevo->save();

            foreach ($evento->tiposEntradas as $tipo) {
                $nuevoTipo = $tipo->replicate();

                $nuevoTipo->evento_id = $nuevo->id;
                $nuevoTipo->stock_vendido = 0;
                $nuevoTipo->stock_reservado = 0;

                $nuevoTipo->qr_pago_codigo = null;
                $nuevoTipo->qr_pago_data = null;
                $nuevoTipo->qr_pago_receptor = null;
                $nuevoTipo->qr_pago_concepto = null;
                $nuevoTipo->qr_pago_monto = null;
                $nuevoTipo->qr_pago_estado = null;
                $nuevoTipo->qr_pago_generado_at = null;

                $nuevoTipo->save();

                app(TipoEntradaQrPagoService::class)->generarParaTipoEntrada($nuevoTipo);
            }
        });

        session()->flash('success', 'Evento duplicado correctamente con nuevos QR de pago.');
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
            $stockDisponible = (int) ($tipo['stock_disponible'] ?? 0);

            $data = [
                'evento_id' => $evento->id,
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'] ?: null,
                'precio' => $tipo['precio'] ?: 0,
                'stock_total' => $stockDisponible,
                'stock_disponible' => $stockDisponible,
                'umbral_bajo_stock' => max(5, ceil($stockDisponible * 0.10)),
                'activo' => (bool) ($tipo['activo'] ?? true),
                'venta_online' => (bool) ($tipo['venta_online'] ?? true),
                'venta_fisica' => (bool) ($tipo['venta_fisica'] ?? false),
                'metodo_pago' => $tipo['metodo_pago'] ?? 'qr_mercado_pago',
                'ubicacion_descripcion' => $tipo['ubicacion_descripcion'] ?: null,
            ];

            if (! empty($tipo['id'])) {
                $tipoEntrada = TipoEntrada::where('evento_id', $evento->id)
                    ->findOrFail($tipo['id']);

                $tipoEntrada->update($data);
            } else {
                $data['stock_reservado'] = 0;
                $data['stock_vendido'] = 0;

                $tipoEntrada = TipoEntrada::create($data);
            }

            app(TipoEntradaQrPagoService::class)->generarParaTipoEntrada($tipoEntrada);
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
            'tipos.*.descripcion' => ['nullable', 'string'],
            'tipos.*.precio' => ['required', 'numeric', 'min:0'],
            'tipos.*.stock_disponible' => ['required', 'integer', 'min:0'],
            'tipos.*.metodo_pago' => ['required', 'in:qr_mercado_pago,efectivo,ambos'],
        ], [
            'titulo.required' => 'Ingresá el título del evento.',
            'fecha_inicio.required' => 'Ingresá la fecha del evento.',
            'tipos.required' => 'Agregá al menos un tipo de entrada.',
            'tipos.*.nombre.required' => 'Ingresá el nombre de la entrada.',
            'tipos.*.precio.required' => 'Ingresá el precio de la entrada.',
            'tipos.*.stock_disponible.required' => 'Ingresá el stock disponible.',
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