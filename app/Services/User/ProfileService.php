<?php

namespace App\Services\User;
use Illuminate\Support\Facades\Storage;

class ProfileService {
  public function update($user, array $data){
      
    $profile = $user->profile;

    $profile->update($data);

    return $profile->fresh();

  }

  public function uploadAvatar($user, $file){
    $profile = $user->profile;

    if ($profile->avatar_url){
      storage::disk('public')->delete(
        $profile->avatar_url
      );
    }

    $path = $file->store(
      'avatars',
      'public'
    );

    $profile->update([
      'avatar_url'=>$path
    ]);

    return $profile;
  }

  public function deleteAvatar($user){
    $profile = $user->profile;

    if (!$profile || !$profile->avatar_url) {
        abort(404, "User doesn't have avatar");
    }
  
    storage::disk('public')->delete(
      $profile->avatar_url
    );

    $profile->update([
      'avatar_url'=> null
    ]);

    return response()->json([
      'message'=>'avatar deleted successfully'
    ]);
  }
}