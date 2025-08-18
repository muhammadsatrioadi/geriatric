@extends('foundation.layouts.layout')

@section('foundation_title', 'Tambah Pasien')
@section('foundation_page_title', 'Tambah Pasien Baru')

@section('foundation_layout')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-plus"></i> Tambah Pasien Baru
                    </h4>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('foundation.pasiens.store') }}" method="POST" 
                          onsubmit="return confirm('Apakah anda yakin ingin menyimpan data ini?')">
                        @csrf
                        
                        <!-- Patient Information -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fa fa-user"></i> Informasi Pasien
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama Lengkap *</label>
                                        <input type="text" name="nama" id="nama" 
                                               class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                                               value="{{ old('nama') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik" class="form-label">NIK *</label>
                                        <input type="text" name="nik" id="nik" 
                                               class="form-control {{ $errors->has('nik') ? 'is-invalid' : '' }}"
                                               value="{{ old('nik') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir *</label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                               class="form-control {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}"
                                               value="{{ old('tanggal_lahir') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" 
                                                class="form-select {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" required>
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Physical Information -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fa fa-heartbeat"></i> Data Fisik
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                        <input type="number" name="berat_badan" id="berat_badan" 
                                               class="form-control {{ $errors->has('berat_badan') ? 'is-invalid' : '' }}"
                                               value="{{ old('berat_badan') }}" step="0.1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" name="tinggi_badan" id="tinggi_badan" 
                                               class="form-control {{ $errors->has('tinggi_badan') ? 'is-invalid' : '' }}"
                                               value="{{ old('tinggi_badan') }}" step="0.1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tekanan_darah" class="form-label">Tekanan Darah</label>
                                        <input type="text" name="tekanan_darah" id="tekanan_darah" 
                                               class="form-control {{ $errors->has('tekanan_darah') ? 'is-invalid' : '' }}"
                                               value="{{ old('tekanan_darah') }}" placeholder="Contoh: 120/80">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kategori_stroke" class="form-label">Kategori Stroke</label>
                                        <select name="kategori_stroke" id="kategori_stroke" 
                                                class="form-select {{ $errors->has('kategori_stroke') ? 'is-invalid' : '' }}">
                                            <option value="">Pilih kategori</option>
                                            <option value="Ringan" {{ old('kategori_stroke') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                            <option value="Sedang" {{ old('kategori_stroke') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                            <option value="Berat" {{ old('kategori_stroke') == 'Berat' ? 'selected' : '' }}>Berat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="riwayat_jatuh" class="form-label">Riwayat Jatuh</label>
                                        <select name="riwayat_jatuh" id="riwayat_jatuh" 
                                                class="form-select {{ $errors->has('riwayat_jatuh') ? 'is-invalid' : '' }}">
                                            <option value="">Pilih riwayat</option>
                                            <option value="Tidak ada" {{ old('riwayat_jatuh') == 'Tidak ada' ? 'selected' : '' }}>Tidak ada</option>
                                            <option value="1-2 kali" {{ old('riwayat_jatuh') == '1-2 kali' ? 'selected' : '' }}>1-2 kali</option>
                                            <option value="3-5 kali" {{ old('riwayat_jatuh') == '3-5 kali' ? 'selected' : '' }}>3-5 kali</option>
                                            <option value=">5 kali" {{ old('riwayat_jatuh') == '>5 kali' ? 'selected' : '' }}>>5 kali</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Test Results -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fa fa-clipboard-check"></i> Hasil Pemeriksaan
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="barthel_index" class="form-label">Barthel Index (0-100)</label>
                                        <input type="number" name="barthel_index" id="barthel_index" 
                                               class="form-control {{ $errors->has('barthel_index') ? 'is-invalid' : '' }}"
                                               value="{{ old('barthel_index') }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="step_test" class="form-label">2-Minute Step Test (langkah)</label>
                                        <input type="number" name="step_test" id="step_test" 
                                               class="form-control {{ $errors->has('step_test') ? 'is-invalid' : '' }}"
                                               value="{{ old('step_test') }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="single_leg_open" class="form-label">Single Leg Balance (detik)</label>
                                        <input type="number" name="single_leg_open" id="single_leg_open" 
                                               class="form-control {{ $errors->has('single_leg_open') ? 'is-invalid' : '' }}"
                                               value="{{ old('single_leg_open') }}" min="0" step="0.1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sit_to_stand" class="form-label">Five Times Sit to Stand (detik)</label>
                                        <input type="number" name="sit_to_stand" id="sit_to_stand" 
                                               class="form-control {{ $errors->has('sit_to_stand') ? 'is-invalid' : '' }}"
                                               value="{{ old('sit_to_stand') }}" min="0" step="0.1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Public Visibility -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fa fa-globe"></i> Pengaturan Publik
                            </h5>
                            <div class="form-check">
                                <input type="checkbox" name="public_visible" id="public_visible" 
                                       class="form-check-input" value="1" 
                                       {{ old('public_visible') ? 'checked' : '' }}>
                                <label for="public_visible" class="form-check-label">
                                    <strong>Publikasikan data pasien</strong>
                                    <br>
                                    <small class="text-muted">
                                        Jika dicentang, data pasien dapat dicari oleh publik menggunakan 
                                        "Nama Yayasan - Nama Pasien"
                                    </small>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan Data Pasien
                            </button>
                            <a href="{{ route('foundation.pasiens') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }
        
        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #20B2AA;
            box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
        }
        
        .form-check-input:checked {
            background-color: #20B2AA;
            border-color: #20B2AA;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn {
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #20B2AA 0%, #1E3A8A 100%);
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 178, 170, 0.3);
        }
        
        .btn-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
            color: #475569;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
        }
        
        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection
