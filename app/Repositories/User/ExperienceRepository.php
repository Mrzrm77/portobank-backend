<?php

namespace App\Repositories\User;

use App\Models\Experience;
use App\Models\User;

class ExperienceRepository
{
  public function getByUser( User $user){
    return $user->experiences()->latest()->get();
  }

  public function create(User $user, array $data){
    return $user->experiences()->create($data);
  }

  public function update(Experience $experience, array $data){
    $experience->update($data);

    return $experience;
  }

  public function delete(Experience $experience){
    return $experience->delete();
  }

  public function findById($id){
    return Experience::findOrFail($id);
  }
}