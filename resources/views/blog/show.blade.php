@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
    $postImage = $post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/default-post-image.svg');
@endphp

@section('title', $post->title . ' - ' . $siteName)
@section('description', $post->excerpt)

{{-- Open Graph / Facebook --}}
@section('og_type', 'article')
@section('og_title', $post->title)
@section('og_description', $post->excerpt)
@section('og_image', $postImage)

{{-- Twitter Cards --}}
@section('twitter_title', $post->title)
@section('twitter_description', $post->excerpt)
@section('twitter_image', $postImage)

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-secondary-900 via-primary-900 to-accent-900">

    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-white/70 text-sm mb-8">
            <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">
                <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Inicio
            </a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-white transition-colors">
                {{ $post->category->name }}
            </a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-white/50">{{ Str::limit($post->title, 30) }}</span>
        </nav>

        <!-- Post Meta -->
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white bg-white/10 backdrop-blur-sm border border-white/20"
                  style="background-color: {{ $post->category->color }}40; border-color: {{ $post->category->color }}60;">
                {{ $post->category->name }}
            </span>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white/90 bg-white/10 backdrop-blur-sm border border-white/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                {{ $post->postType->name }}
            </span>
            @if($post->is_featured)
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-yellow-300 bg-yellow-500/20 backdrop-blur-sm border border-yellow-400/30">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Destacado
            </span>
            @endif
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-tight">
            {{ $post->title }}
        </h1>

        <!-- Excerpt -->
        @if($post->excerpt)
        <p class="text-xl md:text-2xl text-white/90 mb-12 leading-relaxed max-w-4xl">
            {{ $post->excerpt }}
        </p>
        @endif

        <!-- Author & Meta -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center shadow-large mr-4">
                    <span class="text-xl font-bold text-white">{{ strtoupper(substr($post->user->name, 0, 2)) }}</span>
                </div>
                <div>
                    <p class="text-lg font-semibold text-white">{{ $post->user->name }}</p>
                    <div class="flex items-center text-white/70 text-sm space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $post->views_count }} vistas
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            {{ $post->approvedComments->count() }} comentarios
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gradient-to-b from-white to-secondary-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Article Content -->
        <article class="mb-16">
            <div class="prose prose-xl prose-secondary max-w-none post-content bg-white rounded-3xl shadow-large border border-secondary-100 p-8 md:p-12 lg:p-16">
                {!! $post->content !!}
            </div>
        </article>

        <!-- Tags/Meta -->
        @if($post->meta_data && isset($post->meta_data['tags']))
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Etiquetas</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($post->meta_data['tags'] as $tag)
                <span class="inline-block px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">
                    {{ $tag }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share & Actions -->
        <div class="bg-white rounded-3xl shadow-large border border-secondary-100 p-8 mb-16">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-secondary-900 mb-3">¿Te gustó este artículo?</h3>
                <p class="text-lg text-secondary-600">Compártelo con tu comunidad y ayuda a otros a descubrir contenido valioso</p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}"
                   target="_blank" class="group inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl font-semibold transition-all duration-300 shadow-medium hover:shadow-large transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                   target="_blank" class="group inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-2xl font-semibold transition-all duration-300 shadow-medium hover:shadow-large transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>

                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                   target="_blank" class="group inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 text-white rounded-2xl font-semibold transition-all duration-300 shadow-medium hover:shadow-large transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </a>

                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}"
                   target="_blank" class="group inline-flex items-center px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl font-semibold transition-all duration-300 shadow-medium hover:shadow-large transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    WhatsApp
                </a>

                <button onclick="navigator.share ? navigator.share({title: '{{ $post->title }}', url: '{{ request()->url() }}'}) : navigator.clipboard.writeText('{{ request()->url() }}')"
                        class="group inline-flex items-center px-6 py-4 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white rounded-2xl font-semibold transition-all duration-300 shadow-medium hover:shadow-large transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                    </svg>
                    Compartir
                </button>
            </div>

            <!-- Article Stats -->
            <div class="border-t border-secondary-200 pt-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="group">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-secondary-900">{{ number_format($post->views_count) }}</div>
                        <div class="text-sm text-secondary-600">Vistas</div>
                    </div>

                    <div class="group">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-100 to-accent-200 rounded-2xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-secondary-900">{{ $post->approvedComments->count() }}</div>
                        <div class="text-sm text-secondary-600">Comentarios</div>
                    </div>

                    <div class="group">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-secondary-900">{{ $post->published_at ? $post->published_at->format('d') : $post->created_at->format('d') }}</div>
                        <div class="text-sm text-secondary-600">{{ $post->published_at ? $post->published_at->format('M Y') : $post->created_at->format('M Y') }}</div>
                    </div>

                    <div class="group">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-secondary-900">{{ ceil(str_word_count(strip_tags($post->content)) / 200) }}</div>
                        <div class="text-sm text-secondary-600">Min lectura</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-3xl font-bold text-secondary-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Comentarios
                    <span class="ml-3 px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-lg font-semibold">
                        {{ $post->approvedComments->count() }}
                    </span>
                </h3>
            </div>

            <!-- Comment Form -->
            <div class="bg-gradient-to-br from-white to-primary-50 rounded-3xl shadow-soft border border-primary-100 p-8 mb-12">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-secondary-900">Únete a la conversación</h4>
                        <p class="text-secondary-600">Comparte tu opinión y enriquece el debate</p>
                    </div>
                </div>

                <form action="{{ route('comments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    @guest
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="author_name" class="block text-sm font-semibold text-secondary-700 mb-2">Nombre *</label>
                            <input type="text" name="author_name" id="author_name" required
                                   class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-400 transition-all duration-200 bg-white/80 backdrop-blur-sm">
                        </div>
                        <div>
                            <label for="author_email" class="block text-sm font-semibold text-secondary-700 mb-2">Email *</label>
                            <input type="email" name="author_email" id="author_email" required
                                   class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-400 transition-all duration-200 bg-white/80 backdrop-blur-sm">
                        </div>
                    </div>
                    @endguest

                    <div>
                        <label for="content" class="block text-sm font-semibold text-secondary-700 mb-2">Tu comentario *</label>
                        <textarea name="content" id="content" rows="5" required
                                  class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-400 transition-all duration-200 bg-white/80 backdrop-blur-sm resize-none"
                                  placeholder="Escribe tu comentario aquí... Sé respetuoso y constructivo."></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-secondary-500">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tu comentario será revisado antes de publicarse
                        </p>
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Enviar Comentario
                        </button>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            @if($post->approvedComments->count() > 0)
            <div class="space-y-8">
                @foreach($post->approvedComments->where('parent_id', null) as $comment)
                <div class="bg-white rounded-3xl shadow-soft border border-secondary-100 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center shadow-medium">
                                    <span class="text-sm font-bold text-white">
                                        {{ strtoupper(substr($comment->author_name, 0, 2)) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-lg font-bold text-secondary-900">{{ $comment->author_name }}</p>
                                    <div class="flex items-center text-sm text-secondary-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $comment->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Verificado
                                </span>
                            </div>
                        </div>

                        <div class="prose prose-secondary max-w-none mb-6">
                            <p class="text-secondary-700 leading-relaxed text-lg">
                                {!! nl2br(e($comment->content)) !!}
                            </p>
                        </div>

                        <!-- Replies -->
                        @if($comment->approvedReplies->count() > 0)
                        <div class="border-l-4 border-primary-200 ml-6 pl-8 mt-8 space-y-6">
                            <div class="flex items-center text-sm font-semibold text-secondary-600 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                                {{ $comment->approvedReplies->count() }} respuesta{{ $comment->approvedReplies->count() > 1 ? 's' : '' }}
                            </div>
                            @foreach($comment->approvedReplies as $reply)
                            <div class="bg-gradient-to-br from-secondary-50 to-primary-50 rounded-2xl p-6 border border-secondary-100">
                                <div class="flex items-center mb-4">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-500 flex items-center justify-center shadow-soft">
                                        <span class="text-xs font-bold text-white">
                                            {{ strtoupper(substr($reply->author_name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-base font-bold text-secondary-900">{{ $reply->author_name }}</p>
                                        <div class="flex items-center text-xs text-secondary-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $reply->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-secondary-700 leading-relaxed">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-secondary-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-secondary-900 mb-2">¡Sé el primero en comentar!</h4>
                <p class="text-secondary-600 mb-6">Inicia la conversación y comparte tu perspectiva sobre este artículo</p>
                <button onclick="document.getElementById('content').focus()" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Escribir comentario
                </button>
            </div>
            @endif
        </section>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="py-20 bg-gradient-to-br from-secondary-50 to-primary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-accent-50 text-accent-700 text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                Relacionados
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-secondary-900 mb-4">Continúa Leyendo</h2>
            <p class="text-xl text-secondary-600 max-w-2xl mx-auto">Descubre más contenido que podría interesarte</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedPosts as $relatedPost)
            <article class="group bg-white rounded-3xl shadow-soft hover:shadow-large transition-all duration-500 overflow-hidden border border-secondary-100 hover:border-primary-200 hover:-translate-y-2">
                <div class="relative overflow-hidden">
                    @if($relatedPost->featured_image)
                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}"
                         class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-40 bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center">
                        <span class="text-white text-2xl">{{ $relatedPost->postType->icon ?? '📄' }}</span>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold text-white"
                              style="background-color: {{ $relatedPost->category->color }}">
                            {{ $relatedPost->category->name }}
                        </span>
                        @if($relatedPost->is_featured)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold text-yellow-800 bg-yellow-100">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            ★
                        </span>
                        @endif
                    </div>

                    <h3 class="text-base font-bold text-secondary-900 mb-3 group-hover:text-primary-600 transition-colors duration-300 line-clamp-2 leading-tight">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}">
                            {{ Str::limit($relatedPost->title, 60) }}
                        </a>
                    </h3>

                    <div class="flex items-center justify-between text-xs text-secondary-500">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $relatedPost->published_at ? $relatedPost->published_at->format('d M Y') : $relatedPost->created_at->format('d M Y') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $relatedPost->views_count }}
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-8 py-4 bg-white hover:bg-secondary-50 text-secondary-900 font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large border border-secondary-200 hover:border-primary-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4" />
                </svg>
                Ver todos los artículos
            </a>
        </div>
    </div>
</section>
@endif
@endsection
