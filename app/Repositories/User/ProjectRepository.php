<?php

namespace App\Repositories\User;

use App\Models\Project;
use App\Models\ProjectImage;

class ProjectRepository
{
    public function getUserProjects(
        $user
    ) {

        return $user->projects()
            ->latest()
            ->get();

    }

    public function create(
        $user,
        array $data
    ) {

        return $user->projects()
            ->create($data);

    }

    public function update(
        $project,
        array $data
    ) {

        $project->update($data);

        return $project->fresh();

    }

    public function delete(
        $project
    ) {


        return $project->delete();

    }

    public function findUserProject(
        $user,
        int $projectId
    ){
        return $user->projects()->findOrFail($projectId);
    }

    public function createProjectImage(
        array $data
    ){
        return ProjectImage::create($data);
    }
    public function getProjectImages(
    $project
    ) {
        return $project->images()
            ->latest()
            ->get();
    }

    public function findProjectImage(
    int $imageId
    ) {

        return ProjectImage::findOrFail(
            $imageId
        );
    }

    public function updateProjectImage(
        $image,
        array $data
    ) {
        $image->update($data);
        return $image;
    }

    public function deleteProjectImage(
    $image
    ) {
        return $image->delete();
    }

}