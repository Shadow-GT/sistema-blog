@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
    $postImage = $post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/default-post-image.svg');
    $readingMinutes = max(1, ceil(str_word_count(strip_tags($post->content)) / 200));
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

{{-- Canonical desde ruta con nombre (nunca desde input reflejado) --}}
@section('canonical', route('blog.show', $post->slug))

@push('head')
    <meta property="article:published_time" content="{{ optional($post->published_at)->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
    <meta property="article:author" content="{{ $post->user->name }}">
    <meta property="article:section" content="{{ $post->category->name }}">

    <x-seo.json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->excerpt,
        'image' => [$postImage],
        'datePublished' => optional($post->published_at)->toIso8601String(),
        'dateModified' => $post->updated_at->toIso8601String(),
        'author' => ['@type' => 'Person', 'name' => $post->user->name],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $siteName,
            'logo' => ['@type' => 'ImageObject', 'url' => \App\Models\BlogSetting::get('site_logo') ? asset('storage/' . \App\Models\BlogSetting::get('site_logo')) : asset('images/default-og-image.svg')],
        ],
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => route('blog.show', $post->slug)],
        'articleSection' => $post->category->name,
        'url' => route('blog.show', $post->slug),
    ]" />

    <x-seo.json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $post->category->name, 'item' => route('blog.category', $post->category->slug)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => route('blog.show', $post->slug)],
        ],
    ]" />
@endpush

