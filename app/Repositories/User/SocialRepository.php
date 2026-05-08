<?php

namespace App\Repositories\User;

use App\Models\SocialLink;
use App\Models\User;

class SocialRepository
{
  public function getByUser( User $user){
    return $user->socialLinks()->latest()->get();
  }

  public function create(User $user, array $data){
    return $user->socialLinks()->create($data);
  }

  public function update(SocialLink $social, array $data){
    $social->update($data);

    return $social;
  }

  public function delete(SocialLink $social){
    return $social->delete();
  }

  public function findById($id){
    return SocialLink::findOrFail($id);
  }
}