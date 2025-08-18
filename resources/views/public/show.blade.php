<x-app-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content text-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h1 class="hero-title">
                    Data Pasien & Video Latihan
                </h1>
                <p class="hero-subtitle">
                    Informasi lengkap pasien dan rekomendasi video latihan yang disesuaikan
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content-section">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Patient Information Card -->
            <div class="patient-card mb-8">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fa fa-user"></i> {{ $pasien->nama }}
                    </h2>
                    @if($pasien->foundation)
                        <div class="foundation-badge">
                            <i class="fa fa-building"></i> {{ $pasien->foundation->name }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="patient-info">
                        <!-- Basic Information -->
                        <div class="info-group">
                            <h4 class="info-group-title">Informasi Dasar</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label class="info-label">Nama</label>
                                    <span class="info-value">{{ $pasien->nama }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">NIK</label>
                                    <span class="info-value">{{ $pasien->nik }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Jenis Kelamin</label>
                                    <span class="info-value">{{ $pasien->jenis_kelamin }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Tanggal Lahir</label>
                                    <span class="info-value">{{ $pasien->tanggal_lahir->format('d/m/Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Umur</label>
                                    <span class="info-value">{{ $pasien->tanggal_lahir->age }} tahun</span>
                                </div>
                            </div>
                        </div>

                        <!-- Physical Information -->
                        <div class="info-group">
                            <h4 class="info-group-title">Data Fisik</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label class="info-label">Berat Badan</label>
                                    <span class="info-value">{{ $pasien->berat_badan ? $pasien->berat_badan . ' kg' : 'Belum diisi' }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Tinggi Badan</label>
                                    <span class="info-value">{{ $pasien->tinggi_badan ? $pasien->tinggi_badan . ' cm' : 'Belum diisi' }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Tekanan Darah</label>
                                    <span class="info-value">{{ $pasien->tekanan_darah ?: 'Belum diisi' }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Kategori Stroke</label>
                                    <span class="info-value">{{ $pasien->kategori_stroke ?: 'Belum diisi' }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="info-label">Riwayat Jatuh</label>
                                    <span class="info-value">{{ $pasien->riwayat_jatuh ?: 'Belum diisi' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Classification -->
                    <div class="classification-section">
                        <div class="classification-content">
                            <div class="classification-info">
                                <h4 class="classification-title">Klasifikasi Keseluruhan</h4>
                                <p class="classification-description">Berdasarkan hasil pemeriksaan komprehensif</p>
                            </div>
                            <div class="classification-badge classification-{{ strtolower($pasien->klasifikasi) }}">
                                <div class="classification-icon">
                                    @if($pasien->klasifikasi == 'Ringan')
                                        <i class="fa fa-smile"></i>
                                    @elseif($pasien->klasifikasi == 'Sedang')
                                        <i class="fa fa-meh"></i>
                                    @else
                                        <i class="fa fa-frown"></i>
                                    @endif
                                </div>
                                <span class="classification-text">{{ $pasien->klasifikasi }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Results Section -->
            <div class="test-section mb-8">
                <h3 class="section-title">
                    <i class="fa fa-clipboard-check"></i> Hasil Pemeriksaan 4 Tes
                </h3>
                <div class="test-grid">
                    @php
                        $age = $pasien->tanggal_lahir->age;
                        $gender = $pasien->jenis_kelamin;
                    @endphp

                    <!-- Barthel Index -->
                    <div class="test-card">
                        <div class="test-header">
                            <div class="test-icon">
                                <i class="fa fa-clipboard-list"></i>
                            </div>
                            <h4 class="test-title">Barthel Index</h4>
                        </div>
                        <div class="test-content">
                            <div class="test-stat">
                                <span class="stat-label">Nilai:</span>
                                <span class="stat-value">{{ $pasien->barthel_index ?? 'Tidak ada data' }}</span>
                            </div>
                            <div class="test-stat">
                                <span class="stat-label">Status:</span>
                                @if($pasien->barthel_index !== null)
                                    @if(\App\Helpers\PemeriksaanHelper::isBarthelNormal($pasien->barthel_index))
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
                    <div class="test-card">
                        <div class="test-header">
                            <div class="test-icon">
                                <i class="fa fa-walking"></i>
                            </div>
                            <h4 class="test-title">2-Minute Step Test</h4>
                        </div>
                        <div class="test-content">
                            <div class="test-stat">
                                <span class="stat-label">Nilai:</span>
                                <span class="stat-value">{{ $pasien->step_test ?? 'Tidak ada data' }}</span>
                            </div>
                            <div class="test-stat">
                                <span class="stat-label">Status:</span>
                                @if($pasien->step_test !== null)
                                    @if(\App\Helpers\PemeriksaanHelper::isStepTestNormal($pasien->step_test))
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
                    <div class="test-card">
                        <div class="test-header">
                            <div class="test-icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <h4 class="test-title">Single Leg Balance</h4>
                        </div>
                        <div class="test-content">
                            <div class="test-stat">
                                <span class="stat-label">Nilai:</span>
                                <span class="stat-value">{{ $pasien->single_leg_open ?? 'Tidak ada data' }} detik</span>
                            </div>
                            <div class="test-stat">
                                <span class="stat-label">Status:</span>
                                @if($pasien->single_leg_open !== null)
                                    @if(\App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open))
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
                    <div class="test-card">
                        <div class="test-header">
                            <div class="test-icon">
                                <i class="fa fa-chair"></i>
                            </div>
                            <h4 class="test-title">Five Times Sit to Stand</h4>
                        </div>
                        <div class="test-content">
                            <div class="test-stat">
                                <span class="stat-label">Nilai:</span>
                                <span class="stat-value">{{ $pasien->sit_to_stand ?? 'Tidak ada data' }} detik</span>
                            </div>
                            <div class="test-stat">
                                <span class="stat-label">Status:</span>
                                @if($pasien->sit_to_stand !== null)
                                    @if(\App\Helpers\PemeriksaanHelper::isSitToStandNormal($pasien->sit_to_stand))
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

            <!-- Video Recommendations Section -->
            <div class="video-section mb-8">
                <h3 class="section-title">
                    <i class="fa fa-video"></i> Video Rekomendasi Latihan
                </h3>
                
                <!-- Overall Video -->
                @if($overallVideo)
                <div class="video-card mb-6">
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
                <div class="video-card">
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

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('home') }}" class="btn-primary">
                    <i class="fa fa-search"></i> Cari Pasien Lain
                </a>
                <a href="{{ route('public.self-assessment.index') }}" class="btn-secondary">
                    <i class="fa fa-clipboard-check"></i> Self-Assessment
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
        
        /* Content Section */
        .content-section {
            padding: 4rem 0;
            background: #f8fafc;
        }
        
        /* Patient Card */
        .patient-card {
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
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
        
        .foundation-badge {
            background: rgba(32, 178, 170, 0.1);
            color: #20B2AA;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        /* Patient Info */
        .patient-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .info-group {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }
        
        .info-group-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .info-grid {
            display: grid;
            gap: 0.75rem;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #64748b;
        }
        
        .info-value {
            font-weight: 700;
            color: #1e293b;
        }
        
        /* Classification */
        .classification-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #bae6fd;
        }
        
        .classification-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .classification-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .classification-description {
            color: #64748b;
            margin: 0;
        }
        
        .classification-badge {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            border-radius: 15px;
            color: white;
            font-weight: 700;
            font-size: 1.125rem;
        }
        
        .classification-ringan {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        
        .classification-sedang {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }
        
        .classification-berat {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }
        
        .classification-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        /* Test Section */
        .test-section {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .test-card {
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
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .test-content {
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
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .video-card {
            margin-bottom: 2rem;
        }
        
        .video-card:last-child {
            margin-bottom: 0;
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
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .classification-content {
                flex-direction: column;
                text-align: center;
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
</x-app-layout>
