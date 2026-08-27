<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\Models\pasien;
use App\Models\User;
use App\Models\Video;
use App\Helpers\PemeriksaanHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuperAdminController extends Controller
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

        return view('superadmin.dashboard', compact(
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
            $age = ($pasien->tanggal_lahir && method_exists($pasien->tanggal_lahir, 'age')) ? $pasien->tanggal_lahir->age : null;
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
            if ($pasien->step_test !== null && $age !== null && $gender !== null) {
                if (PemeriksaanHelper::isStepNormal($pasien->step_test, $age, $gender)) {
                    $testStats['step_test']['normal']++;
                } else {
                    $testStats['step_test']['abnormal']++;
                }
            }

            // Single Leg Balance
            if ($pasien->single_leg_open !== null && $age !== null) {
                if (PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open, $age, false)) {
                    $testStats['single_leg']['normal']++;
                } else {
                    $testStats['single_leg']['abnormal']++;
                }
            }

            // Five Times Sit to Stand
            if ($pasien->sit_to_stand !== null && $age !== null) {
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
        return view('superadmin.pasien.index', compact('pasiens'));
    }

    /**
     * Display list of admin users.
     */
    public function admins()
    {
        // List of all admin users
        $admins = \App\Models\User::where('role', 1)->get();
        // Determine currently online users by session last_activity (within 5 minutes)
        $threshold = Carbon::now()->subMinutes(5)->timestamp;
        $onlineUserIds = DB::table('sessions')
            ->where('last_activity', '>=', $threshold)
            ->pluck('user_id')
            ->unique()
            ->toArray();
        return view('superadmin.admin.index', compact('admins', 'onlineUserIds'));
    }

    public function pasiensCreate()
    {
        return view('superadmin.pasien.create');
    }

    public function adminsCreate()
    {
        return view('superadmin.admin.create');
    }

    /**
     * Display the specified pasien for viewing/edit.
     */
    public function pasiensManage(pasien $pasien)
    {
        return view('superadmin.pasien.manage', compact('pasien'));
    }

    /**
     * Display the specified pasien details with examination results and videos.
     */
    public function pasiensShow(pasien $pasien)
    {
        // Get overall video and per-test videos using new methods
        $overallVideo = $pasien->getOverallVideo();
        $perTestVideos = $pasien->getPerTestVideos();

        return view('superadmin.pasien.show', compact('pasien', 'overallVideo', 'perTestVideos'));
    }
    
    public function adminsManage(user $admin)
    {
        return view('superadmin.admin.manage', compact('admin'));
    }
    /**
     * Update the specified pasien in storage.
     */
    public function pasiensUpdate(Request $request, pasien $pasien)
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
            'single_leg'   => 'nullable|string',
            'sit_to_stand' => 'nullable|numeric',
        ]);
        $pasien->update($validated);
        return redirect()->route('superadmin.pasiens')->with('success', 'Data pasien berhasil diupdate.');
    }

    public function adminsUpdate(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:0,1',
        ]);
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }
        $admin->update($validated);
        return redirect()->route('superadmin.admins')->with('success', 'Admin berhasil diupdate.');
    }
    /**
     * Remove the specified pasien from storage.
     */
    public function pasiensDestroy(pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('superadmin.pasiens')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function adminsDestroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('superadmin.admins')->with('success', 'Admin berhasil dihapus.');
    }
    /**
     * Reset the specified admin user's password to a random 8-character string.
     */
    public function adminsResetPassword(User $admin)
    {
        $newPassword = Str::random(8);
        $admin->update(['password' => Hash::make($newPassword)]);
        return redirect()->route('superadmin.admins.manage', $admin->id)
                         ->with('success', "Password baru untuk {$admin->name}: {$newPassword}");
    }
    /**
     * Store a newly created pasien in storage.
     */
    public function pasiensStore(Request $request)
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
            'single_leg'   => 'nullable|string',
            'sit_to_stand' => 'nullable|numeric',
        ]);
        pasien::create($validated);
        return redirect()->route('superadmin.pasiens')->with('success', 'Data pasien berhasil disimpan.');
    }

    public function adminsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 1;
        User::create($validated);
        return redirect()->route('superadmin.admins')->with('success', 'Admin berhasil ditambahkan.');
    }
}
