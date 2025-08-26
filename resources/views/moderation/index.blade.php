@extends('layouts.app')

@section('title', 'Moderación - Panel de Control')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                Panel de Moderación
            </h1>
            <p class="text-xl text-secondary-600 mt-2">Revisa y modera contenido pendiente</p>
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
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_posts'] }}</div>
                    <div class="text-sm text-secondary-600">Posts Pendientes</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['pending_comments'] }}</div>
                    <div class="text-sm text-secondary-600">Comentarios Pendientes</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['published_posts'] }}</div>
                    <div class="text-sm text-secondary-600">Posts Aprobados</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ \App\Models\Post::where('status', 'rejected')->count() }}</div>
                    <div class="text-sm text-secondary-600">Posts Rechazados</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pending Posts -->
            <div class="bg-white rounded-2xl shadow-soft border border-secondary-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-secondary-900">Posts Pendientes</h3>
                        @if($pendingPosts->count() > 0)
                        <a href="{{ route('moderation.posts') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Ver todos ({{ $stats['pending_posts'] }})
                        </a>
                        @endif
                    </div>

                    @if($pendingPosts->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingPosts as $post)
                        <div class="border border-secondary-200 rounded-xl p-4 hover:bg-secondary-50 transition-colors duration-200">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="text-sm font-semibold text-secondary-900 line-clamp-2">
                                    {{ Str::limit($post->title, 60) }}
                                </h4>
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-white rounded-full ml-2"
                                      style="background-color: {{ $post->category->color }}">
                                    {{ $post->category->name }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-xs text-secondary-500 mb-4">
                                <span>Por {{ $post->user->name }}</span>
                                <span>{{ $post->created_at->format('d M Y') }}</span>
                            </div>

                            <div class="flex gap-2">
                                <form action="{{ route('moderation.posts.approve', $post) }}" method="POST" class="inline">
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

                                <form action="{{ route('moderation.posts.reject', $post) }}" method="POST" class="inline">
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

                                <a href="{{ route('posts.show', $post) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg text-secondary-700 bg-secondary-100 hover:bg-secondary-200 transition-colors duration-200">
                                    Ver
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-secondary-900 mb-2">No hay posts pendientes</h3>
                        <p class="text-secondary-600">Todos los posts han sido revisados.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pending Comments -->
            <div class="bg-white rounded-2xl shadow-soft border border-secondary-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-secondary-900">Comentarios Pendientes</h3>
                        @if($pendingComments->count() > 0)
                        <a href="{{ route('comments.index', ['status' => 'pending']) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Ver todos ({{ $stats['pending_comments'] }})
                        </a>
                        @endif
                    </div>

                    @if($pendingComments->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingComments as $comment)
                        <div class="border border-secondary-200 rounded-xl p-4 hover:bg-secondary-50 transition-colors duration-200">
                            <div class="flex items-center mb-3">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-white">
                                        {{ strtoupper(substr($comment->author_name, 0, 2)) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-secondary-900">
                                        {{ $comment->author_name }}
                                    </p>
                                    <p class="text-xs text-secondary-500">
                                        {{ $comment->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-sm text-secondary-700 mb-3 bg-secondary-50 rounded-lg p-3">
                                {{ Str::limit($comment->content, 100) }}
                            </p>

                            <p class="text-xs text-secondary-500 mb-4">
                                En: <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank" class="text-primary-600 hover:text-primary-700 font-medium">
                                    {{ Str::limit($comment->post->title, 40) }}
                                </a>
                            </p>

                            <div class="flex gap-2">
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
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-secondary-900 mb-2">No hay comentarios pendientes</h3>
                        <p class="text-secondary-600">Todos los comentarios han sido revisados.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
