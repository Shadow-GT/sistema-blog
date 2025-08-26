<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    /**
     * Search posts with advanced filtering.
     */
    public function searchPosts(array $filters = []): Builder
    {
        $query = Post::published()->with(['category', 'postType', 'user']);

        // Text search
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                      $categoryQuery->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('postType', function ($typeQuery) use ($searchTerm) {
                      $typeQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        // Post type filter
        if (!empty($filters['type'])) {
            $query->whereHas('postType', function ($q) use ($filters) {
                $q->where('slug', $filters['type']);
            });
        }

        // Author filter
        if (!empty($filters['author'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['author']}%");
            });
        }

        // Date range filter
        if (!empty($filters['date_from'])) {
            $query->where('published_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('published_at', '<=', $filters['date_to']);
        }

        // Featured filter
        if (!empty($filters['featured'])) {
            $query->where('is_featured', true);
        }

        // Sort options
        $sortBy = $filters['sort'] ?? 'latest';
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        return $query;
    }

    /**
     * Get search suggestions based on partial input.
     */
    public function getSearchSuggestions(string $term, int $limit = 5): array
    {
        $suggestions = [];

        // Get post titles that match
        $postTitles = Post::published()
            ->where('title', 'like', "%{$term}%")
            ->limit($limit)
            ->pluck('title')
            ->toArray();

        $suggestions = array_merge($suggestions, $postTitles);

        // Get category names that match
        $categoryNames = \App\Models\Category::active()
            ->where('name', 'like', "%{$term}%")
            ->limit($limit)
            ->pluck('name')
            ->toArray();

        $suggestions = array_merge($suggestions, $categoryNames);

        // Remove duplicates and limit results
        $suggestions = array_unique($suggestions);
        return array_slice($suggestions, 0, $limit);
    }

    /**
     * Get popular search terms (this could be enhanced with actual tracking).
     */
    public function getPopularSearchTerms(int $limit = 10): array
    {
        // For now, return some predefined popular terms
        // In a real application, you would track search queries in a database
        return [
            'Laravel',
            'PHP',
            'JavaScript',
            'React',
            'Vue.js',
            'Docker',
            'API',
            'Database',
            'Security',
            'Performance'
        ];
    }

    /**
     * Get related posts based on a given post.
     */
    public function getRelatedPosts(Post $post, int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        return Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('category_id', $post->category_id)
                      ->orWhere('post_type_id', $post->post_type_id);
            })
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
