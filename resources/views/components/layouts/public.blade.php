@props([
    'title' => 'Mora Producciones'
])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Mora Producciones</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#050512] text-white antialiased">
    <div class="min-h-screen bg-[#050512]">
        <x-public.navbar />

        <main>
            {{ $slot }}
        </main>

        <x-public.footer />
    </div>

    @livewireScripts
</body>
</html>