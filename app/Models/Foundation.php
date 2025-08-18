<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Foundation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot method to automatically generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($foundation) {
            if (empty($foundation->slug)) {
                $foundation->slug = Str::slug($foundation->name);
            }
        });
    }

    /**
     * Get the users that belong to this foundation
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the patients that belong to this foundation
     */
    public function patients()
    {
        return $this->hasMany(pasien::class);
    }

    /**
     * Get the user who created this foundation
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for active foundations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
