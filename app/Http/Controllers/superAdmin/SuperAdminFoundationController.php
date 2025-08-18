<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foundation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminFoundationController extends Controller
{
    public function index()
    {
        $foundations = Foundation::with(['creator', 'users', 'patients'])->get();
        return view('superadmin.foundation.index', compact('foundations'));
    }

    public function create()
    {
        return view('superadmin.foundation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:foundations,name',
            'is_active' => 'boolean',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        // Create foundation
        $foundation = Foundation::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'] ?? true,
            'created_by' => auth()->id(),
        ]);

        // Create foundation admin user
        User::create([
            'name' => $validated['admin_name'],
            'full_name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'role' => 2, // foundation role
            'foundation_id' => $foundation->id,
        ]);

        return redirect()->route('superadmin.foundations.index')
            ->with('success', 'Yayasan berhasil dibuat.');
    }

    public function show(Foundation $foundation)
    {
        $foundation->load(['creator', 'users', 'patients']);
        return view('superadmin.foundation.show', compact('foundation'));
    }

    public function edit(Foundation $foundation)
    {
        return view('superadmin.foundation.edit', compact('foundation'));
    }

    public function update(Request $request, Foundation $foundation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:foundations,name,' . $foundation->id,
            'is_active' => 'boolean',
        ]);

        $foundation->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('superadmin.foundations.index')
            ->with('success', 'Yayasan berhasil diupdate.');
    }

    public function destroy(Foundation $foundation)
    {
        // Check if foundation has patients
        if ($foundation->patients()->count() > 0) {
            return redirect()->route('superadmin.foundations.index')
                ->with('error', 'Tidak dapat menghapus yayasan yang memiliki data pasien.');
        }

        // Delete foundation users
        $foundation->users()->delete();
        
        // Delete foundation
        $foundation->delete();

        return redirect()->route('superadmin.foundations.index')
            ->with('success', 'Yayasan berhasil dihapus.');
    }

    public function toggleStatus(Foundation $foundation)
    {
        $foundation->update([
            'is_active' => !$foundation->is_active
        ]);

        $status = $foundation->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('superadmin.foundations.index')
            ->with('success', "Yayasan berhasil {$status}.");
    }
}
