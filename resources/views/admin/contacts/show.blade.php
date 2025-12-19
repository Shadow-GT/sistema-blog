@extends('layouts.app')

@section('title', 'Mensaje de ' . $message->nombre)

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a mensajes
            </a>
        </div>

        <!-- Message Card -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r {{ $message->source === 'personal' ? 'from-blue-500 to-blue-600' : 'from-purple-500 to-purple-600' }} px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($message->nombre, 0, 2)) }}</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $message->nombre }}</h1>
                            <p class="text-white/80">{{ $message->email }}</p>
                            @if($message->telefono)
                            <p class="text-white/70 text-sm">📞 {{ $message->telefono }}</p>
                            @endif
                        </div>
                    </div>
                    <!-- Source Badge -->
                    <div>
                        @if($message->source === 'personal')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white/20 text-white">
                            Personal Web
                        </span>
                        @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white/20 text-white">
                            Servicios
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Message -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-3">Mensaje</h3>
                    <div class="bg-secondary-50 rounded-xl p-6">
                        <p class="text-secondary-800 whitespace-pre-wrap leading-relaxed">{{ $message->mensaje }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-2">Fecha de envío</h3>
                        <p class="text-secondary-900">{{ $message->created_at->format('d M Y, H:i:s') }}</p>
                        <p class="text-secondary-500 text-sm">{{ $message->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-2">Dirección IP</h3>
                        <p class="text-secondary-900">{{ $message->ip_address ?? 'No disponible' }}</p>
                    </div>
                </div>

                @if($message->user_agent)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-2">User Agent</h3>
                    <p class="text-secondary-600 text-sm bg-secondary-50 rounded-lg p-3 font-mono break-all">{{ $message->user_agent }}</p>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <div class="flex gap-3">
                        <a href="mailto:{{ $message->email }}"
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Responder por Email
                        </a>
                        @if($message->telefono)
                        <a href="tel:{{ $message->telefono }}"
                           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Llamar
                        </a>
                        @endif
                    </div>

                    <form action="{{ route('admin.contacts.destroy', ['contact' => $message->id, 'source' => $message->source]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-xl transition-colors duration-200"
                                onclick="return confirm('¿Estás seguro de eliminar este mensaje?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Eliminar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

