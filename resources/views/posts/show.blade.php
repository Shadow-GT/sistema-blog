@extends('layouts.app')

@section('title', 'Ver Post - ' . $post->title)

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        Vista del Post
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Detalles completos del artículo</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-secondary-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a Mis Posts
                    </a>
                    @if(auth()->user()->canModerate() || $post->status !== 'published')
                    <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-6 py-3 bg-accent-100 hover:bg-accent-200 text-accent-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Post
                    </a>
                    @endif
                    @if($post->status === 'published')
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-100 hover:bg-green-200 text-green-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Ver en Blog
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Post Content -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
                    <div class="p-8">
                        <!-- Title and Meta -->
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-secondary-900 mb-4 leading-tight">{{ $post->title }}</h2>

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white"
                                      style="background-color: {{ $post->category->color }}">
                                    {{ $post->category->name }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-secondary-100 text-secondary-700">
                                    {{ $post->postType->icon }} {{ $post->postType->name }}
                                </span>

                                @switch($post->status)
                                    @case('draft')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                            📝 Borrador
                                        </span>
                                        @break
                                    @case('pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            ⏳ Pendiente
                                        </span>
                                        @break
                                    @case('published')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            ✅ Publicado
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            ❌ Rechazado
                                        </span>
                                        @break
                                @endswitch

                                @if($post->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                    ⭐ Destacado
                                </span>
                                @endif
                            </div>

                            <!-- Author and Date -->
                            <div class="flex items-center text-secondary-600 text-sm">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center mr-3">
                                    <span class="text-xs font-semibold text-white">{{ strtoupper(substr($post->user->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">{{ $post->user->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->created_at->format('d M Y, H:i') }}</span>
                                    @if($post->updated_at != $post->created_at)
                                    <span class="mx-2">•</span>
                                    <span>Actualizado {{ $post->updated_at->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        @if($post->excerpt)
                        <div class="bg-primary-50 rounded-xl p-6 mb-8 border-l-4 border-primary-400">
                            <h3 class="text-lg font-semibold text-primary-900 mb-2">Resumen</h3>
                            <p class="text-primary-800 leading-relaxed">{{ $post->excerpt }}</p>
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="prose prose-lg max-w-none">
                            <div class="text-secondary-700 leading-relaxed">
                                {!! $post->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Post Stats -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Estadísticas
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-secondary-600">Vistas</span>
                            <span class="font-semibold text-secondary-900">{{ number_format($post->views_count) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-secondary-600">Comentarios</span>
                            <span class="font-semibold text-secondary-900">{{ $post->comments()->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-secondary-600">Palabras</span>
                            <span class="font-semibold text-secondary-900">{{ str_word_count(strip_tags($post->content)) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-secondary-600">Tiempo de lectura</span>
                            <span class="font-semibold text-secondary-900">{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min</span>
                        </div>
                    </div>
                </div>

                <!-- Post Details -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Detalles
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-secondary-600 text-sm">URL del Post</span>
                            <div class="mt-1">
                                <code class="text-xs bg-secondary-100 px-2 py-1 rounded text-secondary-800 break-all">{{ $post->slug }}</code>
                            </div>
                        </div>
                        <div>
                            <span class="text-secondary-600 text-sm">ID del Post</span>
                            <div class="mt-1 font-mono text-sm text-secondary-900">#{{ $post->id }}</div>
                        </div>
                        <div>
                            <span class="text-secondary-600 text-sm">Creado</span>
                            <div class="mt-1 text-sm text-secondary-900">{{ $post->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        @if($post->updated_at != $post->created_at)
                        <div>
                            <span class="text-secondary-600 text-sm">Última actualización</span>
                            <div class="mt-1 text-sm text-secondary-900">{{ $post->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Acciones Rápidas
                    </h3>
                    <div class="space-y-3">
                        @if(auth()->user()->canModerate() || $post->status !== 'published')
                        <a href="{{ route('posts.edit', $post) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-accent-100 hover:bg-accent-200 text-accent-700 rounded-xl text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar Post
                        </a>
                        @else
                        <div class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-500 rounded-xl text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Post Publicado (Solo Admin)
                        </div>
                        @endif

                        @if($post->status === 'published')
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-xl text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Ver en Blog
                        </a>
                        @endif

                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl text-sm font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
