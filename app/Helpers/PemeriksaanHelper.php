<?php

namespace App\Helpers;

class PemeriksaanHelper
{
    /**
     * Cek apakah Barthel Index normal (independen: 100)
     */
    public static function isBarthelNormal(?int $value): bool
    {
        return $value !== null && $value === 100;
    }

    /**
     * Dapatkan kategori Barthel Index berdasarkan skor
     * @param int|null $value total skor Barthel
     * @return string|null kategori atau null jika nilai kosong
     */
    public static function getBarthelCategory(?int $value): ?string
    {
        if ($value === null) {
            return null;
        }
        if ($value >= 0 && $value <= 20) {
            return 'Ketergantungan total';
        }
        if ($value >= 21 && $value <= 60) {
            return 'Ketergantungan berat';
        }
        if ($value >= 61 && $value <= 90) {
            return 'Ketergantungan sedang';
        }
        if ($value === 100) {
            return 'Independen';
        }
        return 'Tidak diketahui';
    }

    /**
     * Cek apakah 2-Minute Step Test normal berdasarkan tabel umur dan jenis kelamin
     * @param int|null $value jumlah langkah
     * @param int $age umur pasien
     * @param string $gender jenis kelamin ('Laki-laki' atau 'Perempuan')
     */
    public static function isStepNormal(?int $value, int $age, string $gender): bool
    {
        if ($value === null) {
            return false;
        }
        // Lower bounds per age range and gender
        $ranges = [
            [60, 64, ['Perempuan' => 75, 'Laki-laki' => 87]],
            [65, 69, ['Perempuan' => 73, 'Laki-laki' => 86]],
            [70, 74, ['Perempuan' => 68, 'Laki-laki' => 80]],
            [75, 79, ['Perempuan' => 68, 'Laki-laki' => 73]],
            [80, 84, ['Perempuan' => 60, 'Laki-laki' => 71]],
            [85, 90, ['Perempuan' => 55, 'Laki-laki' => 59]],
            [90, 95, ['Perempuan' => 44, 'Laki-laki' => 52]],
        ];
        // Default gender key
        $key = (stripos($gender, 'laki') !== false) ? 'Laki-laki' : 'Perempuan';
        foreach ($ranges as list($min, $max, $bounds)) {
            if ($age >= $min && $age <= $max) {
                return $value >= ($bounds[$key] ?? 0);
            }
        }
        // Out of range: not normal
        return false;
    }

    /**
     * Cek apakah Single Leg Balance normal berdasarkan tabel usia dan kondisi mata
     * @param float|null $value waktu berdiri satu kaki (detik)
     * @param int|null $age umur pasien (tahun), opsional
     * @param bool $eyesClosed true jika mata tertutup, false untuk mata terbuka
     * @return bool
     */
    public static function isSingleLegNormal(?float $value, ?int $age = null, bool $eyesClosed = false): bool
    {
        if ($value === null) {
            return false;
        }
        
        // If age is not provided, use a simple threshold check
        if ($age === null) {
            // Default threshold for open eyes (in seconds)
            $defaultThreshold = $eyesClosed ? 5 : 30;
            return $value >= $defaultThreshold;
        }
        
        // Thresholds per age range for open and closed eyes
        $ranges = [
            [18, 39, ['open' => 44.7, 'closed' => 15.2]],
            [40, 49, ['open' => 41.9, 'closed' => 12.7]],
            [50, 59, ['open' => 41.2, 'closed' => 8.3]],
            [60, 69, ['open' => 32.1, 'closed' => 4.4]],
            [70, 79, ['open' => 21.5, 'closed' => 3.1]],
            [80, 99, ['open' => 9.4,  'closed' => 1.9]],
        ];
        
        $key = $eyesClosed ? 'closed' : 'open';
        
        foreach ($ranges as list($min, $max, $bounds)) {
            if ($age >= $min && $age <= $max) {
                // Use floor of threshold for comparison (e.g., 32.1 -> 32)
                $rawThreshold = $bounds[$key] ?? PHP_FLOAT_MAX;
                $threshold = (int) floor($rawThreshold);
                return $value >= $threshold;
            }
        }
        
        // Jika di luar rentang usia, gunakan threshold default
        $defaultThreshold = $eyesClosed ? 5 : 30;
        return $value >= $defaultThreshold;
    }

    /**
     * Cek apakah Five Times Sit to Stand normal berdasarkan tabel usia
     * menggunakan batas atas (mean + SD) per rentang usia
     * @param float|null $value waktu melakukan 5 kali duduk-berdiri (detik)
     * @param int|null $age umur pasien (tahun), opsional
     * @return bool
     */
    public static function isSitStandNormal(?float $value, ?int $age = null): bool
    {
        if ($value === null) {
            return false;
        }
        
        // Jika umur tidak disediakan, gunakan threshold sederhana
        if ($age === null) {
            // Default threshold 12 detik (bisa disesuaikan)
            return $value <= 12.0;
        }
        
        // Normal range per age (mean ± SD)
        $ranges = [
            [14, 19, 6.5, 1.2],
            [20, 29, 6.0, 1.4],
            [30, 39, 6.1, 1.4],
            [40, 49, 7.6, 1.8],
            [50, 59, 7.7, 2.6],
            [60, 69, 7.8, 2.4],
            [70, 79, 9.3, 2.1],
            [80, 85, 10.8, 2.6],
        ];
        
        foreach ($ranges as list($min, $max, $mean, $sd)) {
            if ($age >= $min && $age <= $max) {
                $lower = $mean - $sd;
                $upper = $mean + $sd;
                return ($value >= $lower && $value <= $upper);
            }
        }
        
        // Jika di luar rentang usia, gunakan threshold default
        return $value <= 12.0;
    }

    /**
     * Cek apakah Step Test normal
     * @param int|null $value jumlah langkah
     * @return bool
     */
    public static function isStepTestNormal($value): bool
    {
        // This is a simplified version - you might want to add more specific logic
        // based on your requirements. Currently, it just checks if the value is set.
        return $value !== null && $value > 0;
    }

    /**
     * Alias untuk isSitStandNormal()
     * @param float|null $value waktu melakukan 5 kali duduk-berdiri (detik)
     * @param int|null $age umur pasien (tahun), opsional
     * @return bool
     */
    public static function isSitToStandNormal(?float $value, ?int $age = null): bool
    {
        return self::isSitStandNormal($value, $age);
    }
}
