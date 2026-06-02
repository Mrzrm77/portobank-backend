<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function portfolio()
    {
        return $this->hasOne(
            Portfolio::class
        );
    }

    public function portfolioItems()
    {
        return $this->hasManyThrough(
            PortfolioItem::class,
            Portfolio::class,
            'user_id',
            'portfolio_id',
            'id',
            'id'
        );
    }

    public function educations()
    {
        return $this->hasMany(
            Education::class
        );
    }
    public function experiences()
    {
        return $this->hasMany(
            Experience::class
        );
    }
    public function socialLinks()
    {
        return $this->hasMany(
            SocialLink::class
        );
    }
    public function certifications()
    {
        return $this->hasMany(
            Certification::class
        );
    }
}
