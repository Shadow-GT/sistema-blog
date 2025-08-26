@extends('layouts.app')

@section('title', 'Categorías - Gestión')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        Gestión de Categorías
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Organiza el contenido por categorías</p>
                </div>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Categoría
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
                    <div class="text-2xl font-bold text-secondary-900">{{ $categories->count() }}</div>
                    <div class="text-sm text-secondary-600">Total Categorías</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-primary-600">{{ $categories->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-secondary-600">Activas</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ \App\Models\Post::whereIn('category_id', $categories->pluck('id'))->count() }}</div>
                    <div class="text-sm text-secondary-600">Posts Totales</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-accent-600">{{ $categories->where('parent_id', null)->count() }}</div>
                    <div class="text-sm text-secondary-600">Principales</div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        @if($categories->count() > 0)
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Color</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Posts</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-secondary-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-100">
                        @foreach($categories as $category)
                        <tr class="hover:bg-secondary-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3" style="background-color: {{ $category->color }}20; border: 2px solid {{ $category->color }}">
                                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-secondary-900">{{ $category->name }}</div>
                                        @if($category->description)
                                        <div class="text-xs text-secondary-500 mt-1">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full mr-2" style="background-color: {{ $category->color }}"></div>
                                    <span class="text-sm text-secondary-600 font-mono">{{ $category->color }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-secondary-600">{{ $category->posts_count ?? 0 }}</td>
                            <td class="px-6 py-4">
                                @if($category->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activa
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactiva
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-secondary-600">{{ $category->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-primary-100 hover:bg-primary-200 text-primary-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                        Editar
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-12 text-center">
            <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-secondary-900 mb-2">No hay categorías</h3>
            <p class="text-secondary-600 mb-6">Crea tu primera categoría para organizar el contenido.</p>
            <a href="{{ route('categories.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Categoría
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
