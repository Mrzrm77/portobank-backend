<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->index(['is_public', 'is_active', 'profession', 'location'], 'profiles_public_active_profession_location_index');
            $table->index('created_at');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->index('skill_name', 'skills_skill_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropIndex('profiles_public_active_profession_location_index');
            $table->dropIndex(['created_at']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex('skills_skill_name_index');
        });
    }
};
