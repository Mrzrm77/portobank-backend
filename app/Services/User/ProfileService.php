<?php

namespace App\Services\User;
use Illuminate\Support\Facades\Storage;

class ProfileService {
    public function getEditData($user)
    {
        $profile = $user->profile;
        if ($profile && $profile->avatar_url) {
            $profile->avatar_url = asset('storage/' . $profile->avatar_url);
        }
        
        $educations = collect($user->educations);
        $experiences = collect($user->experiences);
        $portfolioItems = collect($user->portfolioItems);
        $certifications = collect($user->certifications);
        $skills = $profile ? collect($profile->skills) : collect();

        // format urls
        $certifications->transform(function ($cert) {
            if ($cert->certificate_url && !str_starts_with($cert->certificate_url, 'http')) {
                $cert->certificate_url = asset('storage/' . $cert->certificate_url);
            }
            return $cert;
        });

        $portfolioItems->transform(function ($item) {
            if ($item->cover_url && !str_starts_with($item->cover_url, 'http')) {
                $item->cover_url = asset('storage/' . $item->cover_url);
            }
            if (!empty($item->gallery_images) && is_array($item->gallery_images)) {
                $item->gallery_images = array_map(function ($image) {
                    return !str_starts_with($image, 'http') ? asset('storage/' . $image) : $image;
                }, $item->gallery_images);
            }
            return $item;
        });

        return [
            'profile' => $profile,
            'educations' => $educations,
            'experiences' => $experiences,
            'portfolioItems' => $portfolioItems,
            'certifications' => $certifications,
            'skills' => $skills
        ];
    }

  public function update($user, array $data){
      
    $profile = $user->profile;

    $profile->update($data);

    return $profile->fresh();

  }

  public function changePassword($user, string $password)
  {
      $user->password = $password;
      $user->save();

      return $user;
  }

  public function deleteAccount($user)
  {
      $profile = $user->profile;

      if ($profile && $profile->avatar_url) {
          Storage::disk('public')->delete($profile->avatar_url);
      }

      $user->tokens()->delete();
      $user->delete();

      return true;
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