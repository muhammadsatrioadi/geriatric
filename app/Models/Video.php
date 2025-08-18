<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'jenis',
        'klasifikasi',
        'category_type',
        'test_type',
        'level',
        'user_id',
        'pasien_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that uploaded the video.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the patient associated with the video (for khusus videos).
     */
    public function pasien()
    {
        return $this->belongsTo(pasien::class);
    }

    /**
     * Scope for active videos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for global videos
     */
    public function scopeGlobal($query)
    {
        return $query->where('jenis', 'global');
    }

    /**
     * Scope for khusus videos
     */
    public function scopeKhusus($query)
    {
        return $query->where('jenis', 'khusus');
    }

    /**
     * Scope for overall category videos
     */
    public function scopeOverall($query)
    {
        return $query->where('category_type', 'overall');
    }

    /**
     * Scope for per-test category videos
     */
    public function scopePerTest($query)
    {
        return $query->where('category_type', 'per_test');
    }

    /**
     * Scope for self-assessment category videos
     */
    public function scopeSelfAssessment($query)
    {
        return $query->where('category_type', 'self_assessment');
    }

    /**
     * Scope for specific test type
     */
    public function scopeTestType($query, $testType)
    {
        return $query->where('test_type', $testType);
    }

    /**
     * Scope for specific level
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Get video URL for public access
     */
    public function getVideoUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get test type label
     */
    public function getTestTypeLabelAttribute()
    {
        $labels = [
            'barthel' => 'Barthel Index',
            'two_minute' => '2-Minute Step Test',
            'single_leg' => 'Single Leg Balance',
            'five_stand' => 'Five Times Sit to Stand',
        ];

        return $labels[$this->test_type] ?? $this->test_type;
    }

    /**
     * Get level label
     */
    public function getLevelLabelAttribute()
    {
        $labels = [
            'normal' => 'Normal',
            'ringan' => 'Ringan',
            'berat' => 'Berat',
        ];

        return $labels[$this->level] ?? $this->level;
    }

    /**
     * Get category type label
     */
    public function getCategoryTypeLabelAttribute()
    {
        $labels = [
            'overall' => 'Keseluruhan',
            'per_test' => 'Per Tes',
            'self_assessment' => 'Self Assessment',
        ];

        return $labels[$this->category_type] ?? $this->category_type;
    }
}
