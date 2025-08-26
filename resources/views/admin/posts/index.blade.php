@extends('layouts.app')

@section('title', 'Moderación de Posts')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4">
                            <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                        </div>
                        Moderación de Posts
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Gestiona y modera el contenido del blog</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-secondary-700 font-semibold rounded-2xl transition-all duration-200">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl px-6 py-4 mb-8">
            <div class="flex items-start">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-500 mr-3 mt-0.5"></i>
                <div>
                    <h3 class="text-green-800 font-semibold mb-1">¡Éxito!</h3>
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Filters and Stats -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Status Filters -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('moderation.index') }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200 {{ !request('status') ? 'bg-blue-100 text-blue-700' : 'bg-secondary-100 text-secondary-600 hover:bg-secondary-200' }}">
                        Todos ({{ $statusCounts['all'] }})
                    </a>
                    <a href="{{ route('moderation.index', ['status' => 'pending']) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200 {{ request('status') === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-secondary-100 text-secondary-600 hover:bg-secondary-200' }}">
                        Pendientes ({{ $statusCounts['pending'] }})
                    </a>
                    <a href="{{ route('moderation.index', ['status' => 'published']) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200 {{ request('status') === 'published' ? 'bg-green-100 text-green-700' : 'bg-secondary-100 text-secondary-600 hover:bg-secondary-200' }}">
                        Publicados ({{ $statusCounts['published'] }})
                    </a>
                    <a href="{{ route('moderation.index', ['status' => 'draft']) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200 {{ request('status') === 'draft' ? 'bg-gray-100 text-gray-700' : 'bg-secondary-100 text-secondary-600 hover:bg-secondary-200' }}">
                        Borradores ({{ $statusCounts['draft'] }})
                    </a>
                    <a href="{{ route('moderation.index', ['status' => 'rejected']) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200 {{ request('status') === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-secondary-100 text-secondary-600 hover:bg-secondary-200' }}">
                        Rechazados ({{ $statusCounts['rejected'] }})
                    </a>
                </div>

                <!-- Search -->
                <form method="GET" class="flex gap-2">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="search" placeholder="Buscar posts..."
                               value="{{ request('search') }}"
                               class="pl-10 pr-4 py-2 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-5 w-5 text-secondary-400"></i>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors duration-200">
                        Buscar
                    </button>
                </form>
            </div>
        </div>

        <!-- Posts Table -->
        @if($posts->count() > 0)
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-600 uppercase tracking-wider">Post</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-600 uppercase tracking-wider">Autor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-600 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-600 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-secondary-600 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-200">
                        @foreach($posts as $post)
                        <tr class="hover:bg-secondary-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-4">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                             alt="{{ $post->title }}"
                                             class="w-16 h-16 object-cover rounded-lg border border-secondary-200">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-lg">{{ $post->postType->icon ?? '📄' }}</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-secondary-900 mb-1">{{ $post->title }}</h3>
                                        <p class="text-sm text-secondary-600 line-clamp-2">{{ $post->excerpt }}</p>
                                        <div class="flex items-center space-x-4 mt-2 text-xs text-secondary-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                {{ $post->category->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ $post->views_count }} vistas
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($post->user->profile_photo)
                                        <img src="{{ asset('storage/' . $post->user->profile_photo) }}"
                                             alt="{{ $post->user->name }}"
                                             class="w-8 h-8 rounded-full mr-3">
                                    @else
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-semibold">{{ substr($post->user->name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-secondary-900">{{ $post->user->name }}</div>
                                        <div class="text-xs text-secondary-500 capitalize">{{ $post->user->role }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Borrador'],
                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Pendiente'],
                                        'published' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Publicado'],
                                        'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Rechazado'],
                                    ];
                                    $config = $statusConfig[$post->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => ucfirst($post->status)];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                    {{ $config['label'] }}
                                </span>
                                @if($post->is_featured)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 ml-2">
                                    ⭐ Destacado
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-secondary-600">
                                {{ $post->created_at->format('d M Y') }}
                                <div class="text-xs text-secondary-500">{{ $post->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('posts.show', $post) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                        Ver
                                    </a>

                                    @if($post->status === 'pending')
                                    <form method="POST" action="{{ route('admin.posts.approve', $post) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="return confirm('¿Aprobar este post?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                            Aprobar
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.posts.reject', $post) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="return confirm('¿Rechazar este post?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                            Rechazar
                                        </button>
                                    </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Estás seguro de eliminar este post? Esta acción no se puede deshacer.')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-colors duration-200">
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

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-12 text-center">
            <div class="w-24 h-24 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-secondary-900 mb-2">No hay posts para mostrar</h3>
            <p class="text-secondary-600 mb-6">
                @if(request('search'))
                    No se encontraron posts que coincidan con "{{ request('search') }}"
                @elseif(request('status'))
                    No hay posts con estado "{{ request('status') }}"
                @else
                    Aún no hay posts en el sistema
                @endif
            </p>
            @if(request('search') || request('status'))
            <a href="{{ route('moderation.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-2xl transition-all duration-200">
                Ver todos los posts
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
