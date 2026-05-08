<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\SocialLink\StoreSocialRequest;
use App\Http\Requests\User\SocialLink\UpdateSocialRequest;
use App\Services\User\SocialService;

class SocialLinkController extends Controller
{
    public function index(SocialService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->get(auth()->user())
        ]);
    }

    public function store(StoreSocialRequest $request, SocialService $service)
    {
        $social = $service->store(auth()->user(), $request->validated());

        return response()->json([
            'success' => true,
            'data' => $social
        ]);
    }

    public function update($id, UpdateSocialRequest $request, SocialService $service)
    {

        $social = $service->update(auth()->user(), $id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => $social
        ]);
    }

    public function destroy($id, SocialService $service)
    {
        $service->delete(auth()->user(), $id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }
}
