<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User\SkillService;
use App\Http\Requests\User\Skill\StoreSkillRequest;

class SkillController extends Controller
{
    public function index(
        SkillService $skillService
    ) {
        return response()->json([
            'success' => true,
            'data' => $skillService->index(
                auth()->user()
            ),
        ]);
    }

    public function store(
        StoreSkillRequest $request,
        SkillService $skillService
    ) {
        $skill = $skillService->store(
            auth()->user(),
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Skill added successfully',
            'data' => $skill,
        ]);
    }

    public function destroy(
        SkillService $skillService,
        int $id
    ) {
        $skillService->destroy(
            auth()->user(),
            $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Skill removed successfully',
        ]);
    }
}