@extends('layouts.app')

@section('title', 'Comentarios - Gestión')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mr-4">
                            <i data-lucide="message-circle" class="w-6 h-6 text-white"></i>
                        </div>
                        Gestión de Comentarios
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Modera y gestiona comentarios del blog</p>
                </div>

                <!-- Filter buttons -->
                <div class="flex space-x-1 bg-secondary-100 rounded-xl p-1">
                    <a href="{{ route('comments.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('status') ? 'bg-white text-secondary-900 shadow-soft' : 'text-secondary-600 hover:text-secondary-900' }} transition-all duration-200">
                        Todos
                    </a>
                    <a href="{{ route('comments.index', ['status' => 'pending']) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'pending' ? 'bg-white text-secondary-900 shadow-soft' : 'text-secondary-600 hover:text-secondary-900' }} transition-all duration-200">
                        Pendientes
                    </a>
                    <a href="{{ route('comments.index', ['status' => 'approved']) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'approved' ? 'bg-white text-secondary-900 shadow-soft' : 'text-secondary-600 hover:text-secondary-900' }} transition-all duration-200">
                        Aprobados
                    </a>
                    <a href="{{ route('comments.index', ['status' => 'rejected']) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'rejected' ? 'bg-white text-secondary-900 shadow-soft' : 'text-secondary-600 hover:text-secondary-900' }} transition-all duration-200">
                        Rechazados
                    </a>
                </div>
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
                    <div class="text-2xl font-bold text-secondary-900">{{ $comments->total() }}</div>
                    <div class="text-sm text-secondary-600">Total</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ \App\Models\Comment::where('status', 'approved')->count() }}</div>
                    <div class="text-sm text-secondary-600">Aprobados</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ \App\Models\Comment::where('status', 'pending')->count() }}</div>
                    <div class="text-sm text-secondary-600">Pendientes</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ \App\Models\Comment::where('status', 'rejected')->count() }}</div>
                    <div class="text-sm text-secondary-600">Rechazados</div>
                </div>
            </div>
        </div>

        <!-- Comments List -->
        @if($comments->count() > 0)
        <div class="space-y-6">
            @foreach($comments as $comment)
            <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                <!-- Comment Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                            <span class="text-sm font-semibold text-white">
                                {{ strtoupper(substr($comment->author_name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="flex items-center space-x-2">
                                <p class="text-sm font-semibold text-secondary-900">
                                    {{ $comment->author_name }}
                                </p>
                                @if($comment->user)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700">
                                    Registrado
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-700">
                                    Invitado
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-4 text-xs text-secondary-500 mt-1">
                                <span>{{ $comment->created_at->format('d M Y, H:i') }}</span>
                                @if($comment->author_email)
                                <span>{{ $comment->author_email }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    @switch($comment->status)
                        @case('pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                            @break
                        @case('approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Aprobado
                            </span>
                            @break
                        @case('rejected')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                Rechazado
                            </span>
                            @break
                    @endswitch
                </div>

                <!-- Post Info -->
                <div class="mb-4">
                    <p class="text-sm text-secondary-600">
                        Comentario en:
                        <a href="{{ route('blog.show', $comment->post->slug) }}"
                           target="_blank"
                           class="text-primary-600 hover:text-primary-700 font-medium">
                            {{ $comment->post->title }}
                        </a>
                    </p>
                </div>

                <!-- Comment Content -->
                <div class="mb-4">
                    <div class="bg-secondary-50 rounded-xl p-4">
                        <p class="text-secondary-700 leading-relaxed">
                            {!! nl2br(e($comment->content)) !!}
                        </p>
                    </div>
                </div>

                <!-- Parent Comment (if reply) -->
                @if($comment->parent)
                <div class="mb-4">
                    <p class="text-xs text-secondary-500 mb-2">En respuesta a:</p>
                    <div class="bg-primary-50 rounded-xl p-3 border-l-4 border-primary-400">
                        <p class="text-sm text-secondary-700">
                            <strong class="text-primary-700">{{ $comment->parent->author_name }}:</strong>
                            {{ Str::limit($comment->parent->content, 100) }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-secondary-200">
                    <div class="flex gap-2">
                        @if($comment->status === 'pending')
                        <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Aprobar
                            </button>
                        </form>

                        <form action="{{ route('comments.reject', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Rechazar
                            </button>
                        </form>
                        @elseif($comment->status === 'approved')
                        <form action="{{ route('comments.reject', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                Rechazar
                            </button>
                        </form>
                        @elseif($comment->status === 'rejected')
                        <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                Aprobar
                            </button>
                        </form>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('blog.show', $comment->post->slug) }}#comment-{{ $comment->id }}"
                           target="_blank"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-primary-700 bg-primary-100 hover:bg-primary-200 transition-colors duration-200">
                            Ver en Post
                        </a>

                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                              class="inline"
                              onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 transition-colors duration-200">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $comments->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-12 text-center">
            <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-secondary-900 mb-2">No hay comentarios</h3>
            <p class="text-secondary-600">
                @if(request('status'))
                    No hay comentarios con el estado "{{ request('status') }}".
                @else
                    No se han recibido comentarios aún.
                @endif
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
