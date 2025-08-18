<x-app-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content text-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h1 class="hero-title">
                    Self-Assessment Geriatric Care
                </h1>
                <p class="hero-subtitle">
                    Lakukan pemeriksaan mandiri untuk mengetahui tingkat fungsional lansia
                </p>
            </div>
        </div>
    </section>

    <!-- Assessment Form Section -->
    <section class="assessment-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="assessment-card">
                <div class="text-center mb-8">
                    <h2 class="assessment-title">Form Pemeriksaan Mandiri</h2>
                    <p class="assessment-subtitle">Isi data diri dan hasil tes untuk mendapatkan rekomendasi latihan</p>
                </div>

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

                <form action="{{ route('public.self-assessment.process') }}" method="POST" class="assessment-form">
                    @csrf
                    
                    <!-- Step 1: Data Diri -->
                    <div class="form-step active" id="step-1">
                        <div class="step-header">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3 class="step-title">Data Diri</h3>
                                <p class="step-description">Informasi dasar pasien</p>
                            </div>
                        </div>
                        
                        <div class="step-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama Lengkap *</label>
                                    <input type="text" name="nama" id="nama" 
                                           class="form-input {{ $errors->has('nama') ? 'error' : '' }}"
                                           value="{{ old('nama') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir *</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                           class="form-input {{ $errors->has('tanggal_lahir') ? 'error' : '' }}"
                                           value="{{ old('tanggal_lahir') }}" required>
                                </div>
                                <div class="form-group md:col-span-2">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" 
                                            class="form-select {{ $errors->has('jenis_kelamin') ? 'error' : '' }}" required>
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="step-actions">
                                <button type="button" class="btn-next" onclick="nextStep(2)">
                                    Selanjutnya <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Barthel Index -->
                    <div class="form-step" id="step-2">
                        <div class="step-header">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3 class="step-title">Barthel Index (ADL)</h3>
                                <p class="step-description">Aktivitas kehidupan sehari-hari</p>
                            </div>
                        </div>
                        
                        <div class="step-body">
                            <div class="test-info">
                                <div class="test-icon">
                                    <i class="fa fa-clipboard-list"></i>
                                </div>
                                <div class="test-content">
                                    <h4>Petunjuk Barthel Index</h4>
                                    <p>Berikan skor 0-100 berdasarkan kemampuan aktivitas sehari-hari. Skor 100 = independen, 0-20 = ketergantungan total.</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="barthel_index" class="form-label">Total Skor Barthel Index</label>
                                <input type="number" name="barthel_index" id="barthel_index" 
                                       class="form-input {{ $errors->has('barthel_index') ? 'error' : '' }}"
                                       value="{{ old('barthel_index') }}" 
                                       min="0" max="100" placeholder="0-100">
                                <p class="form-help">Kosongkan jika tidak memiliki data</p>
                            </div>
                            
                            <div class="step-actions">
                                <button type="button" class="btn-prev" onclick="prevStep(1)">
                                    <i class="fa fa-arrow-left"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn-next" onclick="nextStep(3)">
                                    Selanjutnya <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: 2-Minute Step Test -->
                    <div class="form-step" id="step-3">
                        <div class="step-header">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3 class="step-title">2-Minute Step Test</h3>
                                <p class="step-description">Tes ketahanan kardiorespirasi</p>
                            </div>
                        </div>
                        
                        <div class="step-body">
                            <div class="test-info">
                                <div class="test-icon">
                                    <i class="fa fa-walking"></i>
                                </div>
                                <div class="test-content">
                                    <h4>Petunjuk 2-Minute Step Test</h4>
                                    <p>Hitung jumlah langkah dalam 2 menit. Berdiri di tempat dan angkat lutut setinggi pinggang.</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="step_test" class="form-label">Jumlah Langkah dalam 2 Menit</label>
                                <input type="number" name="step_test" id="step_test" 
                                       class="form-input {{ $errors->has('step_test') ? 'error' : '' }}"
                                       value="{{ old('step_test') }}" 
                                       min="0" placeholder="Contoh: 75">
                                <p class="form-help">Kosongkan jika tidak memiliki data</p>
                            </div>
                            
                            <div class="step-actions">
                                <button type="button" class="btn-prev" onclick="prevStep(2)">
                                    <i class="fa fa-arrow-left"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn-next" onclick="nextStep(4)">
                                    Selanjutnya <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Single Leg Balance -->
                    <div class="form-step" id="step-4">
                        <div class="step-header">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h3 class="step-title">Single Leg Balance</h3>
                                <p class="step-description">Tes keseimbangan dengan mata terbuka</p>
                            </div>
                        </div>
                        
                        <div class="step-body">
                            <div class="test-info">
                                <div class="test-icon">
                                    <i class="fa fa-balance-scale"></i>
                                </div>
                                <div class="test-content">
                                    <h4>Petunjuk Single Leg Balance</h4>
                                    <p>Ukur waktu berdiri satu kaki dengan mata terbuka. Catat dalam detik.</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="single_leg_open" class="form-label">Waktu Berdiri Satu Kaki (detik)</label>
                                <input type="number" name="single_leg_open" id="single_leg_open" 
                                       class="form-input {{ $errors->has('single_leg_open') ? 'error' : '' }}"
                                       value="{{ old('single_leg_open') }}" 
                                       min="0" step="0.1" placeholder="Contoh: 15.5">
                                <p class="form-help">Kosongkan jika tidak memiliki data</p>
                            </div>
                            
                            <div class="step-actions">
                                <button type="button" class="btn-prev" onclick="prevStep(3)">
                                    <i class="fa fa-arrow-left"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn-next" onclick="nextStep(5)">
                                    Selanjutnya <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Five Times Sit to Stand -->
                    <div class="form-step" id="step-5">
                        <div class="step-header">
                            <div class="step-number">5</div>
                            <div class="step-content">
                                <h3 class="step-title">Five Times Sit to Stand</h3>
                                <p class="step-description">Tes kekuatan otot ekstremitas bawah</p>
                            </div>
                        </div>
                        
                        <div class="step-body">
                            <div class="test-info">
                                <div class="test-icon">
                                    <i class="fa fa-chair"></i>
                                </div>
                                <div class="test-content">
                                    <h4>Petunjuk Five Times Sit to Stand</h4>
                                    <p>Ukur waktu untuk melakukan 5 kali duduk-berdiri. Catat dalam detik.</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="sit_to_stand" class="form-label">Waktu 5x Duduk-Berdiri (detik)</label>
                                <input type="number" name="sit_to_stand" id="sit_to_stand" 
                                       class="form-input {{ $errors->has('sit_to_stand') ? 'error' : '' }}"
                                       value="{{ old('sit_to_stand') }}" 
                                       min="0" step="0.1" placeholder="Contoh: 12.3">
                                <p class="form-help">Kosongkan jika tidak memiliki data</p>
                            </div>
                            
                            <div class="step-actions">
                                <button type="button" class="btn-prev" onclick="prevStep(4)">
                                    <i class="fa fa-arrow-left"></i> Sebelumnya
                                </button>
                                <button type="submit" class="btn-submit">
                                    <i class="fa fa-calculator"></i> Hitung Hasil & Rekomendasi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="info-card">
                    <h6 class="info-title">
                        <i class="fa fa-info-circle"></i> Informasi Self-Assessment
                    </h6>
                    <ul class="info-list">
                        <li>Hasil pemeriksaan akan langsung ditampilkan tanpa disimpan ke database</li>
                        <li>Rekomendasi video latihan akan disesuaikan dengan hasil klasifikasi</li>
                        <li>Untuk pemeriksaan resmi, silakan hubungi admin atau yayasan terdekat</li>
                        <li>Data yang diinput bersifat sementara dan tidak akan tersimpan</li>
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
        
        /* Assessment Section */
        .assessment-section {
            padding: 4rem 0;
            background: #f8fafc;
        }
        
        .assessment-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .assessment-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .assessment-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Form Steps */
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .form-step.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .step-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 15px;
            border: 1px solid #bae6fd;
        }
        
        .step-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            margin-right: 1rem;
        }
        
        .step-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }
        
        .step-description {
            color: #64748b;
            margin: 0;
        }
        
        .step-body {
            padding: 0 1rem;
        }
        
        /* Test Info */
        .test-info {
            display: flex;
            align-items: flex-start;
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }
        
        .test-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .test-content h4 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .test-content p {
            color: #64748b;
            margin: 0;
            line-height: 1.6;
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
        
        .form-input,
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #20B2AA;
            background: white;
            box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
        }
        
        .form-input.error,
        .form-select.error {
            border-color: #ef4444;
        }
        
        .form-help {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.25rem;
        }
        
        /* Step Actions */
        .step-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn-prev,
        .btn-next,
        .btn-submit {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .btn-prev {
            background: #f1f5f9;
            color: #64748b;
        }
        
        .btn-prev:hover {
            background: #e2e8f0;
            color: #475569;
        }
        
        .btn-next {
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
        }
        
        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 178, 170, 0.3);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
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
        
        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #bae6fd;
            margin-top: 2rem;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .assessment-title {
                font-size: 2rem;
            }
            
            .assessment-card {
                padding: 2rem 1.5rem;
            }
            
            .step-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn-prev,
            .btn-next,
            .btn-submit {
                width: 100%;
                justify-content: center;
            }
            
            .test-info {
                flex-direction: column;
                text-align: center;
            }
            
            .test-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
    
    <!-- Custom JavaScript -->
    <script>
        function nextStep(step) {
            // Hide current step
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            
            // Show next step
            document.getElementById('step-' + step).classList.add('active');
            
            // Scroll to top of form
            document.querySelector('.assessment-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }
        
        function prevStep(step) {
            // Hide current step
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            
            // Show previous step
            document.getElementById('step-' + step).classList.add('active');
            
            // Scroll to top of form
            document.querySelector('.assessment-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }
    </script>
</x-app-layout>
