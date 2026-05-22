<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use App\Services\User\ProfileService;

class ProfileController extends Controller
{
    public function show(){
        return response()->json([
            'success' => true,
            'data'=>auth()->user()->load('profile')
        ]);
    }

    public function update(
        UpdateProfileRequest $request,
        ProfileService $profileService
    ){
        $profile = $profileService->update(
            auth()->user(),
            $request->validated()
        );

        return response()->json([
            'success'=> true,
            'message'=>'Profile Updated',
            'data'=>$profile
        ]);
    }

    public function changePassword(
        ChangePasswordRequest $request,
        ProfileService $profileService
    ) {
        $profileService->changePassword(
            auth()->user(),
            $request->validated()['password']
        );

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    public function destroy(
        ProfileService $profileService
    ) {
        $profileService->deleteAccount(auth()->user());

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully.',
        ]);
    }

    // upload avatar

    public function uploadAvatar(
        UploadAvatarRequest $request,
        ProfileService $profileService
    ){
        $profile = $profileService->uploadAvatar(
            auth()->user(),
            $request->file('avatar')
        );

        return response()->json([
            'success'=> true,
            'message'=>'Avatar uploaded',
            'data'=> $profile
        ]);
    }

    public function deleteAvatar(
        ProfileService $profileService
    ){
        $profile = $profileService->deleteAvatar(
            auth()->user()
        );

        return response()->json([
            'success'=> true,
            'message'=>'avatar has been deleted'
        ]);
    }

}