@section('content')
    <!-- Hero -->
    <div class="relative overflow-hidden bg-gradient-to-br from-secondary-900 via-primary-900 to-accent-900">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.03%22%3E%3Ccircle cx=%2230%22 cy=%2230%22 r=%224%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>

        <div class="relative mx-auto max-w-5xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <!-- Breadcrumb -->
            <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-white/70">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 transition-colors hover:text-white">
                    <x-lucide-house class="h-4 w-4" /> Inicio
                </a>
                <x-lucide-chevron-right class="h-4 w-4 text-white/40" />
                <a href="{{ route('blog.category', $post->category->slug) }}" class="transition-colors hover:text-white">{{ $post->category->name }}</a>
                <x-lucide-chevron-right class="h-4 w-4 text-white/40" />
                <span class="text-white/50">{{ Str::limit($post->title, 30) }}</span>
            </nav>

            <!-- Meta badges -->
            <div class="mb-8 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center rounded-full border px-4 py-1.5 text-sm font-semibold text-white backdrop-blur-sm"
                      style="background-color: {{ $post->category->color }}40; border-color: {{ $post->category->color }}60;">
                    {{ $post->category->name }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm font-medium text-white/90 backdrop-blur-sm">
                    <span>{{ $post->postType->icon }}</span>{{ $post->postType->name }}
                </span>
                @if($post->is_featured)
                    <span class="inline-flex items-center gap-2 rounded-full border border-warning-400/30 bg-warning-500/20 px-4 py-1.5 text-sm font-semibold text-warning-200 backdrop-blur-sm">
                        <x-lucide-star class="h-4 w-4 fill-current" /> Destacado
                    </span>
                @endif
            </div>

            <h1 class="mb-8 text-4xl font-bold leading-tight text-white md:text-6xl lg:text-7xl">{{ $post->title }}</h1>

            @if($post->excerpt)
                <p class="mb-12 max-w-4xl text-xl leading-relaxed text-white/90 md:text-2xl">{{ $post->excerpt }}</p>
            @endif

            <!-- Author meta -->
            <div class="flex items-center gap-4">
                <x-avatar :name="$post->user->name" size="lg" class="shadow-large" />
                <div>
                    <p class="text-lg font-semibold text-white">{{ $post->user->name }}</p>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-white/70">
                        <span class="inline-flex items-center gap-1">
                            <x-lucide-calendar class="h-4 w-4" />
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </span>
                        <span class="inline-flex items-center gap-1"><x-lucide-eye class="h-4 w-4" />{{ $post->views_count }} vistas</span>
                        <span class="inline-flex items-center gap-1"><x-lucide-message-square class="h-4 w-4" />{{ $post->approvedComments->count() }} comentarios</span>
                        <span class="inline-flex items-center gap-1"><x-lucide-clock class="h-4 w-4" />{{ $readingMinutes }} min</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="bg-gradient-to-b from-white to-secondary-50 py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <article class="mb-16">
                <div class="prose prose-xl prose-secondary post-content max-w-none rounded-3xl border border-secondary-100 bg-white p-8 shadow-large md:p-12 lg:p-16">
                    {!! $post->content !!}
                </div>
            </article>

            <!-- Tags -->
            @if($post->meta_data && isset($post->meta_data['tags']))
                <div class="mb-8">
                    <h3 class="mb-3 text-lg font-semibold text-secondary-900">Etiquetas</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->meta_data['tags'] as $tag)
                            <x-ui.badge color="secondary">{{ $tag }}</x-ui.badge>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Share & stats -->
            <div class="mb-16 rounded-3xl border border-secondary-100 bg-white p-8 shadow-large">
                <div class="mb-8 text-center">
                    <h3 class="mb-2 text-2xl font-bold text-secondary-900">¿Te gustó este artículo?</h3>
                    <p class="text-secondary-600">Compártelo con tu comunidad y ayuda a otros a descubrir contenido valioso</p>
                </div>

                <div class="mb-8 flex flex-wrap justify-center gap-3">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#1d9bf0] px-5 py-2.5 font-medium text-white transition hover:opacity-90">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#1877f2] px-5 py-2.5 font-medium text-white transition hover:opacity-90">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#0a66c2] px-5 py-2.5 font-medium text-white transition hover:opacity-90">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        LinkedIn
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#25d366] px-5 py-2.5 font-medium text-white transition hover:opacity-90">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
                        WhatsApp
                    </a>
                    <button onclick="navigator.share ? navigator.share({title: @js($post->title), url: @js(request()->url())}) : navigator.clipboard.writeText(@js(request()->url()))"
                            class="inline-flex items-center gap-2 rounded-xl bg-secondary-700 px-5 py-2.5 font-medium text-white transition hover:bg-secondary-800">
                        <x-lucide-share-2 class="h-5 w-5" /> Compartir
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-6 border-t border-secondary-100 pt-6 text-center md:grid-cols-4">
                    @php
                        $articleStats = [
                            ['icon' => 'eye', 'tint' => 'bg-primary-50 text-primary-600', 'value' => number_format($post->views_count), 'label' => 'Vistas'],
                            ['icon' => 'message-square', 'tint' => 'bg-accent-50 text-accent-600', 'value' => $post->approvedComments->count(), 'label' => 'Comentarios'],
                            ['icon' => 'calendar', 'tint' => 'bg-success-50 text-success-600', 'value' => $post->published_at ? $post->published_at->format('d') : $post->created_at->format('d'), 'label' => $post->published_at ? $post->published_at->format('M Y') : $post->created_at->format('M Y')],
                            ['icon' => 'clock', 'tint' => 'bg-warning-50 text-warning-600', 'value' => $readingMinutes, 'label' => 'Min lectura'],
                        ];
                    @endphp
                    @foreach($articleStats as $s)
                        <div class="group">
                            <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-2xl {{ $s['tint'] }} transition-transform duration-200 group-hover:scale-110">
                                <x-dynamic-component :component="'lucide-' . $s['icon']" class="h-6 w-6" />
                            </div>
                            <div class="text-2xl font-bold text-secondary-900">{{ $s['value'] }}</div>
                            <div class="text-sm text-secondary-600">{{ $s['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Comments -->
            <section class="mb-16">
                <div class="mb-8 flex items-center gap-3">
                    <h3 class="flex items-center gap-3 text-3xl font-bold text-secondary-900">
                        <x-lucide-message-square class="h-8 w-8 text-primary-600" /> Comentarios
                    </h3>
                    <x-ui.badge color="primary" class="!text-base">{{ $post->approvedComments->count() }}</x-ui.badge>
                </div>

                <!-- Comment form -->
                <div class="mb-12 rounded-3xl border border-primary-100 bg-gradient-to-br from-white to-primary-50 p-8 shadow-soft">
                    <div class="mb-6 flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-accent-500 text-white">
                            <x-lucide-square-pen class="h-6 w-6" />
                        </span>
                        <div>
                            <h4 class="text-xl font-bold text-secondary-900">Únete a la conversación</h4>
                            <p class="text-secondary-600">Comparte tu opinión y enriquece el debate</p>
                        </div>
                    </div>

                    <form action="{{ route('comments.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        @guest
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="author_name" class="mb-2 block text-sm font-semibold text-secondary-700">Nombre *</label>
                                    <input type="text" name="author_name" id="author_name" required value="{{ old('author_name') }}"
                                           class="w-full rounded-xl border border-secondary-200 bg-white/80 px-4 py-3 transition focus:border-primary-400 focus:ring-4 focus:ring-primary-100">
                                </div>
                                <div>
                                    <label for="author_email" class="mb-2 block text-sm font-semibold text-secondary-700">Email *</label>
                                    <input type="email" name="author_email" id="author_email" required value="{{ old('author_email') }}"
                                           class="w-full rounded-xl border border-secondary-200 bg-white/80 px-4 py-3 transition focus:border-primary-400 focus:ring-4 focus:ring-primary-100">
                                </div>
                            </div>
                        @endguest

                        <div>
                            <label for="content" class="mb-2 block text-sm font-semibold text-secondary-700">Tu comentario *</label>
                            <textarea name="content" id="content" rows="5" required
                                      class="w-full resize-none rounded-xl border border-secondary-200 bg-white/80 px-4 py-3 transition focus:border-primary-400 focus:ring-4 focus:ring-primary-100"
                                      placeholder="Escribe tu comentario aquí... Sé respetuoso y constructivo.">{{ old('content') }}</textarea>
                            @error('content')<p class="mt-2 text-sm text-danger-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <p class="inline-flex items-center gap-1 text-sm text-secondary-500">
                                <x-lucide-info class="h-4 w-4" /> Tu comentario será revisado antes de publicarse
                            </p>
                            <x-ui.button type="submit" icon="send">Enviar Comentario</x-ui.button>
                        </div>
                    </form>
                </div>

                <!-- Comments list -->
                @if($post->approvedComments->where('parent_id', null)->count() > 0)
                    <div class="space-y-8">
                        @foreach($post->approvedComments->where('parent_id', null) as $comment)
                            <div class="rounded-3xl border border-secondary-100 bg-white p-8 shadow-soft">
                                <div class="mb-6 flex items-start justify-between">
                                    <div class="flex items-center gap-4">
                                        <x-avatar :name="$comment->author_name" size="md" />
                                        <div>
                                            <p class="text-lg font-bold text-secondary-900">{{ $comment->author_name }}</p>
                                            <div class="inline-flex items-center gap-1 text-sm text-secondary-500">
                                                <x-lucide-clock class="h-4 w-4" />{{ $comment->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <x-ui.badge color="success"><x-lucide-check class="h-3 w-3" /> Verificado</x-ui.badge>
                                </div>

                                <p class="text-lg leading-relaxed text-secondary-700">{!! nl2br(e($comment->content)) !!}</p>

                                @if($comment->approvedReplies->count() > 0)
                                    <div class="ml-6 mt-8 space-y-6 border-l-4 border-primary-200 pl-8">
                                        <div class="inline-flex items-center gap-2 text-sm font-semibold text-secondary-600">
                                            <x-lucide-corner-down-right class="h-4 w-4" />
                                            {{ $comment->approvedReplies->count() }} respuesta{{ $comment->approvedReplies->count() > 1 ? 's' : '' }}
                                        </div>
                                        @foreach($comment->approvedReplies as $reply)
                                            <div class="rounded-2xl border border-secondary-100 bg-gradient-to-br from-secondary-50 to-primary-50 p-6">
                                                <div class="mb-4 flex items-center gap-3">
                                                    <x-avatar :name="$reply->author_name" size="sm" />
                                                    <div>
                                                        <p class="font-bold text-secondary-900">{{ $reply->author_name }}</p>
                                                        <div class="inline-flex items-center gap-1 text-xs text-secondary-500">
                                                            <x-lucide-clock class="h-3 w-3" />{{ $reply->created_at->format('d M Y, H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="leading-relaxed text-secondary-700">{!! nl2br(e($reply->content)) !!}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state icon="message-square" title="¡Sé el primero en comentar!"
                        message="Inicia la conversación y comparte tu perspectiva sobre este artículo.">
                        <x-ui.button icon="square-pen" onclick="document.getElementById('content').focus()">Escribir comentario</x-ui.button>
                    </x-empty-state>
                @endif
            </section>
        </div>
    </div>

    <!-- Related -->
    @if($relatedPosts->count() > 0)
        <section class="bg-gradient-to-br from-secondary-50 to-primary-50 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-accent-50 px-4 py-2 text-sm font-medium text-accent-700">
                        <x-lucide-link class="h-4 w-4" /> Relacionados
                    </div>
                    <h2 class="mb-4 text-4xl font-bold text-secondary-900 md:text-5xl">Continúa Leyendo</h2>
                    <p class="mx-auto max-w-2xl text-xl text-secondary-600">Descubre más contenido que podría interesarte</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedPosts as $relatedPost)
                        <x-post-card :post="$relatedPost" />
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <x-ui.button :href="route('blog.index')" variant="secondary" size="lg" icon="arrow-right">Ver todos los artículos</x-ui.button>
                </div>
            </div>
        </section>
    @endif
@endsection
