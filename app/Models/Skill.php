<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'skill_name'
    ];

    public function profiles(){
        return $this->belongsToMany(
            Profile::class,'profile_skills'
        );
    }
}
