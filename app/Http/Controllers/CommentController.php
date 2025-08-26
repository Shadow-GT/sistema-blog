<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Solo para administradores
        if (!auth()->user()->canModerate()) {
            abort(403);
        }

        $query = Comment::with(['post', 'user']);

        // Filtrar por estado si se especifica
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $comments = $query->latest()->paginate(20);

        return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();

        // Agregar información del usuario si está autenticado
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        } else {
            // Para usuarios invitados, capturar IP
            $data['author_ip'] = $request->ip();
        }

        $comment = Comment::create($data);

        return redirect()->back()->with('success', 'Comentario enviado. Será revisado antes de publicarse.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // Solo administradores pueden eliminar comentarios
        if (!auth()->user()->canModerate()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comentario eliminado exitosamente.');
    }

    /**
     * Approve a comment.
     */
    public function approve(Comment $comment)
    {
        if (!auth()->user()->canModerate()) {
            abort(403);
        }

        $comment->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Comentario aprobado.');
    }

    /**
     * Reject a comment.
     */
    public function reject(Comment $comment)
    {
        if (!auth()->user()->canModerate()) {
            abort(403);
        }

        $comment->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Comentario rechazado.');
    }
}
