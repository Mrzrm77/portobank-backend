<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\PortfolioItemController;
use App\Http\Controllers\Api\User\EducationController;
use App\Http\Controllers\Api\User\ExperienceController;
use App\Http\Controllers\Api\User\SocialLinkController;
use App\Http\Controllers\Api\User\CertificationController;
use App\Http\Controllers\Api\User\SkillController;
use App\Http\Controllers\Api\User\LikeController;
use App\Http\Controllers\Api\Public\PublicPortfolioController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\User\MessageController;
use App\Http\Controllers\Api\SkillCategoryController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Api\Admin\AdminLogController;

// Auth
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/forgot-password', ForgotPasswordController::class);
Route::post('/reset-password', ResetPasswordController::class);

// public
Route::get('/portfolio/{username}', [PublicPortfolioController::class, 'show']);
Route::get('/portfolio/{username}/projects', [PublicPortfolioController::class, 'projects']);
Route::get('/portfolio/{username}/projects/{projectId}', [PublicPortfolioController::class, 'projectDetail']);
Route::get('/portfolio/{username}/certificates', [PublicPortfolioController::class, 'certificates']);
Route::get('/portfolio/{username}/certificates/{certificateId}', [PublicPortfolioController::class, 'certificateDetail']);
Route::get('/portfolio/{username}/items', [PublicPortfolioController::class, 'portfolioItems']);
Route::get('/portfolio/{username}/items/{itemId}', [PublicPortfolioController::class, 'portfolioItemDetail']);
Route::get('/profiles/{username}/likes', [LikeController::class, 'stats']);
Route::get('/skill-categories', [SkillCategoryController::class, 'index']);
Route::get('/profiles', [SearchController::class, 'index']);
Route::get('/profiles/top-liked', [SearchController::class, 'topLiked']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);
});

Route::middleware('auth:sanctum', 'active.user')
    ->group(function () {
        // auth
        Route::get('/me', function () {
            return response()->json([
                'success' => true,
                'data' => auth()->user()->load('profile')
            ]);
        });
        // User 
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::patch('/profile/update', [ProfileController::class, 'update']);
        Route::patch('/profile/password', [ProfileController::class, 'changePassword']);
        Route::delete('/account', [ProfileController::class, 'destroy']);
        // upload avatar
        Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar']);
        Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar']);
        // user portfolio items
        Route::get('/portfolio-items', [PortfolioItemController::class, 'index']);
        Route::post('/portfolio-items', [PortfolioItemController::class, 'store']);
        Route::get('/portfolio-items/{id}', [PortfolioItemController::class, 'show']);
        Route::patch('/portfolio-items/{id}', [PortfolioItemController::class, 'update']);
        Route::delete('/portfolio-items/{id}', [PortfolioItemController::class, 'destroy']);
        // upload cover for portfolio item
        Route::post('/portfolio-items/{id}/covers', [PortfolioItemController::class, 'uploadCover']);
        Route::post('/portfolio-items/{id}/gallery', [PortfolioItemController::class, 'uploadGallery']);
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
        Route::post('/certifications/{id}/upload', [CertificationController::class, 'uploadImage']);

        // skill
        Route::get('/skills', [SkillController::class, 'index']);
        Route::post('/skills', [SkillController::class, 'store']);
        Route::delete('/skills/{id}', [SkillController::class, 'destroy']);

        // Likes
        Route::post('/profiles/{username}/like', [LikeController::class, 'like']);
        Route::delete('/profiles/{username}/like', [LikeController::class, 'unlike']);

        // Messages
        Route::get('/messages', [MessageController::class, 'conversations']);
        Route::get('/messages/{partnerId}', [MessageController::class, 'thread']);
        Route::post('/messages', [MessageController::class, 'send']);
        Route::post('/messages/{partnerId}/read', [MessageController::class, 'markThreadRead']);
        Route::post('/messages/{partnerId}/clear', [MessageController::class, 'clearConversation']);
        Route::patch('/messages/{id}', [MessageController::class, 'edit']);
        Route::delete('/messages/{id}/me', [MessageController::class, 'deleteForMe']);
        Route::delete('/messages/{id}/everyone', [MessageController::class, 'deleteForEveryone']);

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/read', [NotificationController::class, 'markAllRead']);

        // Skill categories
        Route::post('/skill-categories', [SkillCategoryController::class, 'store']);
        Route::patch('/skill-categories/{id}', [SkillCategoryController::class, 'update']);
        Route::delete('/skill-categories/{id}', [SkillCategoryController::class, 'destroy']);

        // Reports
        Route::post('/reports', [ReportController::class, 'store']);

        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

        // Admin
        Route::middleware('admin.user')->group(function () {
            Route::get('/admin/users', [AdminUserController::class, 'index']);
            Route::patch('/admin/users/{userId}', [AdminUserController::class, 'updateStatus']);
            Route::delete('/admin/users/{userId}', [AdminUserController::class, 'destroy']);
            Route::get('/admin/logs', [AdminLogController::class, 'index']);
            Route::get('/admin/reports', [ReportController::class, 'index']);
            Route::patch('/admin/reports/{id}/status', [ReportController::class, 'updateStatus']);
            Route::get('/admin/portfolios', [AdminPortfolioController::class, 'index']);
            Route::patch('/admin/portfolios/{portfolioId}', [AdminPortfolioController::class, 'update']);
            Route::delete('/admin/portfolios/{portfolioId}', [AdminPortfolioController::class, 'destroy']);
        });
    });