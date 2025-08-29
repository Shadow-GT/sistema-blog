@extends('layouts.app')

@section('title', 'Configuración del Blog')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        Configuración del Blog
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Personaliza la apariencia y configuración general</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-secondary-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl px-6 py-4 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-green-800 font-semibold mb-1">¡Éxito!</h3>
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl px-6 py-4 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-red-800 font-semibold mb-2">Por favor corrige los siguientes errores:</h3>
                    <ul class="text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-50 border border-red-200 rounded-2xl px-6 py-4 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-red-800 font-semibold">Error:</h3>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if (session('info'))
        <div class="bg-blue-50 border border-blue-200 rounded-2xl px-6 py-4 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-blue-700">{{ session('info') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
                    <div class="p-8">
                        <div class="border-b border-secondary-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                                </svg>
                                Configuración General
                            </h3>
                            <p class="text-secondary-600 text-sm mt-1">Personaliza el nombre y logo de tu blog</p>
                        </div>

                        <form method="POST" action="{{ route('admin.blog-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Site Name -->
                            <div>
                                <label for="site_name" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Nombre del Blog *
                                </label>
                                <input type="text" name="site_name" id="site_name" required
                                       value="{{ old('site_name', $settings['site_name']) }}"
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 text-lg"
                                       placeholder="Mi Blog Increíble">
                                <p class="text-xs text-secondary-500 mt-2">Nombre principal del blog para configuraciones internas</p>
                            </div>

                            <!-- Navbar Text -->
                            <div>
                                <label for="navbar_text" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Texto del Navbar *
                                </label>
                                <input type="text" name="navbar_text" id="navbar_text" required
                                       value="{{ old('navbar_text', $settings['navbar_text']) }}"
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                       placeholder="Mi Blog">
                                <p class="text-xs text-secondary-500 mt-2">Texto que aparece en la navegación junto al logo</p>
                            </div>

                            <!-- Header Text -->
                            <div>
                                <label for="header_text" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Texto del Header *
                                </label>
                                <input type="text" name="header_text" id="header_text" required
                                       value="{{ old('header_text', $settings['header_text']) }}"
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                       placeholder="Bienvenido a Mi Blog">
                                <p class="text-xs text-secondary-500 mt-2">Título grande que aparece en la página principal</p>
                            </div>

                            <!-- Footer Text -->
                            <div>
                                <label for="footer_text" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Texto del Footer *
                                </label>
                                <input type="text" name="footer_text" id="footer_text" required
                                       value="{{ old('footer_text', $settings['footer_text']) }}"
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                       placeholder="Mi Blog">
                                <p class="text-xs text-secondary-500 mt-2">Texto que aparece en el footer y copyright</p>
                            </div>

                            <!-- Site Description -->
                            <div>
                                <label for="site_description" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Descripción del Sitio *
                                </label>
                                <textarea name="site_description" id="site_description" required rows="3"
                                          class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                          placeholder="Descripción que aparece en el footer y meta tags">{{ old('site_description', $settings['site_description']) }}</textarea>
                                <p class="text-xs text-secondary-500 mt-2">Descripción que aparece en el footer del blog</p>
                            </div>

                            <!-- Site Logo -->
                            <div>
                                <label for="site_logo" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Logo del Blog
                                </label>

                                @if($settings['site_logo'])
                                <div class="mb-4 p-4 bg-secondary-50 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                                 alt="Logo actual"
                                                 class="h-16 w-16 object-contain rounded-lg border border-secondary-200 bg-white">
                                            <div>
                                                <p class="text-sm font-medium text-secondary-900">Logo actual</p>
                                                <p class="text-xs text-secondary-500">Subido correctamente</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                                onclick="if(confirm('¿Estás seguro de que quieres eliminar el logo?')) { document.getElementById('delete-logo-form').submit(); }"
                                                class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                                @endif

                                <input type="file" name="site_logo" id="site_logo" accept="image/*"
                                       class="block w-full text-sm text-secondary-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="text-xs text-secondary-500 mt-2">
                                    Formatos soportados: JPG, PNG, GIF, SVG. Tamaño máximo: 2MB.
                                    <br>Recomendado: 200x60px para mejor visualización.
                                </p>
                            </div>

                            <!-- Footer Logo -->
                            <div>
                                <label for="footer_logo" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Logo del Footer
                                </label>

                                @if($settings['footer_logo'])
                                <div class="mb-4 p-4 bg-secondary-50 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $settings['footer_logo']) }}"
                                                 alt="Footer logo actual"
                                                 class="h-16 w-16 object-contain rounded-lg border border-secondary-200 bg-white">
                                            <div>
                                                <p class="text-sm font-medium text-secondary-900">Logo del footer actual</p>
                                                <p class="text-xs text-secondary-500">Subido correctamente</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                                onclick="if(confirm('¿Estás seguro de que quieres eliminar el logo del footer?')) { document.getElementById('delete-footer-logo-form').submit(); }"
                                                class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                                @endif

                                <input type="file" name="footer_logo" id="footer_logo" accept="image/*"
                                       class="block w-full text-sm text-secondary-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                <p class="text-xs text-secondary-500 mt-2">
                                    Logo específico para el footer (fondo oscuro). Si no se sube, se usa el logo principal.
                                    <br>Recomendado: Logo en blanco o colores claros para mejor visibilidad.
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Guardar Configuración
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Preview -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Vista Previa
                    </h3>
                    <div class="bg-secondary-50 rounded-xl p-4 space-y-4">
                        <!-- Navbar Preview -->
                        <div>
                            <p class="text-xs font-semibold text-secondary-600 mb-2">NAVBAR:</p>
                            <div class="flex items-center space-x-3">
                                @if($settings['site_logo'])
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                     alt="Logo"
                                     class="h-8 w-auto object-contain">
                                @else
                                <div class="h-8 w-8 bg-gradient-to-br from-primary-500 to-accent-500 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">{{ substr($settings['navbar_text'], 0, 2) }}</span>
                                </div>
                                @endif
                                <span class="text-sm font-semibold text-secondary-900">{{ $settings['navbar_text'] }}</span>
                            </div>
                        </div>

                        <!-- Header Preview -->
                        <div>
                            <p class="text-xs font-semibold text-secondary-600 mb-2">HEADER:</p>
                            <div class="bg-gradient-to-r from-primary-600 to-accent-600 rounded-lg p-3">
                                <h2 class="text-lg font-bold text-white">{{ $settings['header_text'] }}</h2>
                            </div>
                        </div>

                        <!-- Footer Preview -->
                        <div>
                            <p class="text-xs font-semibold text-secondary-600 mb-2">FOOTER:</p>
                            <div class="bg-gray-800 rounded-lg p-3">
                                <div class="flex items-center space-x-2 mb-2">
                                    @if($settings['footer_logo'])
                                    <img src="{{ asset('storage/' . $settings['footer_logo']) }}"
                                         alt="Footer Logo"
                                         class="h-6 w-auto object-contain">
                                    @elseif($settings['site_logo'])
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                         alt="Logo"
                                         class="h-6 w-auto object-contain">
                                    @else
                                    <div class="h-6 w-6 bg-gradient-to-br from-primary-500 to-accent-500 rounded flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">{{ substr($settings['footer_text'], 0, 2) }}</span>
                                    </div>
                                    @endif
                                    <span class="text-sm font-semibold text-white">{{ $settings['footer_text'] }}</span>
                                </div>
                                <p class="text-xs text-gray-300">{{ $settings['site_description'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Consejos
                    </h3>
                    <div class="space-y-3 text-sm text-secondary-600">
                        <div class="flex items-start space-x-2">
                            <span class="text-yellow-500 mt-0.5">💡</span>
                            <p>Usa un logo con fondo transparente (PNG) para mejor integración.</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-500 mt-0.5">📐</span>
                            <p>El tamaño recomendado para el logo es 200x60 píxeles.</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-green-500 mt-0.5">✨</span>
                            <p>Los cambios se aplicarán inmediatamente en todo el sitio.</p>
                        </div>
                    </div>
                </div>

                <!-- Future Features -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl border border-purple-200 p-6">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Próximamente
                    </h3>
                    <div class="space-y-2 text-sm text-purple-700">
                        <p>• Colores personalizados</p>
                        <p>• Configuración SEO</p>
                        <p>• Redes sociales</p>
                        <p>• Favicon personalizado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forms de eliminación (fuera del form principal) -->
<form id="delete-logo-form" method="POST" action="{{ route('admin.blog-settings.remove-logo') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="delete-footer-logo-form" method="POST" action="{{ route('admin.blog-settings.remove-footer-logo') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection
