<x-app-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content text-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h1 class="hero-title">
                    Hasil Self-Assessment
                </h1>
                <p class="hero-subtitle">
                    Berikut adalah hasil pemeriksaan dan rekomendasi latihan untuk {{ $tempPatient->nama }}
                </p>
            </div>
        </div>
    </section>

    <!-- Result Section -->
    <section class="result-section">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Patient Info Card -->
            <div class="result-card mb-8">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fa fa-user"></i> Informasi Pasien
                    </h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="info-item">
                            <label class="info-label">Nama Lengkap</label>
                            <p class="info-value">{{ $tempPatient->nama }}</p>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Tanggal Lahir</label>
                            <p class="info-value">{{ $tempPatient->tanggal_lahir->format('d/m/Y') }} ({{ $tempPatient->tanggal_lahir->age }} tahun)</p>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Jenis Kelamin</label>
                            <p class="info-value">{{ $tempPatient->jenis_kelamin }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classification Result -->
            <div class="result-card mb-8">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fa fa-chart-line"></i> Hasil Klasifikasi
                    </h2>
                </div>
                <div class="card-body">
                    <div class="classification-result">
                        <div class="classification-badge classification-{{ strtolower($classification) }}">
                            <div class="classification-icon">
                                @if($classification == 'Ringan')
                                    <i class="fa fa-smile"></i>
                                @elseif($classification == 'Sedang')
                                    <i class="fa fa-meh"></i>
                                @else
                                    <i class="fa fa-frown"></i>
                                @endif
                            </div>
                            <div class="classification-content">
                                <h3 class="classification-title">{{ $classification }}</h3>
                                <p class="classification-description">
                                    @if($classification == 'Ringan')
                                        Tingkat fungsional tinggi dengan kemampuan yang baik
                                    @elseif($classification == 'Sedang')
                                        Tingkat fungsional sedang dengan beberapa keterbatasan
                                    @else
                                        Tingkat fungsional rendah memerlukan bantuan dan latihan intensif
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Results -->
            <div class="result-card mb-8">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fa fa-clipboard-check"></i> Hasil Tes Fungsional
                    </h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Barthel Index -->
                        <div class="test-result">
                            <div class="test-header">
                                <div class="test-icon">
                                    <i class="fa fa-clipboard-list"></i>
                                </div>
                                <h4 class="test-title">Barthel Index</h4>
                            </div>
                            <div class="test-details">
                                <div class="test-stat">
                                    <span class="stat-label">Nilai:</span>
                                    <span class="stat-value">{{ $tempPatient->barthel_index ?? 'Tidak ada data' }}</span>
                                </div>
                                <div class="test-stat">
                                    <span class="stat-label">Status:</span>
                                    @if($tempPatient->barthel_index !== null)
                                        @if(\App\Helpers\PemeriksaanHelper::isBarthelNormal($tempPatient->barthel_index))
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Normal</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">Tidak ada data</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- 2-Minute Step Test -->
                        <div class="test-result">
                            <div class="test-header">
                                <div class="test-icon">
                                    <i class="fa fa-walking"></i>
                                </div>
                                <h4 class="test-title">2-Minute Step Test</h4>
                            </div>
                            <div class="test-details">
                                <div class="test-stat">
                                    <span class="stat-label">Nilai:</span>
                                    <span class="stat-value">{{ $tempPatient->step_test ?? 'Tidak ada data' }}</span>
                                </div>
                                <div class="test-stat">
                                    <span class="stat-label">Status:</span>
                                    @if($tempPatient->step_test !== null)
                                        @if(\App\Helpers\PemeriksaanHelper::isStepTestNormal($tempPatient->step_test))
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Normal</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">Tidak ada data</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Single Leg Balance -->
                        <div class="test-result">
                            <div class="test-header">
                                <div class="test-icon">
                                    <i class="fa fa-balance-scale"></i>
                                </div>
                                <h4 class="test-title">Single Leg Balance</h4>
                            </div>
                            <div class="test-details">
                                <div class="test-stat">
                                    <span class="stat-label">Nilai:</span>
                                    <span class="stat-value">{{ $tempPatient->single_leg_open ?? 'Tidak ada data' }} detik</span>
                                </div>
                                <div class="test-stat">
                                    <span class="stat-label">Status:</span>
                                    @if($tempPatient->single_leg_open !== null)
                                        @if(\App\Helpers\PemeriksaanHelper::isSingleLegNormal($tempPatient->single_leg_open))
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Normal</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">Tidak ada data</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Five Times Sit to Stand -->
                        <div class="test-result">
                            <div class="test-header">
                                <div class="test-icon">
                                    <i class="fa fa-chair"></i>
                                </div>
                                <h4 class="test-title">Five Times Sit to Stand</h4>
                            </div>
                            <div class="test-details">
                                <div class="test-stat">
                                    <span class="stat-label">Nilai:</span>
                                    <span class="stat-value">{{ $tempPatient->sit_to_stand ?? 'Tidak ada data' }} detik</span>
                                </div>
                                <div class="test-stat">
                                    <span class="stat-label">Status:</span>
                                    @if($tempPatient->sit_to_stand !== null)
                                        @if(\App\Helpers\PemeriksaanHelper::isSitToStandNormal($tempPatient->sit_to_stand))
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Normal</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">Tidak ada data</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Recommendations -->
            <div class="result-card mb-8">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fa fa-video"></i> Video Rekomendasi Latihan
                    </h2>
                </div>
                <div class="card-body">
                    <!-- Overall Video -->
                    @if($overallVideo)
                    <div class="video-section mb-6">
                        <h4 class="video-title">
                            <i class="fa fa-play-circle"></i> Video Rekomendasi Keseluruhan
                        </h4>
                        <div class="video-container">
                            <iframe src="{{ $overallVideo->video_url }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                        <div class="video-info">
                            <h5>{{ $overallVideo->title }}</h5>
                            <p>{{ $overallVideo->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Per Test Videos -->
                    @if(count($perTestVideos) > 0)
                    <div class="video-section">
                        <h4 class="video-title">
                            <i class="fa fa-list"></i> Video Rekomendasi Per Tes
                        </h4>
                        <div class="video-grid">
                            @foreach($perTestVideos as $video)
                            <div class="video-item">
                                <div class="video-container">
                                    <iframe src="{{ $video->video_url }}" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="video-info">
                                    <h5>{{ $video->title }}</h5>
                                    <p>{{ $video->description }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('public.self-assessment.index') }}" class="btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali ke Self-Assessment
                </a>
                <a href="{{ route('home') }}" class="btn-primary">
                    <i class="fa fa-home"></i> Kembali ke Beranda
                </a>
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
        
        /* Result Section */
        .result-section {
            padding: 4rem 0;
            background: #f8fafc;
        }
        
        .result-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #bae6fd;
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        /* Patient Info */
        .info-item {
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        
        .info-label {
            display: block;
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .info-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        /* Classification */
        .classification-result {
            text-align: center;
        }
        
        .classification-badge {
            display: inline-flex;
            align-items: center;
            gap: 1.5rem;
            padding: 2rem;
            border-radius: 20px;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .classification-ringan {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
        }
        
        .classification-sedang {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
        }
        
        .classification-berat {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: white;
        }
        
        .classification-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
        }
        
        .classification-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .classification-description {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }
        
        /* Test Results */
        .test-result {
            background: #f8fafc;
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        
        .test-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
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
        }
        
        .test-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .test-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .test-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .test-stat:last-child {
            border-bottom: none;
        }
        
        .stat-label {
            font-weight: 600;
            color: #64748b;
        }
        
        .stat-value {
            font-weight: 700;
            color: #1e293b;
        }
        
        /* Badges */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #10B981;
            color: white;
        }
        
        .badge-danger {
            background: #EF4444;
            color: white;
        }
        
        .badge-secondary {
            background: #6B7280;
            color: white;
        }
        
        /* Video Section */
        .video-section {
            margin-bottom: 2rem;
        }
        
        .video-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .video-container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .video-info h5 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .video-info p {
            color: #64748b;
            margin: 0;
            line-height: 1.6;
        }
        
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .video-item {
            background: #f8fafc;
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
        }
        
        .btn-primary,
        .btn-secondary {
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 178, 170, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
            color: #475569;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .classification-badge {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }
            
            .video-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    <!-- Custom JavaScript -->
    <script src="{{ asset('resource/js/geriatric-care-public.js') }}"></script>
</x-app-layout>
