<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillCategory\StoreSkillCategoryRequest;
use App\Http\Requests\SkillCategory\UpdateSkillCategoryRequest;
use App\Services\SkillCategory\SkillCategoryService;

class SkillCategoryController extends Controller
{
    public function index(SkillCategoryService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->listCategories(),
        ]);
    }

    public function store(
        StoreSkillCategoryRequest $request,
        SkillCategoryService $service
    ) {
        $category = $service->createCategory(array_merge(
            $request->validated(),
            ['created_by' => auth()->user()->id]
        ));

        return response()->json([
            'success' => true,
            'data' => $category,
        ], 201);
    }

    public function update(
        int $id,
        UpdateSkillCategoryRequest $request,
        SkillCategoryService $service
    ) {
        $category = $service->updateCategory($id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    public function destroy(int $id, SkillCategoryService $service)
    {
        $service->deleteCategory($id);

        return response()->json([
            'success' => true,
            'message' => 'Skill category deleted.',
        ]);
    }
}
