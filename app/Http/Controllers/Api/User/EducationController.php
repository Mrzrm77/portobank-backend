<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Education\StoreEducationRequest;
use App\Http\Requests\User\Education\UpdateEducationRequest;
use App\Services\User\EducationService;

class EducationController extends Controller
{
    public function index(EducationService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->get(auth()->user())
        ]);
    }

    public function store(StoreEducationRequest $request, EducationService $service)
    {
        $education = $service->store(auth()->user(), $request->validated());

        return response()->json([
            'success' => true,
            'data' => $education
        ]);
    }

    public function update($id, UpdateEducationRequest $request, EducationService $service)
    {

        $education = $service->update(auth()->user(), $id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => $education
        ]);
    }

    public function destroy($id, EducationService $service)
    {
        $service->delete(auth()->user(), $id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }
}
