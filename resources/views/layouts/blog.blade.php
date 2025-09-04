<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\BlogSetting::get('site_name', config('app.name')))</title>
    <meta name="description" content="@yield('description', 'Blog de ' . \App\Models\BlogSetting::get('site_name', config('app.name')) . '. Contenido de calidad sobre diversos temas.')">

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



    <!-- Custom Styles -->
    <style>
        /* Prevent flash of unstyled content */
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar for mobile menu */
        .mobile-menu::-webkit-scrollbar {
            width: 4px;
        }
        .mobile-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .mobile-menu::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }
        .mobile-menu::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Hover effects for dropdown items */
        .dropdown-item {
            transition: all 0.15s ease-in-out;
        }
        .dropdown-item:hover {
            transform: translateX(2px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-secondary-50 to-primary-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-soft border-b border-secondary-200/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('blog.index') }}" class="flex items-center group">
                        @php
                            $siteLogo = \App\Models\BlogSetting::get('site_logo');
                            $navbarText = \App\Models\BlogSetting::get('navbar_text', config('app.name'));
                        @endphp

                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}"
                                 alt="{{ $navbarText }}"
                                 class="h-10 w-auto object-contain mr-3 group-hover:scale-105 transition-transform duration-200">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center mr-3 group-hover:scale-105 transition-transform duration-200">
                                <span class="text-white font-bold text-sm">{{ substr($navbarText, 0, 2) }}</span>
                            </div>
                        @endif

                        <span class="text-2xl font-bold bg-gradient-to-r from-secondary-900 to-primary-700 bg-clip-text text-transparent">{{ $navbarText }}</span>
                    </a>

                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-12 sm:flex sm:space-x-1">
                        <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Inicio
                        </a>

                        <!-- Categories Dropdown -->
                        <div class="relative inline-flex items-center" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Categorías
                                <svg class="ml-2 h-4 w-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="absolute top-full left-0 mt-3 w-72 bg-white/95 backdrop-blur-md rounded-2xl shadow-large ring-1 ring-secondary-200/50 z-50 animate-slide-up">
                                <div class="p-3">
                                    @php
                                        $categories = \App\Models\Category::active()
                                            ->withCount(['posts as published_posts_count' => function ($query) {
                                                $query->where('status', 'published');
                                            }])
                                            ->orderBy('name')
                                            ->get();
                                    @endphp

                                    @foreach($categories as $category)
                                    <a href="{{ route('blog.category', $category->slug) }}"
                                       class="dropdown-item flex items-center px-4 py-3 rounded-xl text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group">
                                        <div class="w-4 h-4 rounded-full mr-3 group-hover:scale-110 transition-transform duration-200" style="background-color: {{ $category->color }}"></div>
                                        <div class="flex-1">
                                            <div class="font-semibold">{{ $category->name }}</div>
                                            <div class="text-xs text-secondary-500">{{ $category->published_posts_count }} artículos</div>
                                        </div>
                                        <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 opacity-0 group-hover:opacity-100 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    @endforeach

                                    <div class="border-t border-secondary-100 mt-3 pt-3">
                                        <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-2 rounded-xl text-sm text-primary-600 hover:bg-primary-50 transition-all duration-200 font-medium">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                            Ver todas las categorías
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Post Types Dropdown -->
                        <div class="relative inline-flex items-center" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-secondary-700 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4M1 12h4m14 0H9m10 0H5" />
                                </svg>
                                Tipos
                                <svg class="ml-2 h-4 w-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Post Types Dropdown Menu -->
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="absolute top-full left-0 mt-3 w-72 bg-white/95 backdrop-blur-md rounded-2xl shadow-large ring-1 ring-secondary-200/50 z-50 animate-slide-up">
                                <div class="p-3">
                                    @php
                                        $postTypes = \App\Models\PostType::active()
                                            ->withCount(['posts as published_posts_count' => function ($query) {
                                                $query->where('status', 'published');
                                            }])
                                            ->orderBy('name')
                                            ->get();
                                    @endphp

                                    @foreach($postTypes as $postType)
                                    <a href="{{ route('blog.post-type', $postType->slug) }}"
                                       class="dropdown-item flex items-center px-4 py-3 rounded-xl text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-accent-100 to-accent-200 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                            <span class="text-lg">{{ $postType->icon ?? '📄' }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold">{{ $postType->name }}</div>
                                            <div class="text-xs text-secondary-500">{{ $postType->published_posts_count }} publicaciones</div>
                                        </div>
                                        <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 opacity-0 group-hover:opacity-100 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    @endforeach

                                    <div class="border-t border-secondary-100 mt-3 pt-3">
                                        <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-2 rounded-xl text-sm text-primary-600 hover:bg-primary-50 transition-all duration-200 font-medium">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4" />
                                            </svg>
                                            Ver todos los tipos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route('blog.index') }}" method="GET" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Buscar..."
                                   value="{{ request('search') }}"
                                   class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </form>

                    <!-- Auth Links -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-xs font-medium text-gray-700">
                                        {{ substr(Auth::user()->name, 0, 2) }}
                                    </span>
                                </div>
                                {{ Auth::user()->name }}
                                <svg class="ml-1 h-4 w-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- User Dropdown Menu -->
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="absolute right-0 top-full mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-2">
                                    <!-- User Info -->
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr(Auth::user()->name, 0, 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                                <div class="text-xs text-blue-600 capitalize">{{ Auth::user()->role }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Navigation Links -->
                                    <div class="py-1">
                                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                                            </svg>
                                            Dashboard
                                        </a>

                                        @if(Auth::user()->canPublish())
                                        <a href="{{ route('posts.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Mis Posts
                                        </a>

                                        <a href="{{ route('posts.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Crear Post
                                        </a>
                                        @endif

                                        @if(Auth::user()->canModerate())
                                        <a href="{{ route('moderation.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Moderación
                                        </a>

                                        <a href="{{ route('comments.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.456L3 21l2.544-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z" />
                                            </svg>
                                            Comentarios
                                        </a>
                                        @endif

                                        @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Administración de Usuarios
                                        </a>
                                        @endif

                                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Mi Perfil
                                        </a>
                                    </div>

                                    <!-- Logout -->
                                    <div class="border-t border-gray-100 pt-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Cerrar Sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Registrarse</a>
                    @endauth

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden" x-data="{ mobileOpen: false }">
                        <button @click="mobileOpen = !mobileOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <svg class="h-6 w-6" :class="{ 'hidden': mobileOpen, 'block': !mobileOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" :class="{ 'block': mobileOpen, 'hidden': !mobileOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Mobile menu -->
                        <div x-show="mobileOpen"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="mobileOpen = false"
                             class="absolute top-16 left-0 right-0 bg-white shadow-lg border-t border-gray-200 z-50">
                            <div class="px-4 py-2 space-y-1">
                                <a href="{{ route('blog.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                    Inicio
                                </a>

                                <!-- Mobile Categories -->
                                <div class="space-y-1">
                                    <div class="px-3 py-2 text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Categorías
                                    </div>
                                    @php
                                        $mobileCategories = \App\Models\Category::active()->orderBy('name')->get();
                                    @endphp
                                    @foreach($mobileCategories as $category)
                                    <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center px-6 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                        <div class="w-2 h-2 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                </div>

                                <!-- Mobile Post Types -->
                                <div class="space-y-2">
                                    <div class="px-4 py-3 text-sm font-bold text-secondary-700 uppercase tracking-wider flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4M1 12h4m14 0H9m10 0H5" />
                                        </svg>
                                        Tipos de Contenido
                                    </div>
                                    @php
                                        $mobilePostTypes = \App\Models\PostType::active()
                                            ->withCount(['posts as published_posts_count' => function ($query) {
                                                $query->where('status', 'published');
                                            }])
                                            ->orderBy('name')
                                            ->get();
                                    @endphp
                                    @foreach($mobilePostTypes as $postType)
                                    <a href="{{ route('blog.post-type', $postType->slug) }}" class="flex items-center px-6 py-3 text-sm text-secondary-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200 group">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent-100 to-accent-200 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                            <span class="text-sm">{{ $postType->icon ?? '📄' }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ $postType->name }}</div>
                                            <div class="text-xs text-secondary-500">{{ $postType->published_posts_count }} publicaciones</div>
                                        </div>
                                        <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 opacity-0 group-hover:opacity-100 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    @endforeach
                                </div>

                                @auth
                                <!-- Mobile User Menu -->
                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <div class="px-3 py-2 text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Mi Cuenta
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                        Dashboard
                                    </a>
                                    @if(Auth::user()->canPublish())
                                    <a href="{{ route('posts.index') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                        Mis Posts
                                    </a>
                                    @endif
                                    @if(Auth::user()->canModerate())
                                    <a href="{{ route('moderation.index') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                        Moderación
                                    </a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                        Mi Perfil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-6 py-2 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded-md">
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div class="border-t border-gray-200 pt-4 mt-4 space-y-1">
                                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                                        Iniciar Sesión
                                    </a>
                                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                                        Registrarse
                                    </a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center">
                        @php
                            $footerLogo = \App\Models\BlogSetting::get('footer_logo');
                            $siteLogo = \App\Models\BlogSetting::get('site_logo');
                            $footerText = \App\Models\BlogSetting::get('footer_text', config('app.name'));
                            $siteDescription = \App\Models\BlogSetting::get('site_description', 'Tu fuente confiable de información sobre tecnología, programación y desarrollo web.');
                        @endphp

                        @if($footerLogo)
                            <img src="{{ asset('storage/' . $footerLogo) }}"
                                 alt="{{ $footerText }}"
                                 class="h-8 w-auto object-contain mr-3">
                        @elseif($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}"
                                 alt="{{ $footerText }}"
                                 class="h-8 w-auto object-contain mr-3">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-accent-500 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-xs">{{ substr($footerText, 0, 2) }}</span>
                            </div>
                        @endif
                        <span class="ml-2 text-lg font-bold">{{ $footerText }}</span>
                    </div>
                    <p class="mt-4 text-gray-300">
                        {{ $siteDescription }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Categorías</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Programación</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Inteligencia Artificial</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Desarrollo Web</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Enlaces</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Acerca de</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Contacto</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Política de Privacidad</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-700 pt-8">
                <p class="text-center text-gray-400">
                    © {{ date('Y') }} {{ \App\Models\BlogSetting::get('footer_text', config('app.name')) }}. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
