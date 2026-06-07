@props([
    'label' => '',
    'value' => '',
    'icon'  => null,
    'color' => 'primary', // primary | success | warning | danger | secondary | accent
])
@php
    $map = [
        'primary'   => 'bg-primary-50 text-primary-600',
        'success'   => 'bg-success-50 text-success-600',
        'warning'   => 'bg-warning-50 text-warning-600',
        'danger'    => 'bg-danger-50 text-danger-600',
        'secondary' => 'bg-secondary-100 text-secondary-600',
        'accent'    => 'bg-accent-50 text-accent-600',
    ];
    $tint = $map[$color] ?? $map['primary'];
@endphp
<div {{ $attributes->merge(['class' => 'flex items-center gap-4 rounded-2xl bg-white p-5 shadow-soft ring-1 ring-secondary-100']) }}>
    @if($icon)
        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $tint }}">
            <x-dynamic-component :component="'lucide-' . $icon" class="h-6 w-6" />
        </span>
    @endif
    <div>
        <div class="text-2xl font-bold text-secondary-900">{{ $value }}</div>
        <div class="text-sm text-secondary-500">{{ $label }}</div>
    </div>
</div>
