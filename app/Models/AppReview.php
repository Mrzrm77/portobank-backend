<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    protected $fillable = [
        'user_id',
        'rating',
        'review_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
