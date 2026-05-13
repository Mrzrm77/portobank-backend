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
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['project_id']);

            $table->dropUnique(['project_id', 'user_id']);

            $table->dropColumn('project_id');

            $table->foreignId('profile_id')
                ->after('id')
                ->constrained()
                ->onDelete('cascade');

            $table->unique(['profile_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
             $table->dropForeign(['profile_id']);

            $table->dropUnique(['profile_id', 'user_id']);

            $table->dropColumn('profile_id');

            $table->foreignId('project_id')
                ->after('id')
                ->constrained()
                ->onDelete('cascade');

            $table->unique(['project_id', 'user_id']);
        });
    }
};
