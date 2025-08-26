<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use App\Services\SearchService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the blog homepage.
     */
    public function index(Request $request, SearchService $searchService)
    {
        $filters = $request->only(['search', 'category', 'type', 'author', 'sort', 'featured']);
        $posts = $searchService->searchPosts($filters)->paginate(12);

        $featuredPosts = Post::published()->featured()->latest('published_at')->take(3)->get();
        $categories = Category::active()->withCount(['posts as published_posts_count' => function ($query) {
            $query->where('status', 'published');
        }])->get();
        $postTypes = PostType::active()->withCount(['posts as published_posts_count' => function ($query) {
            $query->where('status', 'published');
        }])->get();

        return view('blog.index', compact('posts', 'featuredPosts', 'categories', 'postTypes'));
    }

    /**
     * Display a specific post.
     */
    public function show(Post $post, SearchService $searchService)
    {
        // Verificar que el post esté publicado
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->load(['category', 'postType', 'user', 'approvedComments.user', 'approvedComments.approvedReplies.user']);
        $post->incrementViews();

        // Posts relacionados usando el SearchService
        $relatedPosts = $searchService->getRelatedPosts($post, 4);

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by category.
     */
    public function category(Category $category)
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['postType', 'user'])
            ->latest('published_at')
            ->paginate(12);

        return view('blog.category', compact('category', 'posts'));
    }

    /**
     * Display posts by type.
     */
    public function postType(PostType $postType)
    {
        $posts = Post::published()
            ->where('post_type_id', $postType->id)
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(12);

        return view('blog.post-type', compact('postType', 'posts'));
    }
}
