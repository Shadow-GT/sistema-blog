@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
@endphp

@section('title', $siteName . ' - Blog')
@section('description', 'Descubre los últimos artículos en ' . $siteName . '. Contenido de calidad sobre diversos temas.')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-accent-600"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm font-medium mb-8">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Últimas tendencias en tecnología
            </div>

            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                <span class="bg-gradient-to-r from-accent-300 to-accent-100 bg-clip-text text-transparent">
                    {{ $siteName }}
                </span>
            </h1>

            <p class="text-xl md:text-2xl text-primary-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                Descubre artículos, tutoriales y contenido de calidad en nuestro blog
            </p>

            <!-- Search Bar -->
            <form action="{{ route('blog.index') }}" method="GET" class="max-w-2xl mx-auto mb-8">
                <div class="relative group">
                    <input type="text" name="search" placeholder="¿Qué quieres aprender hoy?"
                           value="{{ request('search') }}"
                           class="w-full pl-14 pr-6 py-4 text-secondary-900 bg-white/95 backdrop-blur-sm rounded-2xl border border-white/20 focus:ring-4 focus:ring-white/25 focus:border-white/40 focus:outline-none transition-all duration-300 text-lg placeholder-secondary-500 shadow-large">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-secondary-400 group-focus-within:text-primary-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors duration-200">
                        Buscar
                    </button>
                </div>
            </form>

            <!-- Stats -->
            <div class="flex flex-wrap justify-center gap-8 text-white/80">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ \App\Models\Post::published()->count() }}</div>
                    <div class="text-sm">Artículos</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ \App\Models\Category::active()->count() }}</div>
                    <div class="text-sm">Categorías</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ \App\Models\User::where('role', '!=', 'guest')->count() }}</div>
                    <div class="text-sm">Autores</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Posts -->
@if($featuredPosts->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-accent-50 text-accent-700 text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                Destacados
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-secondary-900 mb-4">Artículos Destacados</h2>
            <p class="text-xl text-secondary-600 max-w-2xl mx-auto">Los mejores contenidos seleccionados por nuestro equipo editorial</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPosts as $post)
            <article class="group bg-white rounded-3xl shadow-soft hover:shadow-large transition-all duration-500 overflow-hidden border border-secondary-100 hover:border-primary-200 hover:-translate-y-2">
                <div class="relative overflow-hidden">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                         class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-56 bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                        <span class="text-white text-3xl">{{ $post->postType->icon ?? '📄' }}</span>
                    </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-black/20 backdrop-blur-sm">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Destacado
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white"
                              style="background-color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-sm text-secondary-500 font-medium">{{ $post->postType->name }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-secondary-900 mb-3 group-hover:text-primary-600 transition-colors duration-300 line-clamp-2">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="text-secondary-600 mb-6 line-clamp-3 leading-relaxed">{{ $post->excerpt }}</p>

                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center text-secondary-500">
                            <div class="w-8 h-8 bg-secondary-200 rounded-full flex items-center justify-center mr-3">
                                <span class="text-xs font-medium">{{ substr($post->user->name, 0, 2) }}</span>
                            </div>
                            <span class="font-medium">{{ $post->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-secondary-400">
                            <span>{{ $post->published_at->format('d M Y') }}</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $post->views_count }}
                            </span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Filters -->
<section class="py-12 bg-white border-b border-secondary-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-sm font-semibold text-secondary-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filtrar por:
                </span>

                <!-- Categories -->
                <div class="flex flex-wrap gap-3">
                    @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ request('category') == $category->slug ? 'bg-primary-600 text-white shadow-medium' : 'bg-secondary-100 text-secondary-700 hover:bg-primary-50 hover:text-primary-700 hover:shadow-soft' }}">
                        <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $category->color }}"></div>
                        {{ $category->name }}
                        <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ request('category') == $category->slug ? 'bg-white/20' : 'bg-secondary-200' }}">
                            {{ $category->published_posts_count }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>

            @if(request()->hasAny(['category', 'type', 'search']))
            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Limpiar filtros
            </a>
            @endif
        </div>
    </div>
</section>

<!-- Posts Grid -->
<section class="py-20 bg-gradient-to-b from-white to-secondary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(request('search'))
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary-50 text-primary-700 text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Resultados de búsqueda
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-900 mb-2">
                Resultados para "<span class="text-primary-600">{{ request('search') }}</span>"
            </h2>
            <p class="text-xl text-secondary-600">{{ $posts->total() }} artículos encontrados</p>
        </div>
        @endif

        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach($posts as $post)
            <article class="group bg-white rounded-3xl shadow-soft hover:shadow-large transition-all duration-500 overflow-hidden border border-secondary-100 hover:border-primary-200 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center">
                        <span class="text-white text-3xl">{{ $post->postType->icon ?? '📄' }}</span>
                    </div>
                    @endif
                    @if($post->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold text-yellow-800 bg-yellow-100 border border-yellow-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Destacado
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white"
                              style="background-color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-sm text-secondary-500 font-medium">{{ $post->postType->name }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-secondary-900 mb-3 group-hover:text-primary-600 transition-colors duration-300 line-clamp-2">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="text-secondary-600 mb-4 text-sm line-clamp-3 leading-relaxed">{{ Str::limit($post->excerpt, 120) }}</p>

                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center text-secondary-500">
                            <div class="w-6 h-6 bg-secondary-200 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs font-medium">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <span class="font-medium">{{ $post->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-secondary-400">
                            <span>{{ $post->published_at->format('d M Y') }}</span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $post->views_count }}
                            </span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-secondary-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-secondary-900 mb-2">No hay artículos</h3>
            <p class="text-secondary-600 mb-8">No se encontraron artículos con los filtros seleccionados.</p>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Ver todos los artículos
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
