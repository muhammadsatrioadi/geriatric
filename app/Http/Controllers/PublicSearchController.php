<?php

namespace App\Http\Controllers;

use App\Models\pasien;
use Illuminate\Http\Request;

class PublicSearchController extends Controller
{
    /**
     * Show the search form
     */
    public function index()
    {
        return view('public.search');
    }

    /**
     * Search for patient by name or unique code
     */
    public function search(Request $request)
    {
        // Consider applying rate limiting middleware in routes/web.php or controller constructor:
        // $this->middleware('throttle:10,1')->only('search');

        $request->validate([
            'search_term' => 'required|string|min:2',
        ]);

        // Escape LIKE wildcards to prevent abuse
        $searchTerm = $request->search_term;
        $escapedTerm = addcslashes($searchTerm, '%_\\');
        
        // Search by name or NIK (as unique code), using ESCAPE for safe LIKE
        $pasien = pasien::where('nama', 'LIKE', '%' . $escapedTerm . '%', 'ESCAPE', '\\')
            ->orWhere('nik', 'LIKE', '%' . $escapedTerm . '%', 'ESCAPE', '\\')
            ->first();

        if (!$pasien) {
            return back()->with('error', 'Pasien tidak ditemukan. Silakan coba dengan nama atau kode yang berbeda.');
        }

        return view('public.result', compact('pasien'));
    }

    /**
     * Show patient result with videos
     */
    public function show(pasien $pasien)
    {
        // Get overall video and per-test videos using new methods
        $overallVideo = $pasien->getOverallVideo();
        $perTestVideos = $pasien->getPerTestVideos();

        return view('public.show', compact('pasien', 'overallVideo', 'perTestVideos'));
    }
}
