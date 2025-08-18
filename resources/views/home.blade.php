<x-app-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content text-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h1 class="hero-title">
                    Sistem Informasi Geriatric Care
                </h1>
                <p class="hero-subtitle">
                    Cari data pasien dan video latihan dengan cepat dan mudah untuk perawatan lansia yang optimal
                </p>

                <!-- Login Yayasan Button -->
                <div class="mt-8">
                    <a href="{{ route('login', ['mode' => 'foundation']) }}" class="login-yayasan-btn">
                        <i class="fa fa-building"></i> Login Yayasan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions Section -->
    <section class="quick-actions-section">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-search"></i>
                    </div>
                    <h3 class="action-title">Cari Data Pasien</h3>
                    <p class="action-description">Cari data pasien yang sudah terdaftar di sistem</p>
                    <a href="#search-section" class="action-btn">Mulai Pencarian</a>
                </div>
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-clipboard-check"></i>
                    </div>
                    <h3 class="action-title">Self-Assessment</h3>
                    <p class="action-description">Lakukan pemeriksaan mandiri untuk mengetahui tingkat fungsional</p>
                    <a href="{{ route('public.self-assessment.index') }}" class="action-btn">Mulai Assessment</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section id="search-section" class="search-section">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="search-card">
                <div class="text-center mb-8">
                    <h2 class="search-title">Pencarian Data Pasien</h2>
                    <p class="search-subtitle">Masukkan NIK pasien atau kombinasi Nama Yayasan + Nama Pasien untuk melihat hasil pemeriksaan dan video latihan yang disesuaikan</p>
                </div>

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa fa-exclamation-triangle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-lg text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('home.search') }}" method="POST" class="search-form">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1">
                            <i class="fa fa-search search-icon"></i>
                            <input type="text" name="search_term" id="search_term"
                                class="search-input {{ $errors->has('search_term') ? 'border-red-500' : '' }}"
                                placeholder="Cari pasien berdasarkan Nama atau Kode Unik"
                                value="{{ old('search_term') }}"
                                required
                                autofocus>
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fa fa-search"></i> Cari Pasien
                        </button>
                    </div>
                    @error('search_term')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </form>

                <div class="info-card" style="font-size: 1.25rem; line-height: 2; padding: 1.5rem;">
                    <h6 class="info-title" style="font-size: 1.5rem;">
                        <i class="fa fa-info-circle"></i> Petunjuk Pencarian untuk Lansia
                    </h6>
                    <ul class="info-list" style="font-size: 1.15rem;">
                        <li>
                            <strong>Cara mencari data pasien:</strong>
                            <ul style="margin-left: 1.5rem; list-style: disc;">
                                <li>Jika Anda pasien <b>admin</b>, cukup ketik <b>Nama Anda</b> saja.</li>
                                <li>Jika Anda pasien <b>yayasan</b>, ketik <b>Nama Yayasan</b> lalu tanda hubung (-), lalu <b>Nama Anda</b>.<br>
                                    <span style="font-size:1.1rem;">Contoh: <b>Yayasan Sehat - Budi Santoso</b></span>
                                </li>
                                {{-- <li>Anda juga bisa mencari dengan <b>NIK</b> (Nomor Induk Kependudukan) jika tahu.<br>
                                    <span style="font-size:1.1rem;">Contoh: <b>1234567890</b></span>
                                </li> --}}
                            </ul>
                        </li>
                        <li>
                            <b>Catatan:</b>
                            <ul style="margin-left: 1.5rem; list-style: disc;">
                                <li>Hanya data pasien yang <b>terbuka untuk umum</b> yang bisa dicari.</li>
                                <li>Video latihan yang muncul akan sesuai dengan hasil pemeriksaan Anda.</li>
                                <li>Jika Anda kesulitan atau tidak menemukan data, silakan minta bantuan keluarga, admin, atau yayasan.</li>
                            </ul>
                        </li>
                    </ul>
                    <div style="margin-top:1.5rem; background:#F0F4F8; border-radius:8px; padding:1rem; font-size:1.1rem;">
                        <b>Tips untuk Lansia:</b><br>
                        <ul style="margin-left: 1.5rem; list-style: disc;">
                            <li>Gunakan kacamata jika tulisan kurang jelas.</li>
                            <li>Mintalah bantuan keluarga jika kesulitan mengetik.</li>
                            <li>Pastikan mengetik nama dengan benar dan perlahan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Info -->
    <section class="footer-section">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="footer-content">
                <p>© 2025 Sistem Informasi Geriatric Care. Semua hak cipta dilindungi.</p>
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

        /* Login Yayasan Button */
        .login-yayasan-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .login-yayasan-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        /* Quick Actions */
        .quick-actions-section {
            padding: 4rem 0;
            background: #f8fafc;
        }

        .action-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .action-icon {
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

        .action-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .action-description {
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .action-btn {
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 178, 170, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Search Section */
        .search-section {
            padding: 4rem 0;
            background: white;
        }

        .search-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }

        .search-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .search-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form {
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .search-input:focus {
            outline: none;
            border-color: #20B2AA;
            background: white;
            box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
        }

        .search-btn {
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 178, 170, 0.3);
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #bae6fd;
        }

        .info-title {
            font-size: 1.25rem;
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
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        /* Footer */
        .footer-section {
            background: #1e293b;
            color: white;
            padding: 2rem 0;
        }

        .footer-content {
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .search-title {
                font-size: 2rem;
            }

            .search-card {
                padding: 2rem 1.5rem;
            }

            .login-yayasan-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <!-- Custom JavaScript -->
    <script src="{{ asset('resource/js/geriatric-care-public.js') }}"></script>
</x-app-layout>
