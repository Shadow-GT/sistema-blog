<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the moderation dashboard.
     */
    public function index()
    {
        $pendingPosts = Post::where('status', 'pending')
            ->with(['user', 'category', 'postType'])
            ->latest()
            ->take(10)
            ->get();

        $pendingComments = Comment::where('status', 'pending')
            ->with(['post', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'pending_posts' => Post::where('status', 'pending')->count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
        ];

        return view('moderation.index', compact('pendingPosts', 'pendingComments', 'stats'));
    }

    /**
     * Show pending posts for moderation.
     */
    public function posts()
    {
        $posts = Post::where('status', 'pending')
            ->with(['user', 'category', 'postType'])
            ->latest()
            ->paginate(15);

        return view('moderation.posts', compact('posts'));
    }

    /**
     * Approve a post.
     */
    public function approvePost(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Post aprobado y publicado exitosamente.');
    }

    /**
     * Reject a post.
     */
    public function rejectPost(Post $post)
    {
        $post->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Post rechazado.');
    }

    /**
     * Bulk approve posts.
     */
    public function bulkApprovePosts(Request $request)
    {
        $postIds = $request->input('post_ids', []);

        Post::whereIn('id', $postIds)
            ->where('status', 'pending')
            ->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

        return redirect()->back()->with('success', count($postIds) . ' posts aprobados exitosamente.');
    }

    /**
     * Bulk reject posts.
     */
    public function bulkRejectPosts(Request $request)
    {
        $postIds = $request->input('post_ids', []);

        Post::whereIn('id', $postIds)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return redirect()->back()->with('success', count($postIds) . ' posts rechazados.');
    }

    /**
     * Bulk approve comments.
     */
    public function bulkApproveComments(Request $request)
    {
        $commentIds = $request->input('comment_ids', []);

        Comment::whereIn('id', $commentIds)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);

        return redirect()->back()->with('success', count($commentIds) . ' comentarios aprobados exitosamente.');
    }

    /**
     * Bulk reject comments.
     */
    public function bulkRejectComments(Request $request)
    {
        $commentIds = $request->input('comment_ids', []);

        Comment::whereIn('id', $commentIds)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return redirect()->back()->with('success', count($commentIds) . ' comentarios rechazados.');
    }
}
