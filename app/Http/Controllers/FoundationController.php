<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\User;
use App\Models\Video;
use App\Models\Foundation;
use App\Helpers\PemeriksaanHelper;
use Illuminate\Support\Facades\Auth;

class FoundationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->foundation) {
                abort(403, 'User tidak memiliki akses ke foundation.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $user = Auth::user();
        $foundation = $user->foundation;

        // Get basic statistics for this foundation
        $totalPasien = pasien::where('foundation_id', $foundation->id)->count();
        $totalVideo = Video::count();

        // Get classification distribution for pie chart
        $pasiens = pasien::where('foundation_id', $foundation->id)->get();
        $classificationCounts = [
            'Ringan' => 0,
            'Sedang' => 0,
            'Berat' => 0
        ];

        foreach ($pasiens as $pasien) {
            $classification = $pasien->klasifikasi;
            if (isset($classificationCounts[$classification])) {
                $classificationCounts[$classification]++;
            }
        }

        // Prepare pie chart data
        $pieChartLabels = ['Ringan', 'Sedang', 'Berat'];
        $pieChartData = [
            $classificationCounts['Ringan'],
            $classificationCounts['Sedang'],
            $classificationCounts['Berat']
        ];
        $pieChartColors = ['#10B981', '#F59E0B', '#EF4444'];

        // Get test statistics for bar chart
        $testStats = $this->getTestStatistics($foundation->id);

        // Get recent patients
        $recentPatients = pasien::where('foundation_id', $foundation->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get counts for statistics cards
        $ringanCount = $classificationCounts['Ringan'];
        $beratCount = $classificationCounts['Berat'];

        // Get all pasiens for Data Pasien tab
        $allPasiens = pasien::where('foundation_id', $foundation->id)
            ->orderBy('nama', 'asc')
            ->get();

        return view('foundation.dashboard', compact(
            'totalPasien',
            'totalVideo',
            'pieChartLabels',
            'pieChartData',
            'pieChartColors',
            'testStats',
            'foundation',
            'recentPatients',
            'ringanCount',
            'beratCount',
            'allPasiens'
        ));
    }

    private function getTestStatistics($foundationId)
    {
        $pasiens = pasien::where('foundation_id', $foundationId)->get();
        $testStats = [
            'labels' => ['Barthel Index', '2-Minute Step Test', 'Single Leg Balance', 'Five Times Sit to Stand'],
            'normal' => [0, 0, 0, 0],
            'abnormal' => [0, 0, 0, 0]
        ];

        foreach ($pasiens as $pasien) {
            // Barthel Index
            if ($pasien->barthel_index !== null) {
                if (PemeriksaanHelper::isBarthelNormal($pasien->barthel_index)) {
                    $testStats['normal'][0]++;
                } else {
                    $testStats['abnormal'][0]++;
                }
            }

            // 2-Minute Step Test
            if ($pasien->step_test !== null) {
                if (PemeriksaanHelper::isStepTestNormal($pasien->step_test)) {
                    $testStats['normal'][1]++;
                } else {
                    $testStats['abnormal'][1]++;
                }
            }

            // Single Leg Balance
            if ($pasien->single_leg_open !== null) {
                if (PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open)) {
                    $testStats['normal'][2]++;
                } else {
                    $testStats['abnormal'][2]++;
                }
            }

            // Five Times Sit to Stand
            if ($pasien->sit_to_stand !== null) {
                if (PemeriksaanHelper::isSitToStandNormal($pasien->sit_to_stand)) {
                    $testStats['normal'][3]++;
                } else {
                    $testStats['abnormal'][3]++;
                }
            }
        }

        return $testStats;
    }

    public function create()
    {
        return view('foundation.pasien.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
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
            'public_visible' => 'boolean',
        ]);

        $validated['foundation_id'] = $user->foundation_id;
        $validated['owned_by'] = $user->id;
        $validated['public_visible'] = $request->has('public_visible');

        $pasien = pasien::create($validated);
        return redirect()->route('foundation.pasiens.manage', $pasien->id)
            ->with('success', 'Data pasien berhasil disimpan.');
    }

    public function show(pasien $pasien)
    {
        $user = Auth::user();
        
        // Check if pasien belongs to this foundation
        if ($pasien->foundation_id !== $user->foundation_id) {
            abort(403, 'Unauthorized action.');
        }

        // Get overall video and per-test videos using new methods
        $overallVideo = $pasien->getOverallVideo();
        $perTestVideos = $pasien->getPerTestVideos();

        return view('foundation.pasien.show', compact('pasien', 'overallVideo', 'perTestVideos'));
    }

    public function manage(pasien $pasien)
    {
        $user = Auth::user();
        
        // Check if pasien belongs to this foundation
        if ($pasien->foundation_id !== $user->foundation_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('foundation.pasien.manage', compact('pasien'));
    }

    public function update(Request $request, pasien $pasien)
    {
        $user = Auth::user();
        
        // Check if pasien belongs to this foundation
        if ($pasien->foundation_id !== $user->foundation_id) {
            abort(403, 'Unauthorized action.');
        }

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
            'public_visible' => 'boolean',
        ]);

        $validated['public_visible'] = $request->has('public_visible');
        
        $pasien->update($validated);
        return redirect()->route('foundation.pasiens.manage', $pasien->id)
            ->with('success', 'Data pasien berhasil disimpan.');
    }

    public function destroy(pasien $pasien)
    {
        $user = Auth::user();
        
        // Check if pasien belongs to this foundation
        if ($pasien->foundation_id !== $user->foundation_id) {
            abort(403, 'Unauthorized action.');
        }

        $pasien->delete();
        return redirect()->route('foundation.pasiens')->with('success', 'Data pasien berhasil dihapus.');
    }
}
