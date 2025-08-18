<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien - {{ Auth::user()->foundation->name }}</title>
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
        .form-control, .form-select {
            border-radius: 8px;
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
                    <h2><i class="fas fa-edit"></i> Edit Data Pasien</h2>
                    <a href="{{ route('foundation.pasiens') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('foundation.pasiens.update', $pasien->id) }}" method="POST" 
                      onsubmit="return confirm('Apakah anda yakin ingin menyimpan perubahan ini?')">
                    @csrf
                    @method('PUT')
                    
                    <!-- Detail Pasien -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user"></i> Detail Pasien
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="nama" class="form-label">Nama *</label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" 
                                        placeholder="Masukkan Nama" value="{{ old('nama', $pasien->nama) }}" required />
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="nik" class="form-label">NIK *</label>
                                    <input type="text" name="nik" id="nik" 
                                        class="form-control @error('nik') is-invalid @enderror"
                                        placeholder="Masukkan NIK" value="{{ old('nik', $pasien->nik) }}" required />
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
                                        <option value="" disabled>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir *</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir', $pasien->tanggal_lahir->format('Y-m-d')) }}" required />
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="berat_badan" class="form-label">Berat Badan</label>
                                    <div class="input-group">
                                        <input type="number" name="berat_badan" id="berat_badan"
                                            class="form-control @error('berat_badan') is-invalid @enderror"
                                            placeholder="Masukkan Berat Badan" value="{{ old('berat_badan', $pasien->berat_badan) }}" />
                                        <span class="input-group-text">Kg</span>
                                    </div>
                                    @error('berat_badan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                                    <div class="input-group">
                                        <input type="number" name="tinggi_badan" id="tinggi_badan"
                                            class="form-control @error('tinggi_badan') is-invalid @enderror"
                                            placeholder="Masukkan Tinggi Badan" value="{{ old('tinggi_badan', $pasien->tinggi_badan) }}" />
                                        <span class="input-group-text">cm</span>
                                    </div>
                                    @error('tinggi_badan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="tekanan_darah" class="form-label">Tekanan Darah</label>
                                    <div class="input-group">
                                        <input type="text" name="tekanan_darah" id="tekanan_darah"
                                            class="form-control @error('tekanan_darah') is-invalid @enderror"
                                            placeholder="Masukkan Tekanan Darah" value="{{ old('tekanan_darah', $pasien->tekanan_darah) }}" />
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                    @error('tekanan_darah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="kategori_stroke" class="form-label">Kategori Stroke</label>
                                    <select class="form-select @error('kategori_stroke') is-invalid @enderror" name="kategori_stroke">
                                        <option value="" disabled>Pilih Kategori Stroke</option>
                                        <option value="Pra" {{ old('kategori_stroke', $pasien->kategori_stroke) == 'Pra' ? 'selected' : '' }}>Pra</option>
                                        <option value="Sedang" {{ old('kategori_stroke', $pasien->kategori_stroke) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="Pasca" {{ old('kategori_stroke', $pasien->kategori_stroke) == 'Pasca' ? 'selected' : '' }}>Pasca</option>
                                    </select>
                                    @error('kategori_stroke')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="riwayat_jatuh" class="form-label">Pernah Jatuh?</label>
                                    <select class="form-select @error('riwayat_jatuh') is-invalid @enderror" name="riwayat_jatuh">
                                        <option value="" disabled>Pilih Opsi</option>
                                        <option value="Pernah" {{ old('riwayat_jatuh', $pasien->riwayat_jatuh) == 'Pernah' ? 'selected' : '' }}>Pernah</option>
                                        <option value="Tidak" {{ old('riwayat_jatuh', $pasien->riwayat_jatuh) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                    @error('riwayat_jatuh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="public_visible" id="public_visible" 
                                               value="1" {{ old('public_visible', $pasien->public_visible) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="public_visible">
                                            Tampilkan di Pencarian Publik
                                        </label>
                                    </div>
                                    <small class="text-muted">Centang jika data pasien boleh dicari oleh keluarga di halaman publik</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Pemeriksaan -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-check"></i> Hasil Pemeriksaan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="barthel_index" class="form-label">Index Barthel</label>
                                    <div class="input-group">
                                        <input type="number" name="barthel_index" id="barthel_index"
                                            class="form-control @error('barthel_index') is-invalid @enderror"
                                            placeholder="Masukkan Index Barthel" value="{{ old('barthel_index', $pasien->barthel_index) }}" />
                                        <span class="input-group-text">pt</span>
                                    </div>
                                    @error('barthel_index')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="step_test" class="form-label">2-Minute Step Test</label>
                                    <div class="input-group">
                                        <input type="number" name="step_test" id="step_test"
                                            class="form-control @error('step_test') is-invalid @enderror"
                                            placeholder="Masukkan Jumlah Langkah" value="{{ old('step_test', $pasien->step_test) }}" />
                                        <span class="input-group-text">langkah</span>
                                    </div>
                                    @error('step_test')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="single_leg_open" class="form-label">Single Leg Balance (Mata Terbuka)</label>
                                    <div class="input-group">
                                        <input type="number" name="single_leg_open" id="single_leg_open"
                                            class="form-control @error('single_leg_open') is-invalid @enderror"
                                            placeholder="Durasi (detik)" value="{{ old('single_leg_open', $pasien->single_leg_open) }}" />
                                        <span class="input-group-text">detik</span>
                                    </div>
                                    @error('single_leg_open')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="single_leg_closed" class="form-label">Single Leg Balance (Mata Tertutup)</label>
                                    <div class="input-group">
                                        <input type="number" name="single_leg_closed" id="single_leg_closed"
                                            class="form-control @error('single_leg_closed') is-invalid @enderror"
                                            placeholder="Durasi (detik)" value="{{ old('single_leg_closed', $pasien->single_leg_closed) }}" />
                                        <span class="input-group-text">detik</span>
                                    </div>
                                    @error('single_leg_closed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="sit_to_stand" class="form-label">Five Times Sit to Stand</label>
                                    <div class="input-group">
                                        <input type="number" name="sit_to_stand" id="sit_to_stand" step="any"
                                            class="form-control @error('sit_to_stand') is-invalid @enderror"
                                            placeholder="Durasi dalam detik" value="{{ old('sit_to_stand', $pasien->sit_to_stand) }}" />
                                        <span class="input-group-text">detik</span>
                                    </div>
                                    @error('sit_to_stand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('foundation.pasiens.show', $pasien->id) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                                <a href="{{ route('foundation.pasiens') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
