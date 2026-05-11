<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Project\StoreProjectRequest;
use App\Http\Requests\User\Project\UpdateProjectRequest;
use App\Http\Requests\User\Project\UploadProjectCoverRequest;
use App\Http\Requests\User\project\UploadProjectImagesRequest;
use App\Http\Requests\User\project\UpdateProjectImageRequest;

use App\Services\User\ProjectService;

class ProjectController
    extends Controller
{
    public function index(
        ProjectService $service
    ) {

        return response()->json([

            'success' => true,

            'data' =>

                $service->index(
                    auth()->user()
                )

        ]);

    }

    public function store(

        StoreProjectRequest $request,

        ProjectService $service

    ) {

        $project =
            $service->create(

                auth()->user(),

                $request->validated()

            );

        return response()->json([

            'success' => true,

            'message' =>

                'Project created',

            'data' => $project

        ], 201);

    }

    public function show(
    int $id,
    ProjectService $service
    ) {

        $project = $service->show(
            auth()->user(),
            $id
        );

        $project->load('images');

        return response()->json([

            'success' => true,

            'data' => $project

        ]);

    }

    public function update(

        int $id,

        UpdateProjectRequest
        $request,

        ProjectService $service

    ) {

        $project =
            $service->update(

                auth()->user(),

                $id,

                $request->validated()

            );

        return response()->json([

            'success' => true,

            'message' =>

                'Project updated',

            'data' => $project

        ]);

    }

    public function destroy(
        int $id,
        ProjectService $service
    ) {

        $service->delete(
            auth()->user(),
            $id
        );

        return response()->json([

            'success' => true,

            'message' =>
                'Project deleted'

        ]);

    }

    public function uploadCover(
        UploadProjectCoverRequest $request,
        ProjectService $projectService,
        int $id
    ) {
    
        $project = $projectService->uploadCover(
            auth()->user(),
            $id,
            $request->file('cover')
        );
    
        return response()->json([
            'success' => true,
            'message' => 'Project cover uploaded',
            'data' => $project
        ]);
    }

    public function uploadImages(
        UploadProjectImagesRequest $request,
        ProjectService $projectService,
        int $id
    ){
        $image = $projectService->uploadProjectImages(
            auth()->user(),
            $id,
            $request->file('image'),
            $request->caption
        );

        return response()->json([
            'success'=>true,
            'message'=>'Images Uploaded',
            'data'=>$image
        ]);
    }

    public function images(
    ProjectService $projectService,
    int $id
    ) {

        $images = $projectService
            ->getProjectImages(
                auth()->user(),
                $id
            );

        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }

    public function updateImage(
        UpdateProjectImageRequest $request,
        ProjectService $projectService,
        int $imageId
    ) {

        $data = $request->validated();
        $image = $projectService
            ->updateProjectImage(
                auth()->user(),
                $imageId,
                $data,
                $request->file('image')
            );

        return response()->json([
            'success' => true,
            'message' => 'Image updated',
            'data' => $image
        ]);
    }

    public function deleteImage(
        ProjectService $projectService,
        int $imageId
    ) {
        $projectService->deleteProjectImage(
            auth()->user(),
            $imageId
        );
        return response()->json([
            'success' => true,
            'message' => 'Image deleted'
        ]);
    }
}