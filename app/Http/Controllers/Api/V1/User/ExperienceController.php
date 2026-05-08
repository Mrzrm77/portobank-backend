<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Experience\StoreExperienceRequest;
use App\Http\Requests\User\Experience\UpdateExperienceRequest;
use App\Services\User\ExperienceService;

class ExperienceController extends Controller
{
    public function index(ExperienceService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->get(auth()->user())
        ]);
    }

    public function store(StoreExperienceRequest $request, ExperienceService $service)
    {
        $experience = $service->store(auth()->user(), $request->validated());

        return response()->json([
            'success' => true,
            'data' => $experience
        ]);
    }

    public function update($id, UpdateExperienceRequest $request, ExperienceService $service)
    {

        $experience = $service->update(auth()->user(), $id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => $experience
        ]);
    }

    public function destroy($id, ExperienceService $service)
    {
        $service->delete(auth()->user(), $id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }
}
