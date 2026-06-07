@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
    $siteDescription = \App\Models\BlogSetting::get('site_description', 'Descubre los últimos artículos en ' . $siteName . '. Contenido de calidad sobre diversos temas.');
    $siteLogo = \App\Models\BlogSetting::get('site_logo') ? asset('storage/' . \App\Models\BlogSetting::get('site_logo')) : asset('images/default-og-image.svg');
@endphp

@section('title', $siteName . ' - Blog')
@section('description', $siteDescription)

{{-- Open Graph / Facebook --}}
@section('og_title', $siteName . ' - Blog')
@section('og_description', $siteDescription)
@section('og_image', $siteLogo)

{{-- Twitter Cards --}}
@section('twitter_title', $siteName . ' - Blog')
@section('twitter_description', $siteDescription)
@section('twitter_image', $siteLogo)

{{-- Canonical limpio; noindex en páginas de filtro/búsqueda/paginación (contenido duplicado) --}}
@section('canonical', route('blog.index'))
@if(request()->hasAny(['search', 'category', 'type', 'sort', 'author', 'page']))
    @section('meta_robots', 'noindex, follow')
@endif

@section('content')
    <!-- Hero -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-accent-600"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.05%22%3E%3Ccircle cx=%2230%22 cy=%2230%22 r=%224%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
            <div class="text-center">
                <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white/90 backdrop-blur-sm">
                    <x-lucide-zap class="h-4 w-4" />
                    Últimas tendencias en tecnología
                </div>

                <h1 class="mb-6 text-5xl font-bold leading-tight text-white md:text-7xl">
                    <span class="bg-gradient-to-r from-accent-300 to-accent-100 bg-clip-text text-transparent">
                        {{ \App\Models\BlogSetting::get('header_text', config('app.name')) }}
                    </span>
                </h1>

                <p class="mx-auto mb-12 max-w-3xl text-xl leading-relaxed text-primary-100 md:text-2xl">
                    Descubre artículos, tutoriales y contenido de calidad en nuestro blog
                </p>

                <!-- Search -->
                <form action="{{ route('blog.index') }}" method="GET" class="mx-auto mb-8 max-w-2xl">
                    <div class="group relative">
                        <input type="text" name="search" placeholder="¿Qué quieres aprender hoy?" value="{{ request('search') }}"
                               class="w-full rounded-2xl border border-white/20 bg-white/95 py-4 pl-14 pr-28 text-lg text-secondary-900 placeholder-secondary-500 shadow-large backdrop-blur-sm transition-all duration-300 focus:border-white/40 focus:outline-none focus:ring-4 focus:ring-white/25">
                        <x-lucide-search class="pointer-events-none absolute inset-y-0 left-5 my-auto h-6 w-6 text-secondary-400 transition-colors group-focus-within:text-primary-500" />
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-xl bg-primary-600 px-6 py-2 font-medium text-white transition-colors duration-200 hover:bg-primary-700">
                            Buscar
                        </button>
                    </div>
                </form>

                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-8 text-white/80">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $stats['posts'] }}</div>
                        <div class="text-sm">Artículos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $stats['categories'] }}</div>
                        <div class="text-sm">Categorías</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $stats['authors'] }}</div>
                        <div class="text-sm">Autores</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured -->
    @if($featuredPosts->count() > 0)
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-accent-50 px-4 py-2 text-sm font-medium text-accent-700">
                        <x-lucide-star class="h-4 w-4 fill-current" /> Destacados
                    </div>
                    <h2 class="mb-4 text-4xl font-bold text-secondary-900 md:text-5xl">Artículos Destacados</h2>
                    <p class="mx-auto max-w-2xl text-xl text-secondary-600">Los mejores contenidos seleccionados por nuestro equipo editorial</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($featuredPosts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Filters -->
    <section class="border-b border-secondary-100 bg-white py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="flex items-center gap-2 text-sm font-semibold text-secondary-700">
                        <x-lucide-filter class="h-4 w-4" /> Filtrar por:
                    </span>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $category)
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                               class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200 {{ request('category') == $category->slug ? 'bg-primary-600 text-white shadow-medium' : 'bg-secondary-100 text-secondary-700 hover:bg-primary-50 hover:text-primary-700' }}">
                                <span class="h-2 w-2 rounded-full" style="background-color: {{ $category->color }}"></span>
                                {{ $category->name }}
                                <span class="rounded-full px-2 py-0.5 text-xs {{ request('category') == $category->slug ? 'bg-white/20' : 'bg-secondary-200' }}">{{ $category->published_posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                @if(request()->hasAny(['category', 'type', 'search']))
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-primary-600 transition-all duration-200 hover:bg-primary-50 hover:text-primary-700">
                        <x-lucide-x class="h-4 w-4" /> Limpiar filtros
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Posts grid -->
    <section class="bg-gradient-to-b from-white to-secondary-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(request('search'))
                <div class="mb-16 text-center">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-primary-50 px-4 py-2 text-sm font-medium text-primary-700">
                        <x-lucide-search class="h-4 w-4" /> Resultados de búsqueda
                    </div>
                    <h2 class="mb-2 text-3xl font-bold text-secondary-900 md:text-4xl">
                        Resultados para "<span class="text-primary-600">{{ request('search') }}</span>"
                    </h2>
                    <p class="text-xl text-secondary-600">{{ $posts->total() }} artículos encontrados</p>
                </div>
            @endif

            @if($posts->count() > 0)
                <div class="mb-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                <x-empty-state
                    icon="file-text"
                    title="No hay artículos"
                    message="No se encontraron artículos con los filtros seleccionados.">
                    <x-ui.button :href="route('blog.index')" icon="rotate-ccw">Ver todos los artículos</x-ui.button>
                </x-empty-state>
            @endif
        </div>
    </section>
@endsection
