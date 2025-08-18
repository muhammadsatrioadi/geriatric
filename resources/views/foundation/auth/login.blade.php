<x-app-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content text-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h1 class="hero-title">
                    Login Yayasan
                </h1>
                <p class="hero-subtitle">
                    Masuk ke dashboard yayasan untuk mengelola data pasien dan pemeriksaan
                </p>
            </div>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="login-section">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="login-card">
                <div class="text-center mb-8">
                    <div class="login-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <h2 class="login-title">Login Yayasan</h2>
                    <p class="login-subtitle">Masukkan kredensial yayasan Anda</p>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="ml-3">
                                <p class="alert-title">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="alert-title">Terjadi kesalahan:</h3>
                                <div class="alert-content">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('foundation.login.submit') }}" method="POST" class="login-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="foundation_name" class="form-label">Nama Yayasan *</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <input type="text" name="foundation_name" id="foundation_name" 
                                   class="form-input {{ $errors->has('foundation_name') ? 'error' : '' }}"
                                   value="{{ old('foundation_name') }}" 
                                   placeholder="Contoh: Yayasan Peduli Lansia Indonesia"
                                   required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="full_name" class="form-label">Nama Lengkap Pemeriksa *</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input type="text" name="full_name" id="full_name" 
                                   class="form-input {{ $errors->has('full_name') ? 'error' : '' }}"
                                   value="{{ old('full_name') }}" 
                                   placeholder="Contoh: Dr. fulan"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fa fa-lock"></i>
                            </div>
                            <input type="password" name="password" id="password" 
                                   class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                                   placeholder="Masukkan password"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="login-btn">
                            <i class="fa fa-sign-in-alt"></i> Login ke Yayasan
                        </button>
                    </div>
                </form>

                <div class="login-footer">
                    <p class="text-center">
                        <a href="{{ route('home') }}" class="back-link">
                            <i class="fa fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </p>
                </div>

                <div class="info-card">
                    <h6 class="info-title">
                        <i class="fa fa-info-circle"></i> Informasi Login
                    </h6>
                    <ul class="info-list">
                        <li>Pastikan nama yayasan dan nama pemeriksa sesuai dengan data yang terdaftar</li>
                        <li>Password bersifat case-sensitive (huruf besar/kecil berpengaruh)</li>
                        <li>Jika lupa password, silakan hubungi admin sistem</li>
                        <li>Hanya yayasan yang aktif yang dapat melakukan login</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom CSS -->
    <style>
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Login Section */
        .login-section {
            padding: 4rem 0;
            background: #f8fafc;
        }
        
        .login-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }
        
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 0;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #20B2AA;
            background: white;
            box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
        }
        
        .form-input.error {
            border-color: #ef4444;
        }
        
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 178, 170, 0.3);
        }
        
        /* Alert */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .alert .flex {
            display: flex;
            align-items: flex-start;
        }
        
        .alert .flex-shrink-0 {
            flex-shrink: 0;
            margin-right: 0.75rem;
        }
        
        .alert-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .alert-content {
            font-size: 0.875rem;
        }
        
        /* Login Footer */
        .login-footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .back-link {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-link:hover {
            color: #20B2AA;
            text-decoration: none;
        }
        
        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #bae6fd;
            margin-top: 2rem;
        }
        
        .info-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .info-list li {
            padding: 0.5rem 0;
            color: #0c4a6e;
            border-bottom: 1px solid #bae6fd;
            position: relative;
            padding-left: 1.5rem;
        }
        
        .info-list li:before {
            content: '•';
            position: absolute;
            left: 0;
            color: #20B2AA;
            font-weight: bold;
        }
        
        .info-list li:last-child {
            border-bottom: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .login-title {
                font-size: 1.75rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</x-app-layout>
