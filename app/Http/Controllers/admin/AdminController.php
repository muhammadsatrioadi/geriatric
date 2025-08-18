<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\User;
use App\Models\Video;
use App\Helpers\PemeriksaanHelper;

class AdminController extends Controller
{
    public function index()
    {
        // Get basic statistics
        $totalPasien = pasien::count();
        $totalAdmin = User::where('role', 1)->count();
        $totalFoundation = User::where('role', 2)->count();
        $totalVideo = Video::count();

        // Get classification distribution for pie chart (computed attribute)
        $pasiens = pasien::all();
        $classificationCounts = [
            'Tinggi' => 0,
            'Sedang' => 0,
            'Rendah' => 0
        ];

        foreach ($pasiens as $pasien) {
            $classification = $pasien->classification;
            $classificationCounts[$classification]++;
        }

        // Prepare pie chart data
        $pieChartLabels = ['Ringan', 'Sedang', 'Berat'];
        $pieChartData = [
            $classificationCounts['Tinggi'],
            $classificationCounts['Sedang'],
            $classificationCounts['Rendah']
        ];
        $pieChartColors = ['#10B981', '#F59E0B', '#EF4444'];

        // Get test statistics for bar chart
        $testStats = $this->getTestStatistics();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalAdmin', 
            'totalFoundation',
            'totalVideo',
            'pieChartLabels',
            'pieChartData',
            'pieChartColors',
            'testStats'
        ));
    }

    private function getTestStatistics()
    {
        $pasiens = pasien::all();
        $testStats = [
            'barthel' => ['normal' => 0, 'abnormal' => 0],
            'step_test' => ['normal' => 0, 'abnormal' => 0],
            'single_leg' => ['normal' => 0, 'abnormal' => 0],
            'sit_to_stand' => ['normal' => 0, 'abnormal' => 0]
        ];

        foreach ($pasiens as $pasien) {
            $age = $pasien->tanggal_lahir->age;
            $gender = $pasien->jenis_kelamin;

            // Barthel Index
            if ($pasien->barthel_index !== null) {
                if (PemeriksaanHelper::isBarthelNormal($pasien->barthel_index)) {
                    $testStats['barthel']['normal']++;
                } else {
                    $testStats['barthel']['abnormal']++;
                }
            }

            // 2-Minute Step Test
            if ($pasien->step_test !== null) {
                if (PemeriksaanHelper::isStepNormal($pasien->step_test, $age, $gender)) {
                    $testStats['step_test']['normal']++;
                } else {
                    $testStats['step_test']['abnormal']++;
                }
            }

            // Single Leg Balance
            if ($pasien->single_leg_open !== null) {
                if (PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open, $age, false)) {
                    $testStats['single_leg']['normal']++;
                } else {
                    $testStats['single_leg']['abnormal']++;
                }
            }

            // Five Times Sit to Stand
            if ($pasien->sit_to_stand !== null) {
                if (PemeriksaanHelper::isSitStandNormal($pasien->sit_to_stand, $age)) {
                    $testStats['sit_to_stand']['normal']++;
                } else {
                    $testStats['sit_to_stand']['abnormal']++;
                }
            }
        }

        return $testStats;
    }

    public function pasiens()
    {
        $pasiens = \App\Models\pasien::all();
        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    /**
     * Display the specified pasien for viewing/edit.
     */
    public function manage(pasien $pasien)
    {
        return view('admin.pasien.manage', compact('pasien'));
    }

    /**
     * Display the specified pasien details with examination results and videos.
     */
    public function show(pasien $pasien)
    {
        // Get overall video and per-test videos using new methods
        $overallVideo = $pasien->getOverallVideo();
        $perTestVideos = $pasien->getPerTestVideos();

        return view('admin.pasien.show', compact('pasien', 'overallVideo', 'perTestVideos'));
    }
    /**
     * Update the specified pasien in storage.
     */
    public function update(Request $request, pasien $pasien)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'berat_badan' => 'nullable|integer',
            'tinggi_badan' => 'nullable|integer',
            'tekanan_darah' => 'nullable|string',
            'kategori_stroke' => 'nullable|string',
            'riwayat_jatuh' => 'nullable|string',
            'barthel_index' => 'nullable|integer',
            'step_test'    => 'nullable|integer',
            'single_leg_open'   => 'nullable|integer',
            'single_leg_closed' => 'nullable|integer',
            'sit_to_stand' => 'nullable|numeric',
        ]);
        $pasien->update($validated);
        return redirect()->route('admin.pasiens.manage', $pasien->id)
            ->with('success', 'Data pasien berhasil disimpan.');
    }
    /**
     * Remove the specified pasien from storage.
     */
    public function destroy(pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('admin.pasiens')->with('success', 'Data pasien berhasil dihapus.');
    }
    /**
     * Store a newly created pasien in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'berat_badan' => 'nullable|integer',
            'tinggi_badan' => 'nullable|integer',
            'tekanan_darah' => 'nullable|string',
            'kategori_stroke' => 'nullable|string',
            'riwayat_jatuh' => 'nullable|string',
            'barthel_index' => 'nullable|integer',
            'step_test'    => 'nullable|integer',
            'single_leg_open'   => 'nullable|integer',
            'single_leg_closed' => 'nullable|integer',
            'sit_to_stand' => 'nullable|numeric',
        ]);
        $pasien = pasien::create($validated);
        return redirect()->route('admin.pasiens.manage', $pasien->id)
            ->with('success', 'Data pasien berhasil disimpan.');
    }
}
