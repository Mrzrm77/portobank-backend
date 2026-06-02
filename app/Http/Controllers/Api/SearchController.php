<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Search\ProfileSearchService;
use App\Services\User\ProfileLikeService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, ProfileSearchService $service)
    {
        $profiles = $service->search([
            'query' => $request->query('query'),
            'profession' => $request->query('profession'),
            'location' => $request->query('location'),
            'page' => (int) $request->query('page', 0),
            'limit' => (int) $request->query('limit', 12),
        ]);

        return response()->json([
            'success' => true,
            'data' => $profiles,
        ]);
    }

    public function topLiked(Request $request, ProfileLikeService $service)
    {
        $limit = (int) $request->query('limit', 6);

        return response()->json([
            'success' => true,
            'data' => $service->getTopLikedProfiles($limit),
        ]);
    }
}
