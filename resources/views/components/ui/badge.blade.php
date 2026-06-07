@props([
    'color' => 'primary', // primary | secondary | success | warning | danger | info | accent
])
@php
    $map = [
        'primary'   => 'bg-primary-100 text-primary-700',
        'secondary' => 'bg-secondary-100 text-secondary-700',
        'success'   => 'bg-success-100 text-success-700',
        'warning'   => 'bg-warning-100 text-warning-800',
        'danger'    => 'bg-danger-100 text-danger-700',
        'info'      => 'bg-info-100 text-info-700',
        'accent'    => 'bg-accent-100 text-accent-700',
    ];
    $classes = $map[$color] ?? $map['primary'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold $classes"]) }}>
    {{ $slot }}
</span>
