@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        Mi Perfil
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Gestiona tu información personal y configuración</p>
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

        <!-- Success Messages -->
        @if (session('status'))
        <div class="bg-green-50 border border-green-200 rounded-2xl px-6 py-4 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-green-800 font-semibold mb-1">¡Actualizado correctamente!</h3>
                    <p class="text-green-700 text-sm">
                        @if(session('status') === 'profile-updated')
                            Tu información de perfil ha sido actualizada.
                        @elseif(session('status') === 'password-updated')
                            Tu contraseña ha sido cambiada exitosamente.
                        @elseif(session('status') === 'author-requested')
                            Tu solicitud para ser autor ha sido enviada y está pendiente de revisión.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Profile Information -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
                    <div class="p-8">
                        <div class="border-b border-secondary-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Información Personal
                            </h3>
                            <p class="text-secondary-600 text-sm mt-1">Actualiza tu nombre, email y foto de perfil</p>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Profile Photo -->
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <img class="h-20 w-20 object-cover rounded-2xl border-2 border-secondary-200"
                                         src="{{ $user->profile_photo_url }}"
                                         alt="{{ $user->name }}">
                                </div>
                                <div class="flex-1">
                                    <label for="profile_photo" class="block text-sm font-semibold text-secondary-700 mb-2">
                                        Foto de Perfil
                                    </label>
                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                           class="block w-full text-sm text-secondary-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    <p class="text-xs text-secondary-500 mt-1">JPG, PNG, GIF hasta 2MB</p>
                                    @error('profile_photo')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Nombre completo *
                                </label>
                                <input type="text" name="name" id="name" required
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Correo electrónico *
                                </label>
                                <input type="email" name="email" id="email" required
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actualizar Perfil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
                    <div class="p-8">
                        <div class="border-b border-secondary-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Cambiar Contraseña
                            </h3>
                            <p class="text-secondary-600 text-sm mt-1">Actualiza tu contraseña para mantener tu cuenta segura</p>
                        </div>

                        <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Contraseña actual *
                                </label>
                                <input type="password" name="current_password" id="current_password" required
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Nueva contraseña *
                                </label>
                                <input type="password" name="password" id="password" required
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-secondary-700 mb-2">
                                    Confirmar nueva contraseña *
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Cambiar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- User Info -->
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Información de Cuenta
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-secondary-600 text-sm">Rol actual</span>
                            <div class="mt-1">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                        👑 Administrador
                                    </span>
                                @elseif($user->role === 'author')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        ✍️ Autor
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                        👤 Usuario
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <span class="text-secondary-600 text-sm">Miembro desde</span>
                            <div class="mt-1 text-sm text-secondary-900">{{ $user->created_at->format('d M Y') }}</div>
                        </div>
                        <div>
                            <span class="text-secondary-600 text-sm">Posts publicados</span>
                            <div class="mt-1 text-sm text-secondary-900">{{ $user->posts()->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Author Request -->
                @if($user->canRequestAuthor())
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Convertirse en Autor
                    </h3>
                    <p class="text-secondary-600 text-sm mb-4">
                        Como autor podrás crear y publicar posts en el blog. Tu solicitud será revisada por un administrador.
                    </p>
                    <form method="POST" action="{{ route('profile.request-author') }}">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-2xl transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Solicitar ser Autor
                        </button>
                    </form>
                </div>
                @elseif($user->hasPendingAuthorRequest())
                <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Solicitud Pendiente
                    </h3>
                    <div class="bg-yellow-50 rounded-xl p-4 border-l-4 border-yellow-400">
                        <p class="text-yellow-800 text-sm">
                            Tu solicitud para ser autor está pendiente de revisión. Te notificaremos cuando sea procesada.
                        </p>
                        <p class="text-yellow-700 text-xs mt-2">
                            Solicitado el {{ $user->author_requested_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
