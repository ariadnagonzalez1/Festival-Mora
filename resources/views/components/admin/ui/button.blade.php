@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-xl font-bold transition disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-sm',
        'icon' => 'h-10 w-10 text-sm',
    ];

    $variants = [
        'primary' => 'bg-violet-600 text-white hover:bg-violet-500',
        'secondary' => 'border border-white/10 bg-white/[0.04] text-white hover:bg-white/[0.08]',
        'danger' => 'border border-red-400/30 bg-red-500/10 text-red-200 hover:bg-red-500/20 hover:text-white',
        'ghost' => 'text-slate-300 hover:bg-white/[0.06] hover:text-white',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-500',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary'])
    ]) }}
>
    {{ $slot }}
</button>