<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuperAdminVideoController extends Controller
{
    /**
     * Display a listing of videos for admin.
     */
    public function index()
    {
        // Tampilkan semua video global dan khusus tanpa memfilter user
        $videos = Video::with(['user', 'pasien'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('superadmin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create()
    {
        $pasiens = pasien::all();
        return view('superadmin.video.create', compact('pasiens'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:global,khusus',
            'klasifikasi' => 'nullable|string',
            'category_type' => 'required|in:overall,per_test,self_assessment',
            'test_type' => 'nullable|in:barthel,two_minute,single_leg,five_stand',
            'level' => 'required|in:normal,ringan,berat',
            'pasien_id' => 'nullable|integer',
            'video_file' => 'required|file|mimes:mp4,avi,mov,wmv|max:204800', // 200MB max
        ]);

        // Manual validation based on video type
        if ($request->jenis === 'global' && empty($request->klasifikasi)) {
            return back()->withErrors(['klasifikasi' => 'Klasifikasi harus diisi untuk video global.'])->withInput();
        }

        if ($request->jenis === 'khusus' && empty($request->pasien_id)) {
            return back()->withErrors(['pasien_id' => 'Pasien harus dipilih untuk video khusus.'])->withInput();
        }

        // Validate test_type is required for per_test category
        if ($request->category_type === 'per_test' && empty($request->test_type)) {
            return back()->withErrors(['test_type' => 'Jenis tes harus dipilih untuk kategori per tes.'])->withInput();
        }

        // Validate test_type is required for self_assessment category
        if ($request->category_type === 'self_assessment' && empty($request->test_type)) {
            return back()->withErrors(['test_type' => 'Jenis tes harus dipilih untuk kategori Self Assessment.'])->withInput();
        }

        // Validate klasifikasi values if provided
        if ($request->klasifikasi && !in_array($request->klasifikasi, ['Tinggi', 'Sedang', 'Rendah'])) {
            return back()->withErrors(['klasifikasi' => 'Klasifikasi harus salah satu dari: Tinggi, Sedang, Rendah.'])->withInput();
        }

        $file = $request->file('video_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        // Store in different directory based on category type
        if ($request->category_type === 'self_assessment') {
            $filePath = $file->storeAs('videos/self_assessment', $fileName, 'public');
        } else {
            $filePath = $file->storeAs('videos', $fileName, 'public');
        }

        Video::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'jenis' => $request->jenis,
            'klasifikasi' => $request->klasifikasi,
            'category_type' => $request->category_type,
            'test_type' => $request->test_type,
            'level' => $request->level,
            'user_id' => Auth::id(),
            'pasien_id' => $request->pasien_id,
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.videos.index')->with('success', 'Video berhasil diupload.');
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video)
    {
        return view('superadmin.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        $pasiens = pasien::all();
        return view('superadmin.video.edit', compact('video', 'pasiens'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:global,khusus',
            'klasifikasi' => 'nullable|string',
            'category_type' => 'required|in:overall,per_test,self_assessment',
            'test_type' => 'nullable|in:barthel,two_minute,single_leg,five_stand',
            'level' => 'required|in:normal,ringan,berat',
            'pasien_id' => 'nullable|integer',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:204800',
        ]);

        // Manual validation based on video type
        if ($request->jenis === 'global' && empty($request->klasifikasi)) {
            return back()->withErrors(['klasifikasi' => 'Klasifikasi harus diisi untuk video global.'])->withInput();
        }

        if ($request->jenis === 'khusus' && empty($request->pasien_id)) {
            return back()->withErrors(['pasien_id' => 'Pasien harus dipilih untuk video khusus.'])->withInput();
        }

        // Validate test_type is required for per_test category
        if ($request->category_type === 'per_test' && empty($request->test_type)) {
            return back()->withErrors(['test_type' => 'Jenis tes harus dipilih untuk kategori per tes.'])->withInput();
        }

        // Validate test_type is required for self_assessment category
        if ($request->category_type === 'self_assessment' && empty($request->test_type)) {
            return back()->withErrors(['test_type' => 'Jenis tes harus dipilih untuk kategori Self Assessment.'])->withInput();
        }

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jenis' => $request->jenis,
            'klasifikasi' => $request->klasifikasi,
            'category_type' => $request->category_type,
            'test_type' => $request->test_type,
            'level' => $request->level,
            'pasien_id' => $request->pasien_id,
        ];

        // Handle file upload if new file is provided
        if ($request->hasFile('video_file')) {
            // Delete old file
            if (Storage::disk('public')->exists($video->file_path)) {
                Storage::disk('public')->delete($video->file_path);
            }

            $file = $request->file('video_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store in different directory based on category type
            if ($request->category_type === 'self_assessment') {
                $filePath = $file->storeAs('videos/self_assessment', $fileName, 'public');
            } else {
                $filePath = $file->storeAs('videos', $fileName, 'public');
            }

            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientMimeType();
        }

        $video->update($data);

        return redirect()->route('superadmin.videos.index')->with('success', 'Video berhasil diupdate.');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($video->file_path)) {
            Storage::disk('public')->delete($video->file_path);
        }

        $video->delete();

        return redirect()->route('superadmin.videos.index')->with('success', 'Video berhasil dihapus.');
    }

    /**
     * Toggle video active status
     */
    public function toggleStatus(Video $video)
    {
        $video->update(['is_active' => !$video->is_active]);
        
        return redirect()->route('superadmin.videos.index')->with('success', 'Status video berhasil diubah.');
    }
}
