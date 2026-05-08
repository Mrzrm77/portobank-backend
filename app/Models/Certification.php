<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable =[
        'user_id',
        'title',
        'certificate_url',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
