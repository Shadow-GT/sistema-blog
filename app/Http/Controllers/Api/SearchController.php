<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Get search suggestions.
     */
    public function suggestions(Request $request, SearchService $searchService)
    {
        $term = $request->get('q', '');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $suggestions = $searchService->getSearchSuggestions($term, 5);

        return response()->json($suggestions);
    }

    /**
     * Get popular search terms.
     */
    public function popular(SearchService $searchService)
    {
        $popularTerms = $searchService->getPopularSearchTerms(10);

        return response()->json($popularTerms);
    }
}
