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
            $video = Video::where('test_type', $testType)
                ->where('is_active', true)
                ->orderByRaw("FIELD(category_type, 'self_assessment', 'overall', 'per_test')")
                ->orderBy('created_at', 'desc')
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

        try {
            $tempPatient = (object) [
                'nama' => $request->nama,
                'tanggal_lahir' => \Carbon\Carbon::parse($request->tanggal_lahir),
                'jenis_kelamin' => $request->jenis_kelamin,
                'barthel_index' => $request->barthel_index,
                'step_test' => $request->step_test,
                'single_leg_open' => $request->single_leg_open,
                'sit_to_stand' => $request->sit_to_stand,
            ];

            $classification = $this->calculateClassification($tempPatient);
            $overallVideo = $this->getOverallVideo($classification);
            $perTestVideos = $this->getPerTestVideos($tempPatient);

            return view('public.self-assessment.result', compact(
                'tempPatient',
                'classification',
                'overallVideo',
                'perTestVideos'
            ));
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses data. Silakan coba lagi.'])
                        ->withInput();
        }
    }

    private function calculateClassification($patient)
    {
        try {
            $age = $patient->tanggal_lahir->age;
            $gender = $patient->jenis_kelamin;
            $normalCount = 0;

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

            if ($normalCount >= 3) {
                return 'Tinggi';
            } elseif ($normalCount === 2) {
                return 'Sedang';
            }
            return 'Rendah';
        } catch (\Exception $e) {
            report($e);
            return 'Sedang';
        }
    }

    private function getOverallVideo($classification)
    {
        try {
            $classificationMapping = [
                'Tinggi' => ['ringan', 'Ringan', 'NORMAL', 'normal'],
                'Sedang' => ['sedang', 'Sedang', 'normal', 'Normal'],
                'Rendah' => ['berat', 'Berat', 'sedang', 'Sedang']
            ];

            $candidates = $classificationMapping[$classification] ?? ['Sedang'];

            return Video::where('jenis', 'global')
                ->where('is_active', true)
                ->whereIn('klasifikasi', $candidates)
                ->orderByRaw("FIELD(klasifikasi, '".implode("','", $candidates)."')")
                ->first();
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }

    private function getPerTestVideos($patient)
    {
        try {
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
                $level = $testData['is_normal'] ? ['normal', 'Normal'] : ['berat', 'Berat', 'sedang', 'Sedang'];

                $video = Video::where('test_type', $testType)
                    ->where('is_active', true)
                    ->whereIn('level', $level)
                    ->orderByRaw("FIELD(level, '".implode("','", $level)."')")
                    ->orderBy('created_at', 'desc')
                    ->first();

                $videos[$testType] = $video;
            }

            return $videos;
        } catch (\Exception $e) {
            report($e);
            return [];
        }
    }
}
