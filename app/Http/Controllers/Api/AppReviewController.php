<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppReview;
use Illuminate\Http\Request;

class AppReviewController extends Controller
{
    public function index(Request $request)
    {
        $limit = intval($request->query('limit', 20));
        $rating = intval($request->query('rating', 0));

        $query = AppReview::with(['user.profile'])
            ->orderByDesc('created_at');

        if ($rating > 3) {
            $query->where('rating', $rating);
        }

        $reviews = $query->limit(max($limit, 1))->get()->map(function ($review) {
            $review->profile = $review->user?->profile;
            unset($review->user);
            return $review;
        });

        $reviews->transform(function ($review) {
            if ($review->profile && $review->profile->avatar_url) {
                $review->profile->avatar_url = asset('storage/' . $review->profile->avatar_url);
            }
            return $review;
        });

        return response()->json([
            'success' => true,
            'data' => $reviews,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'review_text' => ['required', 'string', 'max:2000'],
        ]);

        $review = AppReview::create([
            'user_id' => $request->user()->id,
            'rating' => $data['rating'],
            'review_text' => $data['review_text'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $review,
        ], 201);
    }
}
