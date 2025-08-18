<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Foundation;
use Illuminate\Support\Facades\Hash;

class FoundationAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('foundation.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'foundation_name' => 'required|string',
            'full_name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find foundation by name
        $foundation = Foundation::where('name', $request->foundation_name)
            ->where('is_active', true)
            ->first();

        if (!$foundation) {
            return back()->withErrors([
                'foundation_name' => 'Nama yayasan tidak ditemukan atau tidak aktif.',
            ])->withInput($request->except('password'));
        }

        // Find user by foundation_id, full_name, and role = 2 (foundation)
        $user = User::where('foundation_id', $foundation->id)
            ->where('full_name', $request->full_name)
            ->where('role', 2)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'full_name' => 'Nama lengkap pemeriksa tidak ditemukan untuk yayasan ini.',
            ])->withInput($request->except('password'));
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->withInput($request->except('password'));
        }

        // Login user
        Auth::login($user);

        return redirect()->route('foundation.dashboard')
            ->with('success', 'Selamat datang, ' . $user->full_name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login', ['mode' => 'foundation'])
            ->with('success', 'Anda telah berhasil logout.');
    }
}
