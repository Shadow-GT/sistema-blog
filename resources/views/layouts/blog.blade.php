<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\BlogSetting::get('site_name', config('app.name')))</title>
    <meta name="description" content="@yield('description', 'Blog de ' . \App\Models\BlogSetting::get('site_name', config('app.name')) . '. Contenido de calidad sobre diversos temas.')">

    <!-- Canonical + indexación -->
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', \App\Models\BlogSetting::get('site_name', config('app.name')))">
    <meta property="og:description" content="@yield('og_description', 'Blog de ' . \App\Models\BlogSetting::get('site_name', config('app.name')) . '. Contenido de calidad sobre diversos temas.')">
    <meta property="og:image" content="@yield('og_image', asset('images/default-og-image.svg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ \App\Models\BlogSetting::get('site_name', config('app.name')) }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('twitter_title', \App\Models\BlogSetting::get('site_name', config('app.name')))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Blog de ' . \App\Models\BlogSetting::get('site_name', config('app.name')) . '. Contenido de calidad sobre diversos temas.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/default-og-image.svg'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/post-content.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .nav-scroll::-webkit-scrollbar { width: 4px; }
        .nav-scroll::-webkit-scrollbar-track { background: #f8fafc; }
        .nav-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    </style>

    {{-- Datos estructurados globales (Schema.org) --}}
    @php
        $seoSiteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
        $seoLogo = \App\Models\BlogSetting::get('site_logo')
            ? asset('storage/' . \App\Models\BlogSetting::get('site_logo'))
            : asset('images/default-og-image.svg');
    @endphp
    <x-seo.json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $seoSiteName,
        'url' => url('/'),
        'logo' => $seoLogo,
    ]" />
    <x-seo.json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $seoSiteName,
        'url' => url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => url('/') . '?search={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ]" />

    @stack('head')
