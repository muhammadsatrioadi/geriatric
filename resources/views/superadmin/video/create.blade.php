@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Upload Video
@endsection
@section('superadmin_page_title')
    Upload Video Baru
@endsection
@section('superadmin_layout')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Upload Video Latihan</div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('superadmin.videos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judul">Judul Video *</label>
                                <input type="text" name="judul"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    placeholder="Masukkan judul video" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                    placeholder="Deskripsi video (opsional)">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis">Jenis Video *</label>
                                <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                                    <option value="">Pilih jenis video</option>
                                    <option value="global" {{ old('jenis') == 'global' ? 'selected' : '' }}>Global (Umum)
                                    </option>
                                    <option value="khusus" {{ old('jenis') == 'khusus' ? 'selected' : '' }}>Khusus Pasien
                                    </option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_type">Kategori Video *</label>
                                <select name="category_type" class="form-control @error('category_type') is-invalid @enderror" required>
                                    <option value="">Pilih kategori</option>
                                    <option value="overall" {{ old('category_type') == 'overall' ? 'selected' : '' }}>Keseluruhan</option>
                                    <option value="per_test" {{ old('category_type') == 'per_test' ? 'selected' : '' }}>Per Tes</option>
                                    <option value="self_assessment" {{ old('category_type') == 'self_assessment' ? 'selected' : '' }}>Self Assessment</option>
                                </select>
                                @error('category_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="test-type-group" style="display: none;">
                                <label for="test_type">Jenis Tes *</label>
                                <select name="test_type" class="form-control @error('test_type') is-invalid @enderror">
                                    <option value="">Pilih jenis tes</option>
                                    <option value="barthel" {{ old('test_type') == 'barthel' ? 'selected' : '' }}>Barthel Index</option>
                                    <option value="two_minute" {{ old('test_type') == 'two_minute' ? 'selected' : '' }}>2-Minute Step Test</option>
                                    <option value="single_leg" {{ old('test_type') == 'single_leg' ? 'selected' : '' }}>Single Leg Balance</option>
                                    <option value="five_stand" {{ old('test_type') == 'five_stand' ? 'selected' : '' }}>Five Times Sit to Stand</option>
                                </select>
                                @error('test_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="level">Level *</label>
                                <select name="level" class="form-control @error('level') is-invalid @enderror" required>
                                    <option value="">Pilih level</option>
                                    <option value="normal" {{ old('level') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="ringan" {{ old('level') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="berat" {{ old('level') == 'berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="klasifikasi-group" style="display: none;">
                                <label for="klasifikasi">Klasifikasi *</label>
                                <select name="klasifikasi" class="form-control @error('klasifikasi') is-invalid @enderror">
                                    <option value="">Pilih klasifikasi</option>
                                    <option value="Tinggi" {{ old('klasifikasi') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                    </option>
                                    <option value="Sedang" {{ old('klasifikasi') == 'Sedang' ? 'selected' : '' }}>Sedang
                                    </option>
                                    <option value="Rendah" {{ old('klasifikasi') == 'Rendah' ? 'selected' : '' }}>Rendah
                                    </option>
                                </select>
                                @error('klasifikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="pasien-group" style="display: none;">
                                <label for="pasien_id">Pilih Pasien *</label>
                                <select name="pasien_id" class="form-control @error('pasien_id') is-invalid @enderror">
                                    <option value="">Pilih pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}"
                                            {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                            {{ $pasien->nama }} ({{ $pasien->classification }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('pasien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="video_file">File Video *</label>
                                <input type="file" name="video_file" id="video_file"
                                    class="form-control @error('video_file') is-invalid @enderror" accept="video/*"
                                    required>
                                <small class="form-text text-muted">
                                    Format yang didukung: MP4, AVI, MOV, WMV. Maksimal 200MB.
                                </small>
                                @error('video_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview area: show video if selected, else prompt -->
                            <div id="video-preview" class="mb-3">
                                <p class="text-center text-muted">Silahkan upload video terlebih dahulu</p>
                            </div>

                            <div class="alert alert-info">
                                <h6><i class="fa fa-info-circle"></i> Petunjuk Upload:</h6>
                                <ul class="mb-0">
                                    <li><strong>Video Global:</strong> Video umum untuk semua pasien dengan klasifikasi
                                        tertentu</li>
                                    <li><strong>Video Khusus:</strong> Video latihan khusus untuk pasien tertentu</li>
                                    <li><strong>Kategori Keseluruhan:</strong> Video untuk klasifikasi umum pasien</li>
                                    <li><strong>Kategori Per Tes:</strong> Video khusus untuk jenis tes tertentu</li>
                                    <li>Pastikan video berkualitas baik dan durasi tidak terlalu panjang</li>
                                    <li>File video akan disimpan di server dan dapat diakses publik</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-upload"></i> Upload Video
                        </button>
                        <a href="{{ route('superadmin.videos.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Video Form JavaScript -->
    <script src="{{ asset('admin/js/video-form.js') }}"></script>
@endsection
