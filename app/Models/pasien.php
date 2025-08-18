<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'tekanan_darah',
        'kategori_stroke',
        'riwayat_jatuh',
        'barthel_index',
        'step_test',
        'single_leg_open',
        'single_leg_closed',
        'sit_to_stand',
        'foundation_id',
        'owned_by',
        'public_visible',
    ];
    /**
     * Cast attributes to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'barthel_index' => 'integer',
        'step_test' => 'integer',
        'single_leg_open' => 'integer',
        'single_leg_closed' => 'integer',
        'sit_to_stand' => 'float',
        'public_visible' => 'boolean',
    ];

    /**
     * Get the foundation that owns this patient
     */
    public function foundation()
    {
        return $this->belongsTo(Foundation::class);
    }

    /**
     * Get the user who owns this patient (admin or foundation user)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owned_by');
    }

    /**
     * Scope for public visible patients
     */
    public function scopePublicVisible($query)
    {
        return $query->where('public_visible', true);
    }

    /**
     * Scope for patients owned by specific foundation
     */
    public function scopeByFoundation($query, $foundationId)
    {
        return $query->where('foundation_id', $foundationId);
    }

    /**
     * Scope for patients owned by specific user
     */
    public function scopeByOwner($query, $userId)
    {
        return $query->where('owned_by', $userId);
    }

    /**
     * Get classification based on functional tests.
     */
    public function getClassificationAttribute(): string
    {
        $age = $this->tanggal_lahir->age;
        $gender = $this->jenis_kelamin;
        $normalCount = 0;
        // Cek normalitas tiap tes menggunakan helper dengan parameter baru
        if (\App\Helpers\PemeriksaanHelper::isBarthelNormal($this->barthel_index)) {
            $normalCount++;
        }
        if (\App\Helpers\PemeriksaanHelper::isStepNormal($this->step_test, $age, $gender)) {
            $normalCount++;
        }
        // Asumsikan single_leg_open menyimpan nilai open-eye
        if (\App\Helpers\PemeriksaanHelper::isSingleLegNormal($this->single_leg_open, $age, false)) {
            $normalCount++;
        }
        if (\App\Helpers\PemeriksaanHelper::isSitStandNormal($this->sit_to_stand, $age)) {
            $normalCount++;
        }
        // Tentukan level klasifikasi
        if ($normalCount >= 3) {
            return 'Tinggi';
        } elseif ($normalCount === 2) {
            return 'Sedang';
        }
        return 'Rendah';
    }

    /**
     * Get videos associated with this patient.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Get global videos based on patient classification.
     */
    public function getGlobalVideosAttribute()
    {
        return \App\Models\Video::where('jenis', 'global')
            ->where('klasifikasi', $this->classification)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Get overall category video for this patient
     */
    public function getOverallVideo()
    {
        try {
            // First check for patient-specific video
            $patientVideo = $this->videos()
                ->where('jenis', 'khusus')
                ->where('category_type', 'overall')
                ->where('is_active', true)
                ->first();

            if ($patientVideo) {
                return $patientVideo;
            }

            // If no patient-specific video, get global video
            $classification = $this->getClassificationForVideo();
            $globalVideo = \App\Models\Video::where('jenis', 'global')
                ->where('category_type', 'overall')
                ->where('klasifikasi', $classification)
                ->where('is_active', true)
                ->first();

            return $globalVideo;
    } catch (\Exception $e) {
            // Fallback to old method if category_type doesn't exist
            return \App\Models\Video::where('jenis', 'global')
                ->where('klasifikasi', $this->classification)
                ->where('is_active', true)
                ->first();
        }
    }

    /**
     * Get per-test videos for this patient
     */
    public function getPerTestVideos()
    {
        try {
            $videos = [];
            $testTypes = ['barthel', 'two_minute', 'single_leg', 'five_stand'];

            foreach ($testTypes as $testType) {
                // First check for patient-specific video
                $patientVideo = $this->videos()
                    ->where('jenis', 'khusus')
                    ->where('category_type', 'per_test')
                    ->where('test_type', $testType)
                    ->where('is_active', true)
                    ->first();

                if ($patientVideo) {
                    $videos[$testType] = $patientVideo;
                } else {
                    // If no patient-specific video, get global video
                    $level = $this->getTestLevel($testType);
                    $globalVideo = \App\Models\Video::where('jenis', 'global')
                        ->where('category_type', 'per_test')
                        ->where('test_type', $testType)
                        ->where('level', $level)
                        ->where('is_active', true)
                        ->first();

                    $videos[$testType] = $globalVideo;
                }
            }

            return $videos;
        } catch (\Exception $e) {
            // Fallback: return empty array if category_type doesn't exist
            return [];
        }
    }

    /**
     * Get classification for video mapping (Tinggi -> ringan, Sedang -> sedang, Rendah -> berat)
     */
    private function getClassificationForVideo(): string
    {
        $classification = $this->classification;
        
        $mapping = [
            'Tinggi' => 'ringan',
            'Sedang' => 'sedang', 
            'Rendah' => 'berat'
        ];

        return $mapping[$classification] ?? 'sedang';
    }

    /**
     * Get test level based on patient's test results
     */
    private function getTestLevel(string $testType): string
    {
        $age = ($this->tanggal_lahir && method_exists($this->tanggal_lahir, 'age')) ? $this->tanggal_lahir->age : null;
        $gender = $this->jenis_kelamin;

        switch ($testType) {
            case 'barthel':
                if ($this->barthel_index === null) {
                    return 'berat';
                }
                return \App\Helpers\PemeriksaanHelper::isBarthelNormal($this->barthel_index) ? 'normal' : 'berat';
            
            case 'two_minute':
                if ($this->step_test === null || $age === null || $gender === null) {
                    return 'berat';
                }
                return \App\Helpers\PemeriksaanHelper::isStepNormal($this->step_test, $age, $gender) ? 'normal' : 'berat';
            
            case 'single_leg':
                if ($this->single_leg_open === null || $age === null) {
                    return 'berat';
                }
                return \App\Helpers\PemeriksaanHelper::isSingleLegNormal($this->single_leg_open, $age, false) ? 'normal' : 'berat';
            
            case 'five_stand':
                if ($this->sit_to_stand === null || $age === null) {
                    return 'berat';
                }
                return \App\Helpers\PemeriksaanHelper::isSitStandNormal($this->sit_to_stand, $age) ? 'normal' : 'berat';
            
            default:
                return 'normal';
        }
    }
}
