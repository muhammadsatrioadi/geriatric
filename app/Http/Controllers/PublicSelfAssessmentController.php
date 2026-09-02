<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Helpers\PemeriksaanHelper;

class PublicSelfAssessmentController extends Controller
{
    public function index()
    {
        $formVideos = $this->getFormVideos();
        return view('public.self-assessment.index', compact('formVideos'));
    }

    private function getFormVideos()
    {
        $testTypes = ['barthel', 'two_minute', 'single_leg', 'five_stand'];
        $videos = [];

        foreach ($testTypes as $testType) {
            $video = Video::where('jenis', 'global')
                ->where('test_type', $testType)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->where('category_type', 'self_assessment')
                          ->orWhere('category_type', 'overall');
                })
                ->orderByRaw("FIELD(category_type, 'self_assessment', 'overall', 'per_test')")
                ->first();

            $videos[$testType] = $video;
        }

        return $videos;
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'barthel_index' => 'nullable|integer',
            'step_test' => 'nullable|integer',
            'single_leg_open' => 'nullable|integer',
            'sit_to_stand' => 'nullable|numeric',
        ]);

        // Create temporary patient data for calculation
        $tempPatient = (object) [
            'nama' => $request->nama,
            'tanggal_lahir' => \Carbon\Carbon::parse($request->tanggal_lahir),
            'jenis_kelamin' => $request->jenis_kelamin,
            'barthel_index' => $request->barthel_index,
            'step_test' => $request->step_test,
            'single_leg_open' => $request->single_leg_open,
            'sit_to_stand' => $request->sit_to_stand,
        ];

        // Calculate classification
        $classification = $this->calculateClassification($tempPatient);

        // Get videos based on classification
        $overallVideo = $this->getOverallVideo($classification);
        $perTestVideos = $this->getPerTestVideos($tempPatient);

        return view('public.self-assessment.result', compact(
            'tempPatient',
            'classification',
            'overallVideo',
            'perTestVideos'
        ));
    }

    private function calculateClassification($patient)
    {
        $age = $patient->tanggal_lahir->age;
        $gender = $patient->jenis_kelamin;
        $normalCount = 0;

        // Check each test
        if (PemeriksaanHelper::isBarthelNormal($patient->barthel_index)) {
            $normalCount++;
        }
        if (PemeriksaanHelper::isStepNormal($patient->step_test, $age, $gender)) {
            $normalCount++;
        }
        if (PemeriksaanHelper::isSingleLegNormal($patient->single_leg_open, $age, false)) {
            $normalCount++;
        }
        if (PemeriksaanHelper::isSitStandNormal($patient->sit_to_stand, $age)) {
            $normalCount++;
        }

        // Determine classification
        if ($normalCount >= 3) {
            return 'Tinggi';
        } elseif ($normalCount === 2) {
            return 'Sedang';
        }
        return 'Rendah';
    }

    private function getOverallVideo($classification)
    {
        $classificationMapping = [
            'Tinggi' => 'ringan',
            'Sedang' => 'sedang',
            'Rendah' => 'berat'
        ];

        $videoClassification = $classificationMapping[$classification] ?? 'sedang';

        return Video::where('jenis', 'global')
            ->where('category_type', 'overall')
            ->where('klasifikasi', $videoClassification)
            ->where('is_active', true)
            ->first();
    }

    private function getPerTestVideos($patient)
    {
        $age = $patient->tanggal_lahir->age;
        $gender = $patient->jenis_kelamin;
        $videos = [];

        $testTypes = [
            'barthel' => [
                'test_value' => $patient->barthel_index,
                'is_normal' => PemeriksaanHelper::isBarthelNormal($patient->barthel_index)
            ],
            'two_minute' => [
                'test_value' => $patient->step_test,
                'is_normal' => PemeriksaanHelper::isStepNormal($patient->step_test, $age, $gender)
            ],
            'single_leg' => [
                'test_value' => $patient->single_leg_open,
                'is_normal' => PemeriksaanHelper::isSingleLegNormal($patient->single_leg_open, $age, false)
            ],
            'five_stand' => [
                'test_value' => $patient->sit_to_stand,
                'is_normal' => PemeriksaanHelper::isSitStandNormal($patient->sit_to_stand, $age)
            ]
        ];

        foreach ($testTypes as $testType => $testData) {
            $level = $testData['is_normal'] ? 'normal' : 'berat';
            
            $video = Video::where('jenis', 'global')
                ->where('category_type', 'per_test')
                ->where('test_type', $testType)
                ->where('level', $level)
                ->where('is_active', true)
                ->first();

            $videos[$testType] = $video;
        }

        return $videos;
    }
}
