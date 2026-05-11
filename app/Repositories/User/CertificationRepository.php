<?php

namespace App\Repositories\User;

use App\Models\Certification;
use App\Models\User;

class CertificationRepository
{
  public function getByUser( User $user){
    return $user->Certifications()->latest()->get();
  }

  public function create(User $user, array $data){
    return $user->Certifications()->create($data);
  }

  public function update(Certification $certification, array $data){
    $certification->update($data);

    return $certification->fresh();
  }

  public function delete(Certification $certification){
    return $certification->delete();
  }

  public function findById($user, $id){
    return $user->certifications()->findOrFail($id);
  }
}