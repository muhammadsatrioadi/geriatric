<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Foundation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $foundationMode = $request->get('mode') === 'foundation';
        $foundations = Foundation::where('is_active', true)->get();

        return view('auth.login', compact('foundationMode', 'foundations'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect users based on their role after login
        $userRole = Auth::user()->role;
        switch ($userRole) {
            case 0: // SuperAdmin
                $dashboardRoute = 'superadmin';
                break;
            case 1: // Admin
                $dashboardRoute = 'admin';
                break;
            case 2: // Foundation
                $dashboardRoute = 'foundation.dashboard';
                break;
            default:
                $dashboardRoute = 'home';
                break;
        }
        return redirect()->intended(route($dashboardRoute));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
