@extends('layouts.app')

@section('title', 'Mensajes de Contacto')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                Mensajes de Contacto
            </h1>
            <p class="text-xl text-secondary-600 mt-2">Mensajes recibidos desde tu página personal</p>
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
                    <div class="text-2xl font-bold text-secondary-900">{{ $stats['total'] }}</div>
                    <div class="text-sm text-secondary-600">Total Mensajes</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['today'] }}</div>
                    <div class="text-sm text-secondary-600">Hoy</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['this_week'] }}</div>
                    <div class="text-sm text-secondary-600">Esta Semana</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $stats['this_month'] }}</div>
                    <div class="text-sm text-secondary-600">Este Mes</div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6 mb-8">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Buscar por nombre, email o mensaje..."
                               class="w-full pl-10 pr-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors duration-200">
                    Buscar
                </button>
            </form>
        </div>

        <!-- Contacts Table -->
        @if($contacts->count() > 0)
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Remitente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Mensaje</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-secondary-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-100">
                        @foreach($contacts as $contact)
                        <tr class="hover:bg-secondary-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-400 flex items-center justify-center mr-3">
                                        <span class="text-sm font-semibold text-white">{{ strtoupper(substr($contact->nombre, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-secondary-900">{{ $contact->nombre }}</div>
                                        <div class="text-sm text-secondary-500">{{ $contact->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-secondary-700 max-w-md truncate">{{ $contact->short_message }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-secondary-900">{{ $contact->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-secondary-500">{{ $contact->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                        Ver
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-colors duration-200"
                                                onclick="return confirm('¿Eliminar este mensaje?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-secondary-200">
                {{ $contacts->links() }}
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-12 text-center">
            <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-secondary-900 mb-2">No hay mensajes</h3>
            <p class="text-secondary-600">
                @if($search)
                    No se encontraron mensajes con esa búsqueda.
                @else
                    Aún no has recibido mensajes de contacto.
                @endif
            </p>
        </div>
        @endif
    </div>
</div>
@endsection