</head>
<body class="min-h-screen bg-gradient-to-br from-secondary-50 to-primary-50 font-sans text-secondary-800 antialiased">
    @php
        $siteLogo = \App\Models\BlogSetting::get('site_logo');
        $navbarText = \App\Models\BlogSetting::get('navbar_text', config('app.name'));
    @endphp

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 border-b border-secondary-200/50 bg-white/80 shadow-soft backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 justify-between">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('blog.index') }}" class="group flex items-center">
                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $navbarText }}"
                                 class="mr-3 h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                        @else
                            <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 transition-transform duration-200 group-hover:scale-105">
                                <span class="text-sm font-bold text-white">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($navbarText, 0, 2)) }}</span>
                            </div>
                        @endif
                        <span class="truncate bg-gradient-to-r from-secondary-900 to-primary-700 bg-clip-text text-lg font-bold text-transparent md:text-2xl">{{ $navbarText }}</span>
                    </a>

                    <!-- Desktop nav links -->
                    <div class="hidden sm:ml-12 sm:flex sm:space-x-1">
                        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-secondary-700 transition-all duration-200 hover:bg-primary-50 hover:text-primary-600">
                            <x-lucide-house class="h-4 w-4" /> Inicio
                        </a>

                        <!-- Categories dropdown -->
                        <div class="relative inline-flex items-center" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-secondary-700 transition-all duration-200 hover:bg-primary-50 hover:text-primary-600">
                                <x-lucide-tag class="h-4 w-4" /> Categorías
                                <x-lucide-chevron-down class="h-4 w-4 transition-transform duration-200" ::class="{ 'rotate-180': open }" />
                            </button>
                            <div x-show="open" x-cloak @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 top-full z-50 mt-3 w-72 rounded-2xl bg-white/95 shadow-large ring-1 ring-secondary-200/50 backdrop-blur-md">
                                <div class="p-3">
                                    @foreach($navCategories as $category)
                                        <a href="{{ route('blog.category', $category->slug) }}"
                                           class="group flex items-center rounded-xl px-4 py-3 text-sm text-secondary-700 transition-all duration-200 hover:bg-primary-50 hover:text-primary-700">
                                            <span class="mr-3 h-4 w-4 rounded-full transition-transform duration-200 group-hover:scale-110" style="background-color: {{ $category->color }}"></span>
                                            <span class="flex-1">
                                                <span class="block font-semibold">{{ $category->name }}</span>
                                                <span class="block text-xs text-secondary-500">{{ $category->published_posts_count }} artículos</span>
                                            </span>
                                            <x-lucide-chevron-right class="h-4 w-4 text-secondary-400 opacity-0 transition-all duration-200 group-hover:text-primary-500 group-hover:opacity-100" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Post types dropdown -->
                        <div class="relative inline-flex items-center" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-secondary-700 transition-all duration-200 hover:bg-primary-50 hover:text-primary-600">
                                <x-lucide-layout-grid class="h-4 w-4" /> Tipos
                                <x-lucide-chevron-down class="h-4 w-4 transition-transform duration-200" ::class="{ 'rotate-180': open }" />
                            </button>
                            <div x-show="open" x-cloak @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 top-full z-50 mt-3 w-72 rounded-2xl bg-white/95 shadow-large ring-1 ring-secondary-200/50 backdrop-blur-md">
                                <div class="p-3">
                                    @foreach($navPostTypes as $postType)
                                        <a href="{{ route('blog.post-type', $postType->slug) }}"
                                           class="group flex items-center rounded-xl px-4 py-3 text-sm text-secondary-700 transition-all duration-200 hover:bg-primary-50 hover:text-primary-700">
                                            <span class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-accent-100 to-accent-200 transition-transform duration-200 group-hover:scale-110">
                                                <span class="text-lg">{{ $postType->icon ?? '📄' }}</span>
                                            </span>
                                            <span class="flex-1">
                                                <span class="block font-semibold">{{ $postType->name }}</span>
                                                <span class="block text-xs text-secondary-500">{{ $postType->published_posts_count }} publicaciones</span>
                                            </span>
                                            <x-lucide-chevron-right class="h-4 w-4 text-secondary-400 opacity-0 transition-all duration-200 group-hover:text-primary-500 group-hover:opacity-100" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <form action="{{ route('blog.index') }}" method="GET" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                                   class="w-64 rounded-xl border border-secondary-200 py-2 pl-10 pr-4 text-sm placeholder-secondary-400 focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                            <x-lucide-search class="pointer-events-none absolute inset-y-0 left-3 my-auto h-5 w-5 text-secondary-400" />
                        </div>
                    </form>

                    <!-- Auth -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-secondary-600 transition hover:text-secondary-900">
                                <x-avatar :name="auth()->user()->name" size="sm" />
                                <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                                <x-lucide-chevron-down class="h-4 w-4 transition-transform duration-200" ::class="{ 'rotate-180': open }" />
                            </button>
                            <div x-show="open" x-cloak @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 top-full z-50 mt-2 w-60 rounded-2xl bg-white shadow-large ring-1 ring-secondary-200/50">
                                <div class="border-b border-secondary-100 p-4">
                                    <div class="flex items-center gap-3">
                                        <x-avatar :name="auth()->user()->name" size="md" />
                                        <div class="min-w-0">
                                            <div class="truncate font-medium text-secondary-900">{{ auth()->user()->name }}</div>
                                            <div class="truncate text-xs text-secondary-500">{{ auth()->user()->email }}</div>
                                            <div class="text-xs font-medium capitalize text-primary-600">{{ auth()->user()->role }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                        <x-lucide-layout-dashboard class="h-4 w-4 text-secondary-400" /> Dashboard
                                    </a>
                                    @if(auth()->user()->canPublish())
                                        <a href="{{ route('posts.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                            <x-lucide-file-text class="h-4 w-4 text-secondary-400" /> Mis Posts
                                        </a>
                                        <a href="{{ route('posts.create') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                            <x-lucide-square-pen class="h-4 w-4 text-secondary-400" /> Crear Post
                                        </a>
                                    @endif
                                    @if(auth()->user()->canModerate())
                                        <a href="{{ route('moderation.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                            <x-lucide-shield-check class="h-4 w-4 text-secondary-400" /> Moderación
                                        </a>
                                        <a href="{{ route('comments.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                            <x-lucide-message-square class="h-4 w-4 text-secondary-400" /> Comentarios
                                        </a>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                            <x-lucide-users class="h-4 w-4 text-secondary-400" /> Usuarios
                                        </a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-secondary-700 transition hover:bg-primary-50 hover:text-primary-700">
                                        <x-lucide-user class="h-4 w-4 text-secondary-400" /> Mi Perfil
                                    </a>
                                </div>
                                <div class="border-t border-secondary-100 p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm text-danger-600 transition hover:bg-danger-50">
                                            <x-lucide-log-out class="h-4 w-4" /> Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="hidden sm:flex sm:items-center sm:space-x-3">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-secondary-600 hover:text-secondary-900">Iniciar Sesión</a>
                            <x-ui.button :href="route('register')" size="sm" icon="user-plus">Registrarse</x-ui.button>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden" x-data="{ mobileOpen: false }">
                        <button @click="mobileOpen = !mobileOpen" class="inline-flex items-center justify-center rounded-lg p-2 text-secondary-500 hover:bg-secondary-100 hover:text-secondary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/40">
                            <x-lucide-menu class="h-6 w-6" x-show="!mobileOpen" />
                            <x-lucide-x class="h-6 w-6" x-show="mobileOpen" x-cloak />
                        </button>

                        <!-- Mobile menu panel -->
                        <div x-show="mobileOpen" x-cloak @click.away="mobileOpen = false"
                             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                             class="nav-scroll fixed left-0 right-0 top-20 z-50 max-h-[calc(100vh-5rem)] overflow-y-auto border-t border-secondary-200 bg-white/95 shadow-xl backdrop-blur-md">
                            <div class="space-y-1 px-4 py-3">
                                <a href="{{ route('blog.index') }}" @click="mobileOpen = false" class="flex items-center gap-2.5 rounded-lg px-4 py-2.5 text-sm font-medium text-secondary-700 transition hover:bg-primary-50 hover:text-primary-600">
                                    <x-lucide-house class="h-4 w-4 text-secondary-400" /> Inicio
                                </a>

                                <!-- Mobile categories -->
                                <div class="border-t border-secondary-100 pt-2" x-data="{ catsOpen: false }">
                                    <button @click="catsOpen = !catsOpen" class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-sm font-medium text-secondary-700 transition hover:bg-primary-50 hover:text-primary-600">
                                        <span class="flex items-center gap-2"><x-lucide-tag class="h-4 w-4" /> Categorías</span>
                                        <x-lucide-chevron-down class="h-4 w-4 transition-transform" ::class="{ 'rotate-180': catsOpen }" />
                                    </button>
                                    <div x-show="catsOpen" x-cloak class="space-y-0.5 py-1">
                                        @foreach($navCategories->take(6) as $category)
                                            <a href="{{ route('blog.category', $category->slug) }}" @click="mobileOpen = false" class="flex items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-secondary-600 transition hover:bg-primary-50 hover:text-primary-600">
                                                <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $category->color }}"></span>
                                                <span class="flex-1 truncate font-medium">{{ $category->name }}</span>
                                                <span class="text-xs text-secondary-400">{{ $category->published_posts_count }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Mobile types -->
                                <div class="border-t border-secondary-100 pt-2" x-data="{ typesOpen: false }">
                                    <button @click="typesOpen = !typesOpen" class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-sm font-medium text-secondary-700 transition hover:bg-primary-50 hover:text-primary-600">
                                        <span class="flex items-center gap-2"><x-lucide-layout-grid class="h-4 w-4" /> Tipos de Contenido</span>
                                        <x-lucide-chevron-down class="h-4 w-4 transition-transform" ::class="{ 'rotate-180': typesOpen }" />
                                    </button>
                                    <div x-show="typesOpen" x-cloak class="space-y-0.5 py-1">
                                        @foreach($navPostTypes->take(5) as $postType)
                                            <a href="{{ route('blog.post-type', $postType->slug) }}" @click="mobileOpen = false" class="flex items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-secondary-600 transition hover:bg-primary-50 hover:text-primary-600">
                                                <span class="text-base">{{ $postType->icon ?? '📄' }}</span>
                                                <span class="flex-1 truncate font-medium">{{ $postType->name }}</span>
                                                <span class="text-xs text-secondary-400">{{ $postType->published_posts_count }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                @auth
                                    <div class="mt-2 space-y-1 border-t border-secondary-100 pt-2">
                                        <div class="mx-4 flex items-center gap-2.5 rounded-lg border border-primary-100 bg-primary-50 p-2.5">
                                            <x-avatar :name="auth()->user()->name" size="sm" />
                                            <div class="min-w-0">
                                                <div class="truncate text-sm font-medium text-secondary-900">{{ auth()->user()->name }}</div>
                                                <div class="text-xs font-medium capitalize text-primary-600">{{ auth()->user()->role }}</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-secondary-600 transition hover:bg-primary-50 hover:text-primary-600">
                                            <x-lucide-layout-dashboard class="h-4 w-4 text-secondary-400" /> Dashboard
                                        </a>
                                        @if(auth()->user()->canPublish())
                                            <a href="{{ route('posts.index') }}" class="flex items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-secondary-600 transition hover:bg-primary-50 hover:text-primary-600">
                                                <x-lucide-file-text class="h-4 w-4 text-secondary-400" /> Mis Posts
                                            </a>
                                        @endif
                                        @if(auth()->user()->canModerate())
                                            <a href="{{ route('moderation.index') }}" class="flex items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-secondary-600 transition hover:bg-primary-50 hover:text-primary-600">
                                                <x-lucide-shield-check class="h-4 w-4 text-secondary-400" /> Moderación
                                            </a>
                                        @endif
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-secondary-600 transition hover:bg-primary-50 hover:text-primary-600">
                                            <x-lucide-user class="h-4 w-4 text-secondary-400" /> Mi Perfil
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-6 py-2 text-sm text-danger-600 transition hover:bg-danger-50">
                                                <x-lucide-log-out class="h-4 w-4" /> Cerrar Sesión
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-2 space-y-2 border-t border-secondary-100 px-4 pt-3">
                                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-lg border border-secondary-200 px-4 py-2.5 text-sm font-medium text-secondary-700 transition hover:bg-primary-50 hover:text-primary-600">
                                            <x-lucide-log-in class="h-4 w-4" /> Iniciar Sesión
                                        </a>
                                        <x-ui.button :href="route('register')" icon="user-plus" class="w-full">Registrarse</x-ui.button>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary-900 text-secondary-300">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                @php
                    $footerLogo = \App\Models\BlogSetting::get('footer_logo');
                    $footerText = \App\Models\BlogSetting::get('footer_text', config('app.name'));
                    $siteDescription = \App\Models\BlogSetting::get('site_description', 'Tu fuente confiable de información sobre tecnología, programación y desarrollo web.');
                @endphp
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        @if($footerLogo || $siteLogo)
                            <img src="{{ asset('storage/' . ($footerLogo ?: $siteLogo)) }}" alt="{{ $footerText }}" class="mr-3 h-8 w-auto object-contain">
                        @else
                            <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-primary-500 to-accent-500">
                                <span class="text-xs font-bold text-white">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($footerText, 0, 2)) }}</span>
                            </div>
                        @endif
                        <span class="text-lg font-bold text-white">{{ $footerText }}</span>
                    </div>
                    <p class="mt-4 max-w-md text-sm leading-relaxed text-secondary-400">{{ $siteDescription }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-secondary-400">Categorías</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach($navCategories->take(5) as $category)
                            <li>
                                <a href="{{ route('blog.category', $category->slug) }}" class="text-sm text-secondary-400 transition hover:text-white">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-secondary-400">Tipos de contenido</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach($navPostTypes->take(5) as $postType)
                            <li>
                                <a href="{{ route('blog.post-type', $postType->slug) }}" class="text-sm text-secondary-400 transition hover:text-white">{{ $postType->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-secondary-700 pt-8">
                <p class="text-center text-sm text-secondary-400">© {{ date('Y') }} {{ $footerText }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
