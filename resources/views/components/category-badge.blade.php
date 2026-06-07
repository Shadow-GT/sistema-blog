@props([
    'category',
    'link' => true,
])
@php
    $base = 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold text-white shadow-sm';
@endphp
@if($link)
    <a href="{{ route('blog.category', $category->slug) }}"
       {{ $attributes->merge(['class' => $base]) }}
       style="background-color: {{ $category->color }}">{{ $category->name }}</a>
@else
    <span {{ $attributes->merge(['class' => $base]) }}
          style="background-color: {{ $category->color }}">{{ $category->name }}</span>
@endif
