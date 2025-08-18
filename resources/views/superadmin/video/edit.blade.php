@extends('superadmin.layouts.layout')
@section('superadmin_title', 'Edit Video')
@section('superadmin_page_title', 'Edit Video')
@section('superadmin_layout')
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Video</div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('superadmin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="judul">Judul Video *</label>
                                <input type="text" name="judul" id="judul"
                                    value="{{ old('judul', $video->judul) }}"
                                    class="form-control @error('judul') is-invalid @enderror" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="jenis">Jenis Video *</label>
                                <select name="jenis" id="jenis"
                                    class="form-control @error('jenis') is-invalid @enderror" required>
                                    <option value="">Pilih jenis video</option>
                                    <option value="global" {{ old('jenis', $video->jenis) == 'global' ? 'selected' : '' }}>
                                        Global (Umum)</option>
                                    <option value="khusus" {{ old('jenis', $video->jenis) == 'khusus' ? 'selected' : '' }}>
                                        Khusus</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="category_type">Kategori Video *</label>
                                <select name="category_type" id="category_type"
                                    class="form-control @error('category_type') is-invalid @enderror" required>
                                    <option value="">Pilih kategori</option>
                                    <option value="overall" {{ old('category_type', $video->category_type) == 'overall' ? 'selected' : '' }}>Keseluruhan</option>
                                    <option value="per_test" {{ old('category_type', $video->category_type) == 'per_test' ? 'selected' : '' }}>Per Tes</option>
                                </select>
                                @error('category_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3" id="test-type-group">
                                <label for="test_type">Jenis Tes *</label>
                                <select name="test_type" id="test_type"
                                    class="form-control @error('test_type') is-invalid @enderror">
                                    <option value="">Pilih jenis tes</option>
                                    <option value="barthel" {{ old('test_type', $video->test_type) == 'barthel' ? 'selected' : '' }}>Barthel Index</option>
                                    <option value="two_minute" {{ old('test_type', $video->test_type) == 'two_minute' ? 'selected' : '' }}>2-Minute Step Test</option>
                                    <option value="single_leg" {{ old('test_type', $video->test_type) == 'single_leg' ? 'selected' : '' }}>Single Leg Balance</option>
                                    <option value="five_stand" {{ old('test_type', $video->test_type) == 'five_stand' ? 'selected' : '' }}>Five Times Sit to Stand</option>
                                </select>
                                @error('test_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="level">Level *</label>
                                <select name="level" id="level"
                                    class="form-control @error('level') is-invalid @enderror" required>
                                    <option value="">Pilih level</option>
                                    <option value="normal" {{ old('level', $video->level) == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="ringan" {{ old('level', $video->level) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="berat" {{ old('level', $video->level) == 'berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3" id="klasifikasi-group">
                                <label for="klasifikasi">Klasifikasi *</label>
                                <select name="klasifikasi" id="klasifikasi"
                                    class="form-control @error('klasifikasi') is-invalid @enderror">
                                    <option value="">Pilih klasifikasi</option>
                                    <option value="Tinggi"
                                        {{ old('klasifikasi', $video->klasifikasi) == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                    </option>
                                    <option value="Sedang"
                                        {{ old('klasifikasi', $video->klasifikasi) == 'Sedang' ? 'selected' : '' }}>Sedang
                                    </option>
                                    <option value="Rendah"
                                        {{ old('klasifikasi', $video->klasifikasi) == 'Rendah' ? 'selected' : '' }}>Rendah
                                    </option>
                                </select>
                                @error('klasifikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3" id="pasien-group">
                                <label for="pasien_id">Pilih Pasien *</label>
                                <select name="pasien_id" id="pasien_id"
                                    class="form-control @error('pasien_id') is-invalid @enderror">
                                    <option value="">Pilih pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}"
                                            {{ old('pasien_id', $video->pasien_id) == $pasien->id ? 'selected' : '' }}>
                                            {{ $pasien->nama }} ({{ $pasien->nik }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('pasien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="video_file">Upload Video Baru (opsional)</label>
                                <input type="file" name="video_file" id="video_file"
                                    class="form-control @error('video_file') is-invalid @enderror" accept="video/*">
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                                @error('video_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Preview video baru sebelum submit -->
                            <div id="new-video-preview" class="mb-3"></div>

                            <!-- Preview video saat ini -->
                            @if ($video->file_path)
                                <div class="mb-3">
                                    <label class="form-label">Preview Video Saat Ini</label>
                                    <video controls class="w-100" style="max-height:300px;">
                                        <source src="{{ asset('storage/' . $video->file_path) }}"
                                            type="{{ $video->file_type }}">
                                        Browser Anda tidak mendukung pemutaran video.
                                    </video>
                                </div>
                            @endif

                            <div class="alert alert-info">
                                <h6><i class="fa fa-info-circle"></i> Petunjuk Upload:</h6>
                                <ul class="mb-0">
                                    <li><strong>Video Global:</strong> Video umum untuk semua pasien dengan klasifikasi
                                        tertentu</li>
                                    <li><strong>Video Khusus:</strong> Video latihan khusus untuk pasien tertentu</li>
                                    <li><strong>Kategori Keseluruhan:</strong> Video untuk klasifikasi umum pasien</li>
                                    <li><strong>Kategori Per Tes:</strong> Video khusus untuk jenis tes tertentu</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('superadmin.videos.index') }}" class="btn btn-secondary ms-2">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const jenisSelect = document.getElementById('jenis');
                            const categoryTypeSelect = document.getElementById('category_type');
                            const testTypeGroup = document.getElementById('test-type-group');
                            const klasifikasiGroup = document.getElementById('klasifikasi-group');
                            const pasienGroup = document.getElementById('pasien-group');

                            function toggle() {
                                const selectedCategoryType = categoryTypeSelect.value;
                                const selectedJenis = jenisSelect.value;

                                // Toggle test type group
                                if (selectedCategoryType === 'per_test') {
                                    testTypeGroup.style.display = 'block';
                                    testTypeGroup.querySelector('select').required = true;
                                } else {
                                    testTypeGroup.style.display = 'none';
                                    testTypeGroup.querySelector('select').required = false;
                                    testTypeGroup.querySelector('select').value = '';
                                }

                                // Toggle klasifikasi and pasien groups
                                if (selectedJenis === 'global') {
                                    klasifikasiGroup.style.display = 'block';
                                    pasienGroup.style.display = 'none';
                                    klasifikasiGroup.querySelector('select').required = true;
                                    pasienGroup.querySelector('select').required = false;
                                    pasienGroup.querySelector('select').value = '';
                                } else if (selectedJenis === 'khusus') {
                                    klasifikasiGroup.style.display = 'none';
                                    pasienGroup.style.display = 'block';
                                    klasifikasiGroup.querySelector('select').required = false;
                                    pasienGroup.querySelector('select').required = true;
                                    klasifikasiGroup.querySelector('select').value = '';
                                } else {
                                    klasifikasiGroup.style.display = 'none';
                                    pasienGroup.style.display = 'none';
                                    klasifikasiGroup.querySelector('select').required = false;
                                    pasienGroup.querySelector('select').required = false;
                                }
                            }

                            function toggle() {
                                const selectedCategoryType = categoryTypeSelect.value;
                                const selectedJenis = jenisSelect.value;
                                toggleTestTypeGroup(selectedCategoryType);
                                toggleKlasifikasiPasienGroups(selectedJenis);
                            }
                            
                            jenisSelect.addEventListener('change', toggle);
                            categoryTypeSelect.addEventListener('change', toggle);
                            toggle();
                            
                            // Preview new video file before submit
                            const videoInput = document.getElementById('video_file');
                            const newPreview = document.getElementById('new-video-preview');
                            videoInput.addEventListener('change', function() {
                                const file = this.files[0];
                                if (file) {
                                    const url = URL.createObjectURL(file);
                                    newPreview.innerHTML =
                                        `<label class="form-label">Preview Video Baru</label><video controls class="w-100" style="max-height:300px;"><source src="${url}" type="${file.type}">Browser Anda tidak mendukung pemutaran video.</video>`;
                                } else {
                                    newPreview.innerHTML = '';
                                }
                            });
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection


