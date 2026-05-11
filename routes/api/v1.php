<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Controllers\Api\V1\User\ProjectController;
use App\Http\Controllers\Api\V1\User\EducationController;
use App\Http\Controllers\Api\V1\User\ExperienceController;
use App\Http\Controllers\Api\V1\User\SocialLinkController;
use App\Http\Controllers\Api\V1\User\CertificationController;
use App\Http\Controllers\Api\V1\Public\PublicPortfolioController;

Route::post(
    '/register',
    RegisterController::class
);

Route::post(
    '/login',
    LoginController::class
);

// public

Route::get(
    '/portfolio/{username}',
    [PublicPortfolioController::class, 'show']
);

Route::get(
    '/portfolio/{username}/projects',
    [PublicPortfolioController::class, 'projects']
);

Route::get(
    '/portfolio/{username}/projects/{projectId}',
    [PublicPortfolioController::class, 'projectDetail']
);

Route::middleware('auth:sanctum')->group(function (){
    Route::post(
            '/logout',
            LogoutController::class
        );
});

Route::middleware('auth:sanctum', 'active.user')
    ->group(function () {
        // auth

        Route::get('/me', function () {
            return response()->json([
                'success' => true,
                'data' => auth()->user()
            ]);
        });
        // User 
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::patch('/profile/update', [ProfileController::class, 'update']);
        // upload avatar
        Route::post('/profile/avatar',[ProfileController::class, 'uploadAvatar']);
        Route::delete('/profile/avatar',[ProfileController::class, 'deleteAvatar']);
        // user project
        Route::get('/projects',[ProjectController::class, 'index']);
        Route::post('/projects',[ProjectController::class, 'store']);
        Route::get('/projects/{id}',[ProjectController::class, 'show']);
        Route::patch('/projects/{id}',[ProjectController::class, 'update']);
        Route::delete('/projects/{id}',[ProjectController::class, 'destroy']);
        // upload cover project
        Route::post('/projects/{id}/covers',[ProjectController::class, 'uploadCover']);

        // project images
        Route::get('/projects/{id}/images',[ProjectController::class, 'images']);
        Route::patch('/projects/images/{imageId}',[ProjectController::class, 'updateImage']);
        Route::delete('/projects/images/{imageId}',[ProjectController::class, 'deleteImage']);
        // upload project images
        Route::post('/projects/{id}/images',[ProjectController::class, 'uploadImages']);
        // user education
        Route::get('/educations', [EducationController::class, 'index']);
        Route::post('/educations', [EducationController::class, 'store']);
        Route::patch('/educations/{id}', [EducationController::class, 'update']);
        Route::delete('/educations/{id}', [EducationController::class, 'destroy']);
        
        // user experience
        Route::get('/experiences', [ExperienceController::class, 'index']);
        Route::post('/experiences', [ExperienceController::class, 'store']);
        Route::patch('/experiences/{id}', [ExperienceController::class, 'update']);
        Route::delete('/experiences/{id}', [ExperienceController::class, 'destroy']);
        
        // user experience
        Route::get('/socials', [SocialLinkController::class, 'index']);
        Route::post('/socials', [SocialLinkController::class, 'store']);
        Route::patch('/socials/{id}', [SocialLinkController::class, 'update']);
        Route::delete('/socials/{id}', [SocialLinkController::class, 'destroy']);
        
        // user certification
        Route::get('/certifications', [CertificationController::class, 'index']);
        Route::post('/certifications', [CertificationController::class, 'store']);
        Route::patch('/certifications/{id}', [CertificationController::class, 'update']);
        Route::delete('/certifications/{id}', [CertificationController::class, 'destroy']);
        Route::post('/certifications/{id}/upload',[CertificationController::class, 'uploadImage']);

        

        // Admin

    });