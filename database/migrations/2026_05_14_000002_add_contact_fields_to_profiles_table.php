<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('email_contact')->nullable()->after('profession');
            $table->string('phone')->nullable()->after('email_contact');
            $table->string('website_url')->nullable()->after('phone');
            $table->string('linkedin_url')->nullable()->after('website_url');
            $table->string('github_url')->nullable()->after('linkedin_url');
            $table->string('instagram_url')->nullable()->after('github_url');
            $table->string('twitter_url')->nullable()->after('instagram_url');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'email_contact',
                'phone',
                'website_url',
                'linkedin_url',
                'github_url',
                'instagram_url',
                'twitter_url',
            ]);
        });
    }
};
