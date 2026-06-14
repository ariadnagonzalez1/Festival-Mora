<div class="min-h-screen bg-[#050512] pb-10 text-white">

    <div>
        <h1 class="text-4xl font-black text-white">
            Validar entradas
        </h1>

        <p class="mt-2 text-slate-400">
            Escaneá o ingresá el código del QR para validar el acceso.
        </p>
    </div>

    <section class="mt-8 grid gap-6 xl:grid-cols-2">

        {{-- LECTOR --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-white">
                        Lector de QR
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Usá la cámara o cargá el código manualmente.
                    </p>
                </div>

                <span class="text-2xl text-violet-400">
                    ⌗
                </span>
            </div>

            <div class="rounded-3xl border border-dashed border-white/10 bg-black/20 p-4">
                <video
                    id="qr-video"
                    class="hidden h-72 w-full rounded-2xl object-cover"
                    autoplay
                    muted
                    playsinline
                ></video>

                <div id="qr-placeholder" class="flex h-72 flex-col items-center justify-center rounded-2xl bg-[#050512] text-center">
                    <div class="text-6xl text-slate-700">
                        ⌗
                    </div>

                    <p class="mt-4 text-sm font-bold text-slate-300">
                        Cámara del dispositivo
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Tocá “Activar cámara” para escanear.
                    </p>
                </div>
            </div>

            <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                <x-admin.ui.button type="button" variant="secondary" id="start-qr-camera">
                    Activar cámara
                </x-admin.ui.button>

                <x-admin.ui.button type="button" variant="danger" id="stop-qr-camera">
                    Detener
                </x-admin.ui.button>
            </div>

            <form wire:submit.prevent="validar" class="mt-5 flex flex-col gap-3 sm:flex-row">
                <div class="flex-1">
                    <input
                        type="text"
                        wire:model.defer="codigoQr"
                        placeholder="Ingresá el código del QR"
                        class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                    >

                    @error('codigoQr')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <x-admin.ui.button type="submit">
                    Validar
                </x-admin.ui.button>
            </form>

            <p class="mt-4 text-xs text-slate-500">
                También podés copiar el código QR manualmente si la cámara no está disponible.
            </p>
        </div>

        {{-- RESULTADO --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-xl font-black text-white">
                    Resultado
                </h2>

                @if($resultado)
                    <x-admin.ui.button type="button" variant="ghost" size="sm" wire:click="limpiarResultado">
                        Limpiar
                    </x-admin.ui.button>
                @endif
            </div>

            @if(! $resultado)
                <div class="flex min-h-[430px] flex-col items-center justify-center text-center">
                    <div class="text-6xl text-slate-700">
                        ⌗
                    </div>

                    <p class="mt-4 text-slate-400">
                        Esperando lectura del código...
                    </p>
                </div>
            @else
                <div class="rounded-3xl border p-5
                    @if($resultado['tipo'] === 'success') border-emerald-400/30 bg-emerald-500/10
                    @elseif($resultado['tipo'] === 'warning') border-yellow-400/30 bg-yellow-500/10
                    @else border-red-400/30 bg-red-500/10
                    @endif
                ">
                    <h3 class="text-2xl font-black
                        @if($resultado['tipo'] === 'success') text-emerald-300
                        @elseif($resultado['tipo'] === 'warning') text-yellow-300
                        @else text-red-300
                        @endif
                    ">
                        {{ $resultado['titulo'] }}
                    </h3>

                    <p class="mt-2 text-sm text-slate-300">
                        {{ $resultado['mensaje'] }}
                    </p>
                </div>

                @if($resultado['datos'])
                    <div class="mt-6 space-y-3">
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                Evento
                            </p>
                            <p class="mt-1 font-black text-white">
                                {{ $resultado['datos']['evento'] }}
                            </p>
                            <p class="mt-1 text-sm text-slate-400">
                                {{ $resultado['datos']['fecha_evento'] }}
                            </p>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                <p class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                    Comprador
                                </p>
                                <p class="mt-1 font-bold text-white">
                                    {{ $resultado['datos']['comprador'] ?: 'Sin nombre' }}
                                </p>
                                <p class="mt-1 text-sm text-slate-400">
                                    DNI: {{ $resultado['datos']['dni'] }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                <p class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                    Entrada
                                </p>
                                <p class="mt-1 font-bold text-white">
                                    {{ $resultado['datos']['tipo_entrada'] }}
                                </p>
                                <p class="mt-1 text-sm text-slate-400">
                                    {{ $resultado['datos']['ubicacion'] }}
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                <p class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                    Pago
                                </p>
                                <p class="mt-1 font-bold text-white">
                                    {{ ucfirst($resultado['datos']['estado_compra']) }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                <p class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                    Uso
                                </p>
                                <p class="mt-1 font-bold text-white">
                                    {{ $resultado['datos']['estado_uso'] === 'usada' ? 'Usada' : 'No usada' }}
                                </p>

                                @if($resultado['datos']['fecha_uso'])
                                    <p class="mt-1 text-sm text-slate-400">
                                        {{ $resultado['datos']['fecha_uso'] }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                Código QR
                            </p>
                            <p class="mt-1 break-all text-sm text-slate-300">
                                {{ $resultado['datos']['codigo_qr'] }}
                            </p>
                        </div>
                    </div>
                @endif
            @endif
        </div>

    </section>

    <script>
        document.addEventListener('livewire:navigated', () => {
            initQrScanner();
        });

        document.addEventListener('DOMContentLoaded', () => {
            initQrScanner();
        });

        function initQrScanner() {
            const startButton = document.getElementById('start-qr-camera');
            const stopButton = document.getElementById('stop-qr-camera');
            const video = document.getElementById('qr-video');
            const placeholder = document.getElementById('qr-placeholder');

            if (!startButton || !stopButton || !video) {
                return;
            }

            let stream = null;
            let scanning = false;
            let detector = null;

            if ('BarcodeDetector' in window) {
                detector = new BarcodeDetector({ formats: ['qr_code'] });
            }

            startButton.onclick = async () => {
                if (!detector) {
                    alert('Tu navegador no soporta lector QR nativo. Ingresá el código manualmente.');
                    return;
                }

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'environment' }
                    });

                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    placeholder.classList.add('hidden');

                    scanning = true;
                    scanLoop();
                } catch (error) {
                    alert('No se pudo acceder a la cámara. Revisá los permisos del navegador.');
                }
            };

            stopButton.onclick = () => {
                scanning = false;

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }

                video.classList.add('hidden');
                placeholder.classList.remove('hidden');
            };

            async function scanLoop() {
                if (!scanning) {
                    return;
                }

                try {
                    const codes = await detector.detect(video);

                    if (codes.length > 0) {
                        const codigo = codes[0].rawValue;

                        @this.set('codigoQr', codigo);
                        @this.call('validar');

                        scanning = false;

                        if (stream) {
                            stream.getTracks().forEach(track => track.stop());
                        }

                        video.classList.add('hidden');
                        placeholder.classList.remove('hidden');

                        return;
                    }
                } catch (error) {
                    console.log(error);
                }

                requestAnimationFrame(scanLoop);
            }
        }
    </script>

</div>