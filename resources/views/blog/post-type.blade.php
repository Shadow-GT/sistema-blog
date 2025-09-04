@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
@endphp

@section('title', $postType->name . ' - ' . $siteName)
@section('description', $postType->description)

@section('content')
<!-- Post Type Header -->
<div class="bg-gradient-to-r from-primary-700 to-primary-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <!-- Breadcrumb -->
            <nav class="flex justify-center mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('blog.index') }}" class="text-purple-100 hover:text-white">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-purple-100 md:ml-2">{{ $postType->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-4xl">
                    {{ $postType->icon ?? '📄' }}
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                {{ $postType->name }}
            </h1>

            @if($postType->description)
            <p class="text-xl text-purple-100 mb-6 max-w-3xl mx-auto">
                {{ $postType->description }}
            </p>
            @endif

            <div class="flex items-center justify-center space-x-6 text-purple-100">
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $posts->total() }}</div>
                    <div class="text-sm">{{ $postType->name }}s</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Posts Grid -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                     class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center">
                    <span class="text-white text-2xl">{{ $post->postType->icon ?? '📄' }}</span>
                </div>
                @endif

                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="inline-block px-2 py-1 text-xs font-semibold text-white rounded"
                              style="background-color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </span>
                        <span class="ml-2 text-sm text-gray-500">{{ $post->postType->name }}</span>
                        @if($post->is_featured)
                        <span class="ml-2 text-yellow-500">⭐</span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($post->excerpt, 120) }}</p>

                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center">
                            <span>Por {{ $post->user->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            <span>•</span>
                            <span>{{ $post->views_count }} vistas</span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-purple-100 flex items-center justify-center text-4xl">
                {{ $postType->icon ?? '📄' }}
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No hay {{ strtolower($postType->name) }}s disponibles</h3>
            <p class="text-gray-500 mb-6">Aún no se han publicado {{ strtolower($postType->name) }}s.</p>
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                Ver todos los artículos
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Other Post Types -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Otros Tipos de Contenido</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @php
                $otherPostTypes = \App\Models\PostType::active()
                    ->where('id', '!=', $postType->id)
                    ->withCount(['posts as published_posts_count' => function ($query) {
                        $query->where('status', 'published');
                    }])
                    ->get();
            @endphp

            @foreach($otherPostTypes as $otherPostType)
            <a href="{{ route('blog.post-type', $otherPostType->slug) }}"
               class="group block p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="text-center">
                    <div class="text-3xl mb-2">
                        {{ $otherPostType->icon ?? '📄' }}
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 group-hover:text-purple-600">
                        {{ $otherPostType->name }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $otherPostType->published_posts_count }} publicaciones
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
