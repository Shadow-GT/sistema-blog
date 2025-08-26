<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of posts for moderation.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'postType'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $posts = $query->paginate(15);

        // Get counts for status badges
        $statusCounts = [
            'all' => Post::count(),
            'pending' => Post::where('status', 'pending')->count(),
            'published' => Post::where('status', 'published')->count(),
            'draft' => Post::where('status', 'draft')->count(),
            'rejected' => Post::where('status', 'rejected')->count(),
        ];

        return view('admin.posts.index', compact('posts', 'statusCounts'));
    }

    /**
     * Approve a post.
     */
    public function approve(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Post aprobado y publicado correctamente.');
    }

    /**
     * Reject a post.
     */
    public function reject(Post $post)
    {
        $post->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Post rechazado correctamente.');
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post eliminado correctamente.');
    }
}
