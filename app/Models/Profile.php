<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'full_name',
        'bio',
        'avatar_url',
        'location',
        'profession',
        'is_active',
        'is_public'
    ];

    protected $casts = [
        'is_active'=> 'boolean',
        'is_public'=> 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'profile_skills');
    }

    public function likes()
    {
        return $this->hasManyThrough(
            Like::class,
            Portfolio::class,
            'user_id',
            'portfolio_id',
            'user_id',
            'id'
        );
    }
}
