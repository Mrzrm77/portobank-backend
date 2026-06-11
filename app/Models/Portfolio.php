<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'view_count'
    ];

    protected $casts = [
        'view_count' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PortfolioItem::class);
    }
}
