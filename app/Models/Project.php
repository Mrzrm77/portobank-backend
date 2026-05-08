<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [

        'user_id',

        'title',

        'type',

        'description',

        'cover_image_url',

        'project_link',

        'start_date',

        'end_date'

    ];

    protected $casts = [

        'start_date' => 'date',

        'end_date' => 'date'

    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function images()
    {
        return $this->hasMany(
            ProjectImage::class
        );
    }

    public function likes()
    {
        return $this->hasMany(
            Like::class
        );
    }
}