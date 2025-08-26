@extends('layouts.app')

@section('title', 'Tipos de Post - Gestión')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4M1 12h4m14 0H9m10 0H5" />
                            </svg>
                        </div>
                        Tipos de Post
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Define diferentes tipos de contenido</p>
                </div>
                <a href="{{ route('post-types.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 text-white font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Tipo
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl px-6 py-4 mb-8 flex items-center">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-green-700 font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Stats -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6 mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-2xl font-bold text-secondary-900">{{ $postTypes->count() }}</div>
                    <div class="text-sm text-secondary-600">Total Tipos</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-accent-600">{{ $postTypes->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-secondary-600">Activos</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ \App\Models\Post::whereIn('post_type_id', $postTypes->pluck('id'))->count() }}</div>
                    <div class="text-sm text-secondary-600">Posts Totales</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-primary-600">{{ $postTypes->where('is_default', true)->count() }}</div>
                    <div class="text-sm text-secondary-600">Por Defecto</div>
                </div>
            </div>
        </div>

        <!-- Post Types Grid -->
        @if($postTypes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($postTypes as $postType)
            <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6 hover:shadow-medium transition-all duration-200">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-100 to-accent-200 rounded-xl flex items-center justify-center mr-3">
                            <span class="text-2xl">{{ $postType->icon ?? '📄' }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-secondary-900">{{ $postType->name }}</h3>
                            @if($postType->is_default)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700 mt-1">
                                Por defecto
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status -->
                    @if($postType->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Activo
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Inactivo
                    </span>
                    @endif
                </div>

                <!-- Description -->
                @if($postType->description)
                <p class="text-secondary-600 text-sm mb-4 line-clamp-2">{{ $postType->description }}</p>
                @endif

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center">
                        <div class="text-lg font-bold text-secondary-900">{{ $postType->posts_count ?? 0 }}</div>
                        <div class="text-xs text-secondary-500">Posts</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold text-secondary-900">{{ $postType->created_at->format('M Y') }}</div>
                        <div class="text-xs text-secondary-500">Creado</div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('post-types.edit', $postType) }}" 
                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-accent-100 hover:bg-accent-200 text-accent-700 rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar
                    </a>
                    
                    @if(!$postType->is_default)
                    <form action="{{ route('post-types.destroy', $postType) }}" method="POST" 
                          class="inline" 
                          onsubmit="return confirm('¿Estás seguro?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-12 text-center">
            <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4M1 12h4m14 0H9m10 0H5" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-secondary-900 mb-2">No hay tipos de post</h3>
            <p class="text-secondary-600 mb-6">Crea diferentes tipos para organizar tu contenido.</p>
            <a href="{{ route('post-types.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-accent-600 hover:bg-accent-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Tipo
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
