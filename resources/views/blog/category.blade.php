@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
@endphp

@section('title', $category->name . ' - ' . $siteName)
@section('description', $category->description)

@section('content')
    <!-- Category header -->
    <div class="bg-gradient-to-r from-primary-700 to-primary-500 text-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <nav class="mb-4 flex justify-center" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center gap-2 text-sm text-primary-100">
                        <li><a href="{{ route('blog.index') }}" class="hover:text-white">Inicio</a></li>
                        <li class="flex items-center gap-2">
                            <x-lucide-chevron-right class="h-4 w-4 text-primary-200" />
                            <span>{{ $category->name }}</span>
                        </li>
                    </ol>
                </nav>

                <div class="mb-4 flex items-center justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl text-2xl font-bold text-white shadow-lg ring-4 ring-white/20"
                         style="background-color: {{ $category->color }}">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($category->name, 0, 2)) }}
                    </div>
                </div>

                <h1 class="mb-4 text-4xl font-bold md:text-5xl">{{ $category->name }}</h1>

                @if($category->description)
                    <p class="mx-auto mb-6 max-w-3xl text-xl text-primary-100">{{ $category->description }}</p>
                @endif

                <div class="text-primary-100">
                    <span class="text-2xl font-bold text-white">{{ $posts->total() }}</span> artículos
                </div>
            </div>
        </div>
    </div>

    <!-- Posts grid -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
                <div class="mt-12 flex justify-center">{{ $posts->links() }}</div>
            @else
                <x-empty-state icon="folder-open" title="No hay artículos en esta categoría"
                    message="Aún no se han publicado artículos en &quot;{{ $category->name }}&quot;.">
                    <x-ui.button :href="route('blog.index')" icon="arrow-left">Ver todos los artículos</x-ui.button>
                </x-empty-state>
            @endif
        </div>
    </section>

    <!-- Other categories -->
    @php $otherCategories = $navCategories->where('id', '!=', $category->id); @endphp
    @if($otherCategories->isNotEmpty())
        <section class="bg-secondary-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-center text-2xl font-bold text-secondary-900">Otras categorías</h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
                    @foreach($otherCategories as $other)
                        <a href="{{ route('blog.category', $other->slug) }}"
                           class="group block rounded-2xl bg-white p-4 text-center shadow-soft ring-1 ring-secondary-100 transition hover:-translate-y-1 hover:shadow-medium">
                            <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-xl font-bold text-white"
                                 style="background-color: {{ $other->color }}">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($other->name, 0, 2)) }}
                            </div>
                            <h3 class="text-sm font-medium text-secondary-900 group-hover:text-primary-600">{{ $other->name }}</h3>
                            <p class="mt-1 text-xs text-secondary-500">{{ $other->published_posts_count }} artículos</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
