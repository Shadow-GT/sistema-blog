<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $query = Post::with(['category', 'postType', 'user']);

        // Si no es admin, solo mostrar sus propios posts
        if (!$user->canModerate()) {
            $query->where('user_id', $user->id);
        }

        $posts = $query->latest()->paginate(15);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $postTypes = PostType::active()->get();

        return view('posts.create', compact('categories', 'postTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Generar slug si no se proporciona
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Sanitizar contenido HTML
        $data['content'] = $this->sanitizeHtmlContent($data['content']);

        // Manejar imagen destacada
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        // Si el usuario no es admin, establecer estado como pendiente
        if (!auth()->user()->canModerate() && $data['status'] === 'published') {
            $data['status'] = 'pending';
        }

        $post = Post::create($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['category', 'postType', 'user', 'approvedComments.user']);

        // Verificar permisos
        if (!auth()->user()->canModerate() && $post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Verificar permisos
        if (!auth()->user()->canModerate() && $post->user_id !== auth()->id()) {
            abort(403);
        }

        // Los autores no pueden editar posts aprobados (solo admins pueden)
        if (!auth()->user()->canModerate() && $post->status === 'published') {
            return redirect()->route('posts.show', $post)
                ->withErrors(['edit' => 'No puedes editar un post que ya ha sido aprobado y publicado. Solo los administradores pueden modificar posts publicados.']);
        }

        $categories = Category::active()->get();
        $postTypes = PostType::active()->get();

        return view('posts.edit', compact('post', 'categories', 'postTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Los autores no pueden editar posts aprobados (solo admins pueden)
        if (!auth()->user()->canModerate() && $post->status === 'published') {
            return redirect()->route('posts.show', $post)
                ->withErrors(['edit' => 'No puedes editar un post que ya ha sido aprobado y publicado. Solo los administradores pueden modificar posts publicados.']);
        }

        $data = $request->validated();

        // Generar slug si no se proporciona
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Sanitizar contenido HTML
        $data['content'] = $this->sanitizeHtmlContent($data['content']);

        // Manejar imagen destacada
        if ($request->hasFile('featured_image')) {
            // Eliminar imagen anterior si existe
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        // Si el usuario no es admin y cambia a publicado, establecer como pendiente
        if (!auth()->user()->canModerate() && $data['status'] === 'published' && $post->status !== 'published') {
            $data['status'] = 'pending';
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Verificar permisos
        if (!auth()->user()->canModerate() && $post->user_id !== auth()->id()) {
            abort(403);
        }

        // Eliminar imagen si existe
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post eliminado exitosamente.');
    }

    /**
     * Upload image for TinyMCE editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('posts/images', $filename, 'public');

            return response()->json([
                'location' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Sanitize HTML content to prevent XSS attacks.
     * Basic implementation - for production use HTMLPurifier or similar.
     */
    private function sanitizeHtmlContent($content)
    {
        // For now, we'll allow the content as-is since TinyMCE provides some protection
        // In production, you should use HTMLPurifier or similar library

        // Remove potentially dangerous tags
        $content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $content);
        $content = preg_replace('/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi', '', $content);
        $content = preg_replace('/on\w+="[^"]*"/i', '', $content);
        $content = preg_replace('/javascript:/i', '', $content);

        return $content;
    }
}
