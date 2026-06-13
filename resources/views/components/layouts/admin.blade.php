@props([
    'title' => 'Panel administrador'
])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Mora Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#050512] text-white antialiased">
    <div class="min-h-screen bg-[#050512]">
        <div class="flex min-h-screen">
            <x-admin.sidebar />

            <main class="flex-1 lg:ml-64">
                <div class="px-4 py-8 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>