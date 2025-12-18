@extends('layouts.app')

@section('title', 'Mensaje de ' . $contact->nombre)

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
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <div class="flex items-center">
                    <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr($contact->nombre, 0, 2)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $contact->nombre }}</h1>
                        <p class="text-indigo-100">{{ $contact->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Message -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-3">Mensaje</h3>
                    <div class="bg-secondary-50 rounded-xl p-6">
                        <p class="text-secondary-800 whitespace-pre-wrap leading-relaxed">{{ $contact->mensaje }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-2">Fecha de envío</h3>
                        <p class="text-secondary-900">{{ $contact->created_at->format('d M Y, H:i:s') }}</p>
                        <p class="text-secondary-500 text-sm">{{ $contact->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-2">Dirección IP</h3>
                        <p class="text-secondary-900">{{ $contact->ip_address ?? 'No disponible' }}</p>
                    </div>
                </div>

                @if($contact->user_agent)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-2">User Agent</h3>
                    <p class="text-secondary-600 text-sm bg-secondary-50 rounded-lg p-3 font-mono break-all">{{ $contact->user_agent }}</p>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-secondary-200">
                    <a href="mailto:{{ $contact->email }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Responder por Email
                    </a>

                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
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

