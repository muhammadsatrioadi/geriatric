<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pasien - {{ Auth::user()->foundation->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #34495e;
            color: #fff;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 20px;
        }
        .classification-badge {
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            margin: 1rem 0;
        }
        .classification-tinggi {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
        }
        .classification-sedang {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
        }
        .classification-rendah {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: white;
        }
        .video-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .video-info {
            padding: 1rem;
            background: #f9fafb;
        }
        .video-player {
            padding: 1rem;
        }
        .video-meta {
            margin-top: 0.5rem;
        }
        .video-meta span {
            background: #e5e7eb;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.875rem;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h5 class="text-white mb-4">
                        <i class="fas fa-building"></i> {{ Auth::user()->foundation->name }}
                    </h5>

                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('foundation.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('foundation.pasiens') }}">
                            <i class="fas fa-users"></i> Data Pasien
                        </a>
                        <a class="nav-link" href="{{ route('foundation.pasiens.create') }}">
                            <i class="fas fa-plus"></i> Tambah Pasien
                        </a>
                        <hr class="text-white">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-user"></i> Detail Pasien</h2>
                    <div>
                        <a href="{{ route('foundation.pasiens.manage', $pasien->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('foundation.pasiens') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Patient Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user"></i> Informasi Pasien
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Nama:</strong></td>
                                        <td>{{ $pasien->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIK:</strong></td>
                                        <td>{{ $pasien->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Lahir:</strong></td>
                                        <td>{{ $pasien->tanggal_lahir->format('d/m/Y') }} ({{ $pasien->tanggal_lahir->age }} tahun)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Kelamin:</strong></td>
                                        <td>{{ $pasien->jenis_kelamin }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Berat Badan:</strong></td>
                                        <td>{{ $pasien->berat_badan ?? '-' }} kg</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tinggi Badan:</strong></td>
                                        <td>{{ $pasien->tinggi_badan ?? '-' }} cm</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tekanan Darah:</strong></td>
                                        <td>{{ $pasien->tekanan_darah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Public Visible:</strong></td>
                                        <td>
                                            @if($pasien->public_visible)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classification Result -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line"></i> Hasil Klasifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="classification-badge classification-{{ strtolower($pasien->classification) }}">
                            <h3 class="mb-2">{{ $pasien->classification }}</h3>
                            <p class="mb-0">
                                @if($pasien->classification == 'Tinggi')
                                    Tingkat fungsional tinggi dengan kemampuan yang baik
                                @elseif($pasien->classification == 'Sedang')
                                    Tingkat fungsional sedang dengan beberapa keterbatasan
                                @else
                                    Tingkat fungsional rendah memerlukan bantuan dan latihan intensif
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Test Results -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-check"></i> Hasil Tes Fungsional
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6><i class="fas fa-clipboard-list"></i> Barthel Index</h6>
                                    <p class="mb-1"><strong>Nilai:</strong> {{ $pasien->barthel_index ?? 'Tidak ada data' }}</p>
                                    <p class="mb-0">
                                        <strong>Status:</strong>
                                        @if($pasien->barthel_index !== null)
                                            @if(\App\Helpers\PemeriksaanHelper::isBarthelNormal($pasien->barthel_index))
                                                <span class="badge bg-success">Normal</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Normal</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Tidak ada data</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6><i class="fas fa-walking"></i> 2-Minute Step Test</h6>
                                    <p class="mb-1"><strong>Nilai:</strong> {{ $pasien->step_test ?? 'Tidak ada data' }} langkah</p>
                                    <p class="mb-0">
                                        <strong>Status:</strong>
                                        @if($pasien->step_test !== null)
                                            @if(\App\Helpers\PemeriksaanHelper::isStepNormal($pasien->step_test, $pasien->tanggal_lahir->age, $pasien->jenis_kelamin))
                                                <span class="badge bg-success">Normal</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Normal</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Tidak ada data</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6><i class="fas fa-balance-scale"></i> Single Leg Balance</h6>
                                    <p class="mb-1"><strong>Nilai:</strong> {{ $pasien->single_leg_open ?? 'Tidak ada data' }} detik</p>
                                    <p class="mb-0">
                                        <strong>Status:</strong>
                                        @if($pasien->single_leg_open !== null)
                                            @if(\App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open, $pasien->tanggal_lahir->age, false))
                                                <span class="badge bg-success">Normal</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Normal</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Tidak ada data</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6><i class="fas fa-chair"></i> Five Times Sit to Stand</h6>
                                    <p class="mb-1"><strong>Nilai:</strong> {{ $pasien->sit_to_stand ?? 'Tidak ada data' }} detik</p>
                                    <p class="mb-0">
                                        <strong>Status:</strong>
                                        @if($pasien->sit_to_stand !== null)
                                            @if(\App\Helpers\PemeriksaanHelper::isSitStandNormal($pasien->sit_to_stand, $pasien->tanggal_lahir->age))
                                                <span class="badge bg-success">Normal</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Normal</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Tidak ada data</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Recommendations -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-video"></i> Rekomendasi Video Latihan
                        </h5>
                    </div>
                    <div class="card-body">

                        <!-- Overall Video -->
                        @if($overallVideo)
                        <div class="mb-4">
                            <h6><i class="fas fa-star"></i> Video Rekomendasi Keseluruhan</h6>
                            <div class="video-card">
                                <div class="video-info">
                                    <h6 class="video-title">{{ $overallVideo->judul }}</h6>
                                    <p class="video-description mb-2">{{ $overallVideo->deskripsi }}</p>
                                    <div class="video-meta">
                                        <span>{{ $overallVideo->klasifikasi }}</span>
                                        <span>{{ $overallVideo->category_type_label }}</span>
                                    </div>
                                </div>
                                <div class="video-player">
                                    <video controls class="w-100 rounded">
                                        <source src="{{ $overallVideo->video_url }}" type="video/mp4">
                                        Browser Anda tidak mendukung pemutaran video.
                                    </video>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Per Test Videos -->
                        <div>
                            <h6><i class="fas fa-list"></i> Video Rekomendasi Per Tes</h6>
                            <div class="row">
                                @foreach($perTestVideos as $testType => $video)
                                    @if($video)
                                    <div class="col-md-6 mb-3">
                                        <div class="video-card">
                                            <div class="video-info">
                                                <h6 class="video-title">{{ $video->judul }}</h6>
                                                <p class="video-description mb-2">{{ $video->deskripsi }}</p>
                                                <div class="video-meta">
                                                    <span>{{ $video->test_type_label }}</span>
                                                    <span>{{ $video->level_label }}</span>
                                                </div>
                                            </div>
                                            <div class="video-player">
                                                <video controls class="w-100 rounded">
                                                    <source src="{{ $video->video_url }}" type="video/mp4">
                                                    Browser Anda tidak mendukung pemutaran video.
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        @if(!$overallVideo && empty(array_filter($perTestVideos)))
                        <div class="text-center py-4">
                            <i class="fas fa-video-slash fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Tidak ada video rekomendasi tersedia</h6>
                            <p class="text-muted">Silakan hubungi admin untuk menambahkan video latihan yang sesuai.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
