<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            
            if (!Schema::hasColumn('skills', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->constrained('skill_categories')
                    ->nullOnDelete()
                    ->after('skill_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            if (Schema::hasColumn('skills', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }
            
            // Note: cannot fully restore user_id relationship
        });
    }
};
