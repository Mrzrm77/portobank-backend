<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class PortfolioItem extends Model
{
    protected $table = 'portfolio_items';

    protected $fillable = [
        'portfolio_id',
        'type',
        'title',
        'description',
        'year',
        'cover_url',
        'external_link',
        'tags',
        'gallery_images'
    ];

    protected $casts = [
        'tags' => 'array',
        'gallery_images' => 'array',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    // protected function coverUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value ? url(Storage::url($value)) : null,
    //     );
    // }

    // protected function galleryImages(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value ? array_map(fn($path) => url(Storage::url($path)), is_string($value) ? json_decode($value, true) ?: [] : $value) : [],
    //     );
    // }
}
