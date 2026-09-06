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

        $searchTerm = trim($request->search_term);
        $escapedTerm = addcslashes($searchTerm, '%_\\');
        $pasien = null;

        // 1. Cari berdasarkan NIK (semua pasien publik, termasuk yayasan)
        $pasien = pasien::where('public_visible', true)
            ->where('nik', 'LIKE', '%' . $escapedTerm . '%', 'ESCAPE', '\\')
            ->first();

        // 2. Format "Nama Yayasan - Nama Pasien" (mendukung - / – / — dengan/tanpa spasi)
        if (!$pasien && preg_match('/^(.+?)\s*[-–—]\s*(.+)$/u', $searchTerm, $matches)) {
            $foundationName = trim($matches[1]);
            $patientName = trim($matches[2]);
            $escapedFoundation = addcslashes($foundationName, '%_\\');
            $escapedPatient = addcslashes($patientName, '%_\\');

            $foundation = Foundation::where('name', 'LIKE', '%' . $escapedFoundation . '%', 'ESCAPE', '\\')
                ->where('is_active', true)
                ->first();

            if (!$foundation) {
                return back()->with('error', 'Yayasan tidak ditemukan atau tidak aktif. Pastikan nama yayasan benar.');
            }

            $pasien = pasien::where('foundation_id', $foundation->id)
                ->where('nama', 'LIKE', '%' . $escapedPatient . '%', 'ESCAPE', '\\')
                ->where('public_visible', true)
                ->first();
        }

        // 3. Cari berdasarkan nama saja
        if (!$pasien) {
            $results = pasien::where('public_visible', true)
                ->where('nama', 'LIKE', '%' . $escapedTerm . '%', 'ESCAPE', '\\')
                ->with('foundation')
                ->get();

            if ($results->count() === 1) {
                $pasien = $results->first();
            } elseif ($results->count() > 1) {
                $examples = $results->map(function ($p) {
                    $yayasan = $p->foundation?->name ?? 'Admin';
                    return "{$yayasan} - {$p->nama}";
                })->unique()->take(3)->implode(' | ');

                return back()->with('error', "Ditemukan beberapa pasien dengan nama serupa. Gunakan format: Nama Yayasan - Nama Pasien. Contoh: {$examples}");
            }
        }

        if (!$pasien) {
            return back()->with('error', 'Pasien tidak ditemukan atau data tidak tersedia untuk publik. Untuk pasien yayasan, gunakan format: Nama Yayasan - Nama Pasien (contoh: Yayasan Sehat - Budi Santoso).');
        }

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
