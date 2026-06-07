@props([
    'name' => '',
    'size' => 'md', // xs | sm | md | lg
    'src'  => null,
])
@php
    $sizes = [
        'xs' => 'h-7 w-7 text-[0.65rem]',
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
    ];
    $cls = $sizes[$size] ?? $sizes['md'];
    $initials = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(trim($name), 0, 2));
@endphp
@if($src)
    <img src="{{ $src }}" alt="{{ $name }}"
         {{ $attributes->merge(['class' => "$cls rounded-full object-cover ring-2 ring-white"]) }}>
@else
    <span {{ $attributes->merge(['class' => "$cls inline-flex items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-accent-500 font-semibold text-white"]) }}>
        {{ $initials ?: '?' }}
    </span>
@endif
