@props([
    'icon'    => 'inbox',
    'title'   => '',
    'message' => '',
])
<div {{ $attributes->merge(['class' => 'flex flex-col items-center py-20 text-center']) }}>
    <span class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-secondary-100 text-secondary-400">
        <x-dynamic-component :component="'lucide-' . $icon" class="h-12 w-12" />
    </span>
    @if($title)
        <h3 class="mb-2 text-2xl font-bold text-secondary-900">{{ $title }}</h3>
    @endif
    @if($message)
        <p class="mb-8 max-w-md text-secondary-600">{{ $message }}</p>
    @endif
    {{ $slot }}
</div>
