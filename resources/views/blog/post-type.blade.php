@extends('layouts.blog')

@php
    $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
@endphp

@section('title', $postType->name . ' - ' . $siteName)
@section('description', $postType->description)

@section('content')
    <!-- Post type header -->
    <div class="bg-gradient-to-r from-primary-700 to-accent-600 text-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <nav class="mb-4 flex justify-center" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center gap-2 text-sm text-primary-100">
                        <li><a href="{{ route('blog.index') }}" class="hover:text-white">Inicio</a></li>
                        <li class="flex items-center gap-2">
                            <x-lucide-chevron-right class="h-4 w-4 text-primary-200" />
                            <span>{{ $postType->name }}</span>
                        </li>
                    </ol>
                </nav>

                <div class="mb-4 flex items-center justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 text-4xl ring-4 ring-white/20">
                        {{ $postType->icon ?? '📄' }}
                    </div>
                </div>

                <h1 class="mb-4 text-4xl font-bold md:text-5xl">{{ $postType->name }}</h1>

                @if($postType->description)
                    <p class="mx-auto mb-6 max-w-3xl text-xl text-primary-100">{{ $postType->description }}</p>
                @endif

                <div class="text-primary-100">
                    <span class="text-2xl font-bold text-white">{{ $posts->total() }}</span> publicaciones
                </div>
            </div>
        </div>
    </div>

    <!-- Posts grid -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
                <div class="mt-12 flex justify-center">{{ $posts->links() }}</div>
            @else
                <x-empty-state icon="layout-grid" title="No hay {{ \Illuminate\Support\Str::lower($postType->name) }}s disponibles"
                    message="Aún no se han publicado {{ \Illuminate\Support\Str::lower($postType->name) }}s.">
                    <x-ui.button :href="route('blog.index')" icon="arrow-left">Ver todos los artículos</x-ui.button>
                </x-empty-state>
            @endif
        </div>
    </section>

    <!-- Other post types -->
    @php $otherPostTypes = $navPostTypes->where('id', '!=', $postType->id); @endphp
    @if($otherPostTypes->isNotEmpty())
        <section class="bg-secondary-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-center text-2xl font-bold text-secondary-900">Otros tipos de contenido</h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5">
                    @foreach($otherPostTypes as $other)
                        <a href="{{ route('blog.post-type', $other->slug) }}"
                           class="group block rounded-2xl bg-white p-6 text-center shadow-soft ring-1 ring-secondary-100 transition hover:-translate-y-1 hover:shadow-medium">
                            <div class="mb-2 text-3xl">{{ $other->icon ?? '📄' }}</div>
                            <h3 class="text-sm font-medium text-secondary-900 group-hover:text-primary-600">{{ $other->name }}</h3>
                            <p class="mt-1 text-xs text-secondary-500">{{ $other->published_posts_count }} publicaciones</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
