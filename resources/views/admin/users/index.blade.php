@extends('layouts.app')

@section('title', 'Usuarios - Gestión')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                Gestión de Usuarios
            </h1>
            <p class="text-xl text-secondary-600 mt-2">Administra usuarios y permisos del sistema</p>
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
                    <div class="text-2xl font-bold text-secondary-900">{{ $users->total() }}</div>
                    <div class="text-sm text-secondary-600">Total Usuarios</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                    <div class="text-sm text-secondary-600">Administradores</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::where('role', 'moderator')->count() }}</div>
                    <div class="text-sm text-secondary-600">Moderadores</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ \App\Models\User::where('role', 'author')->count() }}</div>
                    <div class="text-sm text-secondary-600">Autores</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-6 mb-8">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Buscar por nombre o email..."
                               class="w-full pl-10 pr-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <select name="role" class="px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        <option value="">Todos los roles</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Administradores</option>
                        <option value="moderator" {{ $role === 'moderator' ? 'selected' : '' }}>Moderadores</option>
                        <option value="author" {{ $role === 'author' ? 'selected' : '' }}>Autores</option>
                        <option value="user" {{ $role === 'user' ? 'selected' : '' }}>Usuarios</option>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors duration-200">
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        @if($users->count() > 0)
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Posts</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-secondary-700 uppercase tracking-wider">Registro</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-secondary-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-secondary-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center mr-3">
                                        <span class="text-sm font-semibold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-secondary-900">{{ $user->name }}</div>
                                        <div class="text-sm text-secondary-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @switch($user->role)
                                    @case('admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Administrador
                                        </span>
                                        @break
                                    @case('moderator')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Moderador
                                        </span>
                                        @break
                                    @case('author')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Autor
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Usuario
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active ?? true)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactivo
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-secondary-600">{{ $user->posts_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-secondary-600">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Cambiar Rol -->
                                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="px-3 py-1.5 text-xs border border-secondary-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                                            <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Autor</option>
                                            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderador</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-primary-100 hover:bg-primary-200 text-primary-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                            Actualizar
                                        </button>
                                    </form>

                                    <!-- Activar/Desactivar -->
                                    @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($user->is_active ?? true)
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-medium transition-colors duration-200" onclick="return confirm('¿Desactivar este usuario?')">
                                            Desactivar
                                        </button>
                                        @else
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg text-xs font-medium transition-colors duration-200">
                                            Activar
                                        </button>
                                        @endif
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-secondary-200">
                {{ $users->links() }}
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 p-12 text-center">
            <div class="w-16 h-16 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-secondary-900 mb-2">No se encontraron usuarios</h3>
            <p class="text-secondary-600">
                @if($search || $role)
                    Intenta ajustar los filtros de búsqueda.
                @else
                    No hay usuarios registrados en el sistema.
                @endif
            </p>
        </div>
        @endif
    </div>
</div>
@endsection

