@extends('layouts.app')

@section('title', 'Editar Post - ' . $post->title)

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-secondary-900 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        Editar Post
                    </h1>
                    <p class="text-xl text-secondary-600 mt-2">Modifica tu artículo: "{{ Str::limit($post->title, 50) }}"</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center px-6 py-3 bg-green-100 hover:bg-green-200 text-green-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Ver Post
                    </a>
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 bg-secondary-100 hover:bg-secondary-200 text-secondary-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a Mis Posts
                    </a>
                </div>
            </div>
        </div>

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

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-soft border border-secondary-100 overflow-hidden">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="space-y-6">
                    <div class="border-b border-secondary-200 pb-4">
                        <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Información Básica
                        </h3>
                        <p class="text-secondary-600 text-sm mt-1">Título y configuración principal del artículo</p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-secondary-700 mb-2">
                            Título del Post *
                        </label>
                        <input type="text" name="title" id="title" required
                               value="{{ old('title', $post->title) }}"
                               class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 text-lg"
                               placeholder="Escribe un título atractivo para tu post">
                        <p class="text-xs text-secondary-500 mt-2">Un buen título es claro, descriptivo y atractivo para los lectores</p>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-secondary-700 mb-2">
                            URL del Post (Slug)
                        </label>
                        <div class="relative">
                            <input type="text" name="slug" id="slug"
                                   value="{{ old('slug', $post->slug) }}"
                                   class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                   placeholder="url-del-post">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-secondary-500 mt-2">La URL actual es: <span class="font-mono text-primary-600">{{ url('/blog/' . $post->slug) }}</span></p>
                    </div>

                    <!-- Category and Post Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-secondary-700 mb-2">
                                Categoría *
                            </label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="post_type_id" class="block text-sm font-semibold text-secondary-700 mb-2">
                                Tipo de Post *
                            </label>
                            <select name="post_type_id" id="post_type_id" required
                                    class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                <option value="">Selecciona un tipo</option>
                                @foreach($postTypes as $postType)
                                <option value="{{ $postType->id }}" {{ old('post_type_id', $post->post_type_id) == $postType->id ? 'selected' : '' }}>
                                    {{ $postType->icon }} {{ $postType->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <div class="border-b border-secondary-200 pb-4">
                        <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Contenido del Post
                        </h3>
                        <p class="text-secondary-600 text-sm mt-1">Modifica el contenido de tu artículo</p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-semibold text-secondary-700 mb-2">
                            Resumen/Extracto
                        </label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                                  class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 resize-none"
                                  placeholder="Escribe un breve resumen de tu post (opcional)">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <p class="text-xs text-secondary-500 mt-2">Este resumen aparecerá en las listas de posts y redes sociales</p>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-semibold text-secondary-700 mb-2">
                            Contenido del Post *
                        </label>
                        <textarea name="content" id="content" rows="15"
                                  class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                  placeholder="Escribe aquí el contenido completo de tu post...">{{ old('content', $post->content) }}</textarea>
                        <p class="text-xs text-secondary-500 mt-2">Usa el editor para dar formato rico a tu contenido</p>
                    </div>
                </div>

                <!-- Featured Image Section -->
                <div class="space-y-6">
                    <div class="border-b border-secondary-200 pb-4">
                        <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Imagen de Portada
                        </h3>
                        <p class="text-secondary-600 text-sm mt-1">Imagen principal que aparecerá en el blog (opcional)</p>
                    </div>

                    <!-- Current Image Preview -->
                    @if($post->featured_image)
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-secondary-700 mb-2">
                            Imagen Actual
                        </label>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                 alt="Imagen actual"
                                 class="w-32 h-32 object-cover rounded-xl border border-secondary-200">
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-200 rounded-xl flex items-center justify-center">
                                <span class="text-white text-xs opacity-0 hover:opacity-100 transition-opacity duration-200">Vista previa</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div>
                        <label for="featured_image" class="block text-sm font-semibold text-secondary-700 mb-2">
                            {{ $post->featured_image ? 'Cambiar Imagen de Portada' : 'Imagen de Portada' }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary-300 border-dashed rounded-xl hover:border-primary-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-secondary-600">
                                    <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>{{ $post->featured_image ? 'Cambiar imagen' : 'Subir una imagen' }}</span>
                                        <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-secondary-500">
                                    PNG, JPG, GIF hasta 2MB
                                </p>
                            </div>
                        </div>
                        @error('featured_image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Settings -->
                <div class="space-y-6">
                    <div class="border-b border-secondary-200 pb-4">
                        <h3 class="text-lg font-semibold text-secondary-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Configuración y Publicación
                        </h3>
                        <p class="text-secondary-600 text-sm mt-1">Opciones de visibilidad y publicación</p>
                    </div>

                    <!-- Status and Featured -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-secondary-700 mb-2">
                                Estado del Post
                            </label>
                            <select name="status" id="status"
                                    class="w-full px-4 py-3 border border-secondary-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>📝 Borrador</option>
                                <option value="pending" {{ old('status', $post->status) === 'pending' ? 'selected' : '' }}>⏳ Pendiente de Revisión</option>
                                @if(auth()->user()->canModerate())
                                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>✅ Publicado</option>
                                <option value="rejected" {{ old('status', $post->status) === 'rejected' ? 'selected' : '' }}>❌ Rechazado</option>
                                @endif
                            </select>
                        </div>

                        @if(auth()->user()->canModerate())
                        <div class="flex items-center">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 focus:ring-2">
                            </div>
                            <div class="ml-3">
                                <label for="is_featured" class="text-sm font-semibold text-secondary-700">
                                    ⭐ Post Destacado
                                </label>
                                <p class="text-xs text-secondary-500">Aparecerá en la sección destacada del blog</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Post Stats -->
                    <div class="bg-secondary-50 rounded-xl p-4">
                        <h4 class="text-sm font-semibold text-secondary-700 mb-3">Estadísticas del Post</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div>
                                <div class="text-lg font-bold text-secondary-900">{{ $post->views_count }}</div>
                                <div class="text-xs text-secondary-600">Vistas</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-secondary-900">{{ $post->comments()->count() }}</div>
                                <div class="text-xs text-secondary-600">Comentarios</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-secondary-900">{{ $post->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-secondary-600">Creado</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-secondary-900">{{ $post->updated_at->format('d M Y') }}</div>
                                <div class="text-xs text-secondary-600">Actualizado</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-secondary-200">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 text-white font-semibold rounded-2xl transition-all duration-200 shadow-medium hover:shadow-large transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Actualizar Post
                    </button>
                    <a href="{{ route('posts.show', $post) }}" class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-green-100 hover:bg-green-200 text-green-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Ver Post
                    </a>
                    <a href="{{ route('posts.index') }}" class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-secondary-100 hover:bg-secondary-200 text-secondary-700 font-semibold rounded-2xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#content', // Ajusta el selector
                license_key: 'gpl',
                height: 500,
                promotion:false,
                plugins: [
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
                ],
                toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat codesample ',
                skin: 'oxide',
                skin_url: '/node_modules/tinymce/skins/ui/oxide/',
                content_css: '/node_modules/tinymce/skins/content/default/content.min.css',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });

            // Handle form submission validation
            document.querySelector('form').addEventListener('submit', function(e) {
                // Sync TinyMCE content to textarea
                tinymce.triggerSave();

                // Check if content is empty
                const content = tinymce.get('content').getContent();
                if (!content.trim()) {
                    e.preventDefault();
                    alert('Por favor, ingresa el contenido del post.');
                    tinymce.get('content').focus();
                    return false;
                }
            });

            // Auto-generate slug from title
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .trim()
                    // Replace spaces with hyphens
                    .replace(/\s+/g, '-')
                    // Remove accents and special characters
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    // Remove non-alphanumeric characters except hyphens
                    .replace(/[^a-z0-9-]/g, '')
                    // Remove multiple consecutive hyphens
                    .replace(/-+/g, '-')
                    // Remove leading and trailing hyphens
                    .replace(/^-|-$/g, '');
            }

            // Auto-fill slug when title changes (only if slug wasn't manually modified)
            document.getElementById('title').addEventListener('input', function() {
                const slugField = document.getElementById('slug');
                const titleValue = this.value;

                // Only auto-generate if slug field is empty or was auto-generated
                if (!slugField.dataset.userModified) {
                    const generatedSlug = generateSlug(titleValue);
                    slugField.value = generatedSlug;
                }
            });

            // Mark slug as user-modified when manually edited
            document.getElementById('slug').addEventListener('input', function() {
                this.dataset.userModified = 'true';
            });
        });
</script>
@endpush
