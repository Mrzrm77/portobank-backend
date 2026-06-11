<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'skill_name',
        'level',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(SkillCategory::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(
            Profile::class,'profile_skills'
        );
    }
}
