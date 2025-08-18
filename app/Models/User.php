<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'password',
        'profile_photo_path',
        'role',
        'foundation_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the foundation that the user belongs to
     */
    public function foundation()
    {
        return $this->belongsTo(Foundation::class);
    }

    /**
     * Get the patients that belong to this user (if admin)
     */
    public function patients()
    {
        return $this->hasMany(pasien::class, 'owned_by', 'id');
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin()
    {
        return $this->role === 0;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 1;
    }

    /**
     * Check if user is foundation user
     */
    public function isFoundation()
    {
        return $this->role === 2;
    }
}
