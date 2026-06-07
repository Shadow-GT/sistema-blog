@props([
    'variant' => 'primary', // primary | secondary | ghost | success | danger | warning
    'size'    => 'md',       // sm | md | lg
    'href'    => null,
    'icon'    => null,       // nombre de icono lucide (opcional)
    'type'    => 'button',
])
@php
    $variants = [
        'primary'   => 'bg-primary-600 hover:bg-primary-700 text-white shadow-sm',
        'secondary' => 'bg-white hover:bg-secondary-50 text-secondary-700 border border-secondary-200 shadow-sm',
        'ghost'     => 'text-secondary-600 hover:text-primary-700 hover:bg-primary-50',
        'success'   => 'bg-success-100 hover:bg-success-200 text-success-700',
        'danger'    => 'bg-danger-100 hover:bg-danger-200 text-danger-700',
        'warning'   => 'bg-warning-100 hover:bg-warning-200 text-warning-800',
    ];
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    $iconSize = $size === 'sm' ? 'h-4 w-4' : 'h-5 w-5';
    $cls = 'inline-flex items-center justify-center gap-2 rounded-xl font-medium transition-all duration-200 '
        . 'focus:outline-none focus:ring-2 focus:ring-primary-500/40 disabled:opacity-50 disabled:pointer-events-none '
        . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $cls]) }}>
        @if($icon)<x-dynamic-component :component="'lucide-' . $icon" :class="$iconSize" />@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $cls]) }}>
        @if($icon)<x-dynamic-component :component="'lucide-' . $icon" :class="$iconSize" />@endif
        {{ $slot }}
    </button>
@endif
