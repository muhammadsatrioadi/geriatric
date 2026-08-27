<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 justify-center" aria-label="Tabs">
                <button type="button" id="admin-login-tab" class="login-tab active-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-user-shield mr-2"></i>
                    Login Admin
                </button>
                <button type="button" id="foundation-login-tab" class="login-tab inactive-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-building mr-2"></i>
                    Login Yayasan
                </button>
            </nav>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf
        <input type="hidden" name="login_mode" id="login_mode" value="admin">

        <!-- Admin Login Fields -->
        <div id="admin-fields">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="admin_password" :value="__('Password')" />
                <x-text-input id="admin_password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <!-- Foundation Login Fields -->
        <div id="foundation-fields" style="display: none;">
            <!-- Foundation Name -->
            {{-- dropdown foundation --}}
            <div class="mb-4">
                <x-input-label for="foundation_id" :value="__('Pilih Yayasan')" />
                <select id="foundation_id" name="foundation_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">-- Pilih Yayasan --</option>
                    @foreach($foundations as $foundation)
                        <option value="{{ $foundation->id }}" {{ old('foundation_id') == $foundation->id ? 'selected' : '' }}>
                            {{ $foundation->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('foundation_id')" class="mt-2" />
            </div>
            <!-- Full Name -->
            <div class="mt-4">
                <x-input-label for="full_name" :value="__('Nama Lengkap Pemeriksa')" />
                <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" />
                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
            </div>

            <!-- Password for Foundation -->
            <div class="mt-4">
                <x-input-label for="foundation_password" :value="__('Password')" />
                <x-text-input id="foundation_password" class="block mt-1 w-full"
                                type="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <!-- Remember Me (only for admin) -->
        <div class="block mt-4" id="remember-section">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" id="forgot-password-link">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3" id="login-button">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adminTab = document.getElementById('admin-login-tab');
            const foundationTab = document.getElementById('foundation-login-tab');
            const adminFields = document.getElementById('admin-fields');
            const foundationFields = document.getElementById('foundation-fields');
            const loginMode = document.getElementById('login_mode');
            const rememberSection = document.getElementById('remember-section');
            const forgotPasswordLink = document.getElementById('forgot-password-link');

            // Set initial state based on foundation mode, old login_mode or errors
            const foundationMode = {{ isset($foundationMode) && $foundationMode ? 'true' : 'false' }};
            const oldLoginMode = '{{ old("login_mode", "admin") }}';
            const hasFoundationErrors = {{ $errors->has('foundation_id') || $errors->has('full_name') ? 'true' : 'false' }};

            // Initialize password fields
            document.getElementById('admin_password').setAttribute('name', 'password');

            if (foundationMode || oldLoginMode === 'foundation' || hasFoundationErrors) {
                switchToFoundation();
            } else {
                switchToAdmin();
            }

            adminTab.addEventListener('click', switchToAdmin);
            foundationTab.addEventListener('click', switchToFoundation);

            function switchToAdmin() {
                // Update tab appearance
                adminTab.classList.remove('inactive-tab');
                adminTab.classList.add('active-tab');
                foundationTab.classList.remove('active-tab');
                foundationTab.classList.add('inactive-tab');

                // Switch form content
                adminFields.style.display = 'block';
                foundationFields.style.display = 'none';
                loginMode.value = 'admin';
                rememberSection.style.display = 'block';
                forgotPasswordLink.style.display = 'inline';

                // Clear foundation fields and set admin fields as required
                document.getElementById('foundation_id').removeAttribute('required');
                document.getElementById('full_name').removeAttribute('required');
                document.getElementById('foundation_password').removeAttribute('name');
                document.getElementById('foundation_password').removeAttribute('required');

                document.getElementById('email').setAttribute('required', 'required');
                document.getElementById('admin_password').setAttribute('required', 'required');
                document.getElementById('admin_password').setAttribute('name', 'password');
            }

            function switchToFoundation() {
                // Update tab appearance
                foundationTab.classList.remove('inactive-tab');
                foundationTab.classList.add('active-tab');
                adminTab.classList.remove('active-tab');
                adminTab.classList.add('inactive-tab');

                // Switch form content
                adminFields.style.display = 'none';
                foundationFields.style.display = 'block';
                loginMode.value = 'foundation';
                rememberSection.style.display = 'none';
                forgotPasswordLink.style.display = 'none';

                // Clear admin fields and set foundation fields as required
                document.getElementById('email').removeAttribute('required');
                document.getElementById('admin_password').removeAttribute('required');
                document.getElementById('admin_password').removeAttribute('name');

                document.getElementById('foundation_id').setAttribute('required', 'required');
                document.getElementById('full_name').setAttribute('required', 'required');
                document.getElementById('foundation_password').setAttribute('required', 'required');
                document.getElementById('foundation_password').setAttribute('name', 'password');
            }
        });
    </script>

    <style>
        .login-tab {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .active-tab {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .inactive-tab {
            border-color: transparent;
            color: #6b7280;
        }

        .inactive-tab:hover {
            color: #374151;
            border-color: #d1d5db;
        }

        /* Smooth transitions for form sections */
        #admin-fields, #foundation-fields {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</x-guest-layout>
