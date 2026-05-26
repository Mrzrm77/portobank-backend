<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $table = 'portfolio_items';

    protected $fillable = [
        'portfolio_id',
        'type',
        'title',
        'description',
        'cover_url',
        'external_link',
        'tags',
        'gallery_images'
    ];

    protected $casts = [
        'tags' => 'array',
        'gallery_images' => 'array'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
