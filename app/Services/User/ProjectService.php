<?php

namespace App\Services\User;

use App\Repositories\User\ProjectRepository;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    protected $projectRepository;

    public function __construct(
        ProjectRepository
        $projectRepository
    ) {

        $this->projectRepository =
            $projectRepository;

    }

    public function index(
        $user
    ) {

        return $this->projectRepository
            ->getUserProjects($user);

    }

    public function create(
        $user,
        array $data
    ) {

        return $this->projectRepository
            ->create(
                $user,
                $data
            );

    }

    public function show(
        $user,
        int $id
    ) {

        return $this->projectRepository
            ->findUserProject(
                $user,
                $id
            );

    }

    public function update(
        $user,
        int $id,
        array $data
    ) {

        $project =
            $this->projectRepository
                ->findUserProject(
                    $user,
                    $id
                );

        return $this->projectRepository
            ->update(
                $project,
                $data
            );

    }

    public function delete(
        $user,
        int $id
    ) {
        $project = $this->projectRepository->findUserProject($user, $id);

        if ($project->cover_image_url){
            Storage::disk('public')->delete($project->cover_image_url);
        }

        $project =
            $this->projectRepository
                ->findUserProject(
                    $user,
                    $id
                );

        return $this->projectRepository
            ->delete($project);

    }

    public function uploadCover($user, int $projectId, $file){
        $project = $this->projectRepository->findUserProject($user, $projectId);

        if ($project->cover_image_url){
            Storage::disk('public')->delete($project->cover_image_url);
        }

        $path = $file->store(
            'project-covers',
            'public'
        );

        return $this->projectRepository->update($project,[
            'cover_image_url'=>$path
        ]);
    }

    public function uploadProjectImages(
      $user,
      int $projectId,
      $file,
      ?string $caption = null
    ){
      $project = $this->projectRepository->findUserProject($user, $projectId);
      $path = $file->store(
          'project-images',
          'public'
      );
      return $this->projectRepository->createProjectImage([
          'project_id'=>$projectId,
          'image_url'=>$path,
          'caption'=>$caption
      ]);
    }

    public function getProjectImages(
        $user,
        int $projectId
    ) {
        $project = $this->projectRepository
            ->findUserProject(
                $user,
                $projectId
            );

        return $this->projectRepository
            ->getProjectImages($project);
    }

    public function updateProjectImage(
        $user,
        int $imageId,
        array $data,
        $file = null
    ) {

        $image = $this->projectRepository
            ->findProjectImage(
                $imageId
            );

        // ownership check
        if (
            $image->project->user_id !== $user->id
        ) {
            abort(403);
        }
        // update image file
        if ($file) {
            // hapus file lama
            Storage::disk('public')
                ->delete($image->image_url);

            $path = $file->store(
                'project-images',
                'public'
            );

            $data['image_url'] = $path;
        }

        return $this->projectRepository
            ->updateProjectImage(
                $image,
                $data
            );
    }

    public function deleteProjectImage(
        $user,
        int $imageId
    ) {

        $image = $this->projectRepository
            ->findProjectImage(
                $imageId
            );

        // ownership check
        if (
            $image->project->user_id !== $user->id
        ) {
            abort(403);
        }

        // delete file
        Storage::disk('public')
            ->delete($image->image_url);

        return $this->projectRepository
            ->deleteProjectImage($image);
    }

}