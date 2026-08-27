<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Foundation;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Check if this is foundation login mode
        if ($this->input('login_mode') === 'foundation') {
            return [
                'foundation_id' => ['required', 'integer', 'exists:foundations,id'],
                'full_name' => ['required', 'string'],
                'password' => ['required', 'string'],
            ];
        }

        // Default admin/superadmin login
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Check if this is foundation login mode
        if ($this->input('login_mode') === 'foundation') {
            $this->authenticateFoundation();
        } else {
            $this->authenticateAdmin();
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Authenticate foundation user
     */
    protected function authenticateFoundation(): void
    {
        // Find foundation by ID
        $foundation = Foundation::where('id', $this->input('foundation_id'))
            ->where('is_active', true)
            ->first();

        if (!$foundation) {
            throw ValidationException::withMessages([
                'foundation_id' => 'Yayasan tidak ditemukan atau tidak aktif.',
            ]);
        }

        // Find user by foundation_id, full_name, and role = 2 (foundation)
        $user = User::where('foundation_id', $foundation->id)
            ->where('full_name', $this->input('full_name'))
            ->where('role', 2)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'full_name' => 'Nama lengkap pemeriksa tidak ditemukan untuk yayasan ini.',
            ]);
        }

        // Check password
        if (!Hash::check($this->input('password'), $user->password)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        // Login user
        Auth::login($user);
    }

    /**
     * Authenticate admin/superadmin user
     */
    protected function authenticateAdmin(): void
    {
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        if ($this->input('login_mode') === 'foundation') {
            return Str::transliterate(Str::lower($this->input('foundation_id') . '|' . $this->input('full_name')) . '|' . $this->ip());
        }

        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
