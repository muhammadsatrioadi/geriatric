<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\Foundation;
use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
    public function index(Request $request)
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search_term' => 'required|string|min:2',
        ]);

        $searchTerm = $request->search_term;

        // Check if search term contains foundation name pattern (e.g., "Yayasan ABC - Nama Pasien")
        if (strpos($searchTerm, ' - ') !== false) {
            // Split by " - " to separate foundation name and patient name
            $parts = explode(' - ', $searchTerm, 2);
            $foundationName = trim($parts[0]);
            $patientName = trim($parts[1]);

            // Find foundation
            $foundation = Foundation::where('name', 'LIKE', '%' . $foundationName . '%')
                ->where('is_active', true)
                ->first();

            if (!$foundation) {
                return back()->with('error', 'Yayasan tidak ditemukan atau tidak aktif.');
            }

            // Find patient by foundation and name
            $pasien = pasien::where('foundation_id', $foundation->id)
                ->where('nama', 'LIKE', '%' . $patientName . '%')
                ->where('public_visible', true)
                ->first();
        } else {
            // Search by NIK or name only (for admin patients)
            $pasien = pasien::where(function ($query) use ($searchTerm) {
                $query->where('nama', 'LIKE', '%' . $searchTerm . '%');
            })
                ->where('public_visible', true)
                ->whereNull('foundation_id') // Only admin patients (no foundation)
                ->first();
        }

        if (!$pasien) {
            return back()->with('error', 'Pasien tidak ditemukan atau data tidak tersedia untuk publik. Silakan cek nama yayasan dan nama pasien, atau hubungi admin.');
        }

        // Redirect using a signed URL to prevent ID tampering
        return redirect()->to(URL::signedRoute('public.patient.show', ['pasien' => $pasien->id]));
    }

    public function show(pasien $pasien)
    {
        // Check if patient is public visible
        if (!$pasien->public_visible) {
            abort(403, 'Data pasien tidak tersedia untuk publik.');
        }

        // Get overall video and per-test videos using new methods
        $overallVideo = $pasien->getOverallVideo();
        $perTestVideos = $pasien->getPerTestVideos();

        return view('public.show', compact('pasien', 'overallVideo', 'perTestVideos'));
    }
}
