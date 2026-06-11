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
            'viewer_id' => auth()->id(),
            'user_id' => $request->query('user_id'),
        ]);
        $profiles->transform(function($profile){
            if($profile->avatar_url){
                $profile->avatar_url = asset('storage/' . $profile->avatar_url);
            }
            return $profile;
        });
        return response()->json([
            'success' => true,
            'data' => $profiles,
        ]);
    }

    public function topLiked(Request $request, ProfileLikeService $service)
    {
        $limit = (int) $request->query('limit', 6);
        $viewerId = auth()->id();

        $profiles = $service->getTopLikedProfiles($limit, $viewerId);
        $profiles->transform(function($profile){
            if($profile->avatar_url){
                $profile->avatar_url = asset('storage/' . $profile->avatar_url);
            }
            return $profile;
        });

        return response()->json([
            'success' => true,
            'data' => $profiles
        ]);
    }
}
