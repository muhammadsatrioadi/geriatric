@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Pasien
@endsection
@section('superadmin_page_title')
    Edit Pasien
@endsection
@section('superadmin_layout')
    <div class="col-md-12">
        <form id="edit-form" action="{{ route('superadmin.pasiens.update', $pasien->id) }}" method="POST"
            onsubmit="return confirm('Apakah anda yakin ingin menyimpan data ini?')">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Detail Pasien</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama"
                                    value="{{ old('nama', $pasien->nama) }}"
                                    @if (!$errors->any()) disabled @endif />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="NIK">NIK</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                    placeholder="Masukkan NIK" value="{{ old('nik', $pasien->nik) }}"
                                    @if (!$errors->any()) disabled @endif />
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-select form-control @error('jenis_kelamin') is-invalid @enderror"
                                    name="jenis_kelamin" @if (!$errors->any()) disabled @endif>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir', $pasien->tanggal_lahir->format('Y-m-d')) }}"
                                    @if (!$errors->any()) disabled @endif />
                            </div>
                            <div class="form-group">
                                <label for="berat_badan">Berat Badan</label>
                                <div class="input-group">
                                    <input type="number" name="berat_badan"
                                        class="form-control @error('berat_badan') is-invalid @enderror"
                                        placeholder="Masukkan Berat Badan"
                                        value="{{ old('berat_badan', $pasien->berat_badan) }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">Kg</span>
                                </div>
                                @error('berat_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tinggi_badan">Tinggi Badan</label>
                                <div class="input-group">
                                    <input type="number" name="tinggi_badan"
                                        class="form-control @error('tinggi_badan') is-invalid @enderror"
                                        placeholder="Masukkan Tinggi Badan"
                                        value="{{ old('tinggi_badan', $pasien->tinggi_badan) }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">cm</span>
                                </div>
                                @error('tinggi_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="tekanan_darah">Tekanan Darah</label>
                                <input type="text" name="tekanan_darah"
                                    class="form-control @error('tekanan_darah') is-invalid @enderror"
                                    placeholder="Masukkan Tekanan Darah"
                                    value="{{ old('tekanan_darah', $pasien->tekanan_darah) }}"
                                    @if (!$errors->any()) disabled @endif />
                            </div>
                            <div class="form-group">
                                <label for="kategori_stroke">Kategori Stroke</label>
                                <select class="form-select form-control @error('kategori_stroke') is-invalid @enderror"
                                    name="kategori_stroke" @if (!$errors->any()) disabled @endif>
                                    <option value="Pra"
                                        {{ old('kategori_stroke', $pasien->kategori_stroke) == 'Pra' ? 'selected' : '' }}>
                                        Pra
                                    </option>
                                    <option value="Sedang"
                                        {{ old('kategori_stroke', $pasien->kategori_stroke) == 'Sedang' ? 'selected' : '' }}>
                                        Sedang
                                    </option>
                                    <option value="Pasca"
                                        {{ old('kategori_stroke', $pasien->kategori_stroke) == 'Pasca' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                                @error('riwayat_jatuh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Hasil Pemeriksaan</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="barthel_index">Index Barthel</label>
                                <div class="input-group">
                                    <input type="number" name="barthel_index"
                                        class="form-control @error('barthel_index') is-invalid @enderror"
                                        placeholder="Masukkan Index Barthel"
                                        value="{{ old('barthel_index', $pasien->barthel_index ?? '') }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">pt</span>
                                </div>
                                @error('barthel_index')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="step_test">2-Minute Step Test</label>
                                <div class="input-group">
                                    <input type="number" name="step_test"
                                        class="form-control @error('step_test') is-invalid @enderror"
                                        placeholder="Masukkan Jumlah Langkah"
                                        value="{{ old('step_test', $pasien->step_test ?? '') }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">langkah</span>
                                </div>
                                @error('step_test')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="single_leg_open">Single Leg Balance (Mata Terbuka)</label>
                                <div class="input-group">
                                    <input type="number" name="single_leg_open"
                                        class="form-control @error('single_leg_open') is-invalid @enderror"
                                        placeholder="Durasi (detik)"
                                        value="{{ old('single_leg_open', $pasien->single_leg_open ?? '') }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">detik</span>
                                </div>
                                @error('single_leg_open')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="single_leg_closed">Single Leg Balance (Mata Tertutup)</label>
                                <div class="input-group">
                                    <input type="number" name="single_leg_closed"
                                        class="form-control @error('single_leg_closed') is-invalid @enderror"
                                        placeholder="Durasi (detik)"
                                        value="{{ old('single_leg_closed', $pasien->single_leg_closed ?? '') }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">detik</span>
                                </div>
                                @error('single_leg_closed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="sit_to_stand">Five Times Sit to Stand</label>
                                <div class="input-group">
                                    <input type="number" name="sit_to_stand" step="any"
                                        class="form-control @error('sit_to_stand') is-invalid @enderror"
                                        placeholder="Durasi dalam detik"
                                        value="{{ old('sit_to_stand', $pasien->sit_to_stand ?? '') }}"
                                        @if (!$errors->any()) disabled @endif />
                                    <span class="input-group-text">detik</span>
                                </div>
                                @error('sit_to_stand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action d-flex gap-2">
                    <div>
                        <button type="button" id="edit-btn" class="btn btn-warning" title="Edit Pasien">
                            <i class="fa fa-edit">  </i> Edit
                        </button>
                        <button type="submit" id="save-btn" class="btn btn-success" style="display:none"
                            title="Simpan Perubahan">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('superadmin.pasiens') }}" class="btn btn-danger" title="Batal">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
        <!-- Hasil Klasifikasi dan Video Latihan -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Hasil Klasifikasi & Video Latihan</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Hasil Klasifikasi Fungsional</h6>
                        <div
                            class="alert alert-{{ $pasien->classification == 'Tinggi' ? 'success' : ($pasien->classification == 'Sedang' ? 'warning' : 'danger') }}">
                            <strong>Klasifikasi: {{ $pasien->classification }}</strong>
                        </div>
                        <h6>Detail Pemeriksaan:</h6>
                        @php
                            $age = $pasien->tanggal_lahir->age;
                            $gender = $pasien->jenis_kelamin;
                        @endphp
                        <table class="table table-sm">
                            <tr>
                                <td>Barthel Index ({{ $pasien->barthel_index ?? 'Belum diisi' }})</td>
                                <td>
                                    @if ($pasien->barthel_index)
                                        <span
                                            class="badge badge-{{ \App\Helpers\PemeriksaanHelper::isBarthelNormal($pasien->barthel_index) ? 'success' : 'danger' }}">
                                            {{ \App\Helpers\PemeriksaanHelper::isBarthelNormal($pasien->barthel_index) ? 'Normal' : 'Tidak Normal' }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Belum diisi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Single Leg Balance (Mata Terbuka: {{ $pasien->single_leg_open ?? 'Belum diisi' }}
                                    detik)</td>
                                <td>
                                    @if ($pasien->single_leg_open !== null)
                                        <span
                                            class="badge badge-{{ \App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open, $age, false) ? 'success' : 'danger' }}">
                                            {{ \App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open, $age, false) ? 'Normal' : 'Tidak Normal' }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Belum diisi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Single Leg Balance (Mata Tertutup: {{ $pasien->single_leg_closed ?? 'Belum diisi' }}
                                    detik)</td>
                                <td>
                                    @if ($pasien->single_leg_closed !== null)
                                        <span
                                            class="badge badge-{{ \App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_closed, $age, true) ? 'success' : 'danger' }}">
                                            {{ \App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_closed, $age, true) ? 'Normal' : 'Tidak Normal' }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Belum diisi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>5x Sit to Stand ({{ $pasien->sit_to_stand ?? 'Belum diisi' }} detik)</td>
                                <td>
                                    @if ($pasien->sit_to_stand)
                                        <span
                                            class="badge badge-{{ \App\Helpers\PemeriksaanHelper::isSitStandNormal($pasien->sit_to_stand, $pasien->tanggal_lahir->age) ? 'success' : 'danger' }}">
                                            {{ \App\Helpers\PemeriksaanHelper::isSitStandNormal($pasien->sit_to_stand, $pasien->tanggal_lahir->age) ? 'Normal' : 'Tidak Normal' }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Belum diisi</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Video Latihan</h6>
                        @php
                            $videoKhusus = $pasien->videos()->where('jenis', 'khusus')->where('is_active', true)->get();
                            $videoGlobal = $pasien->globalVideos;
                        @endphp
                        @if ($videoKhusus->count() > 0)
                            <div class="mb-3">
                                <h6 class="text-primary">Video Khusus Pasien</h6>
                                @foreach ($videoKhusus as $video)
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1">{{ $video->judul }}</h6>
                                            @if ($video->deskripsi)
                                                <p class="card-text small text-muted mb-2">{{ $video->deskripsi }}</p>
                                            @endif
                                            <video width="100%" controls style="max-height: 200px;">
                                                <source src="{{ $video->video_url }}" type="{{ $video->file_type }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if ($videoGlobal->count() > 0)
                            <div class="mb-3">
                                <h6 class="text-info">Video Global ({{ $pasien->classification }})</h6>
                                @foreach ($videoGlobal as $video)
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1">{{ $video->judul }}</h6>
                                            @if ($video->deskripsi)
                                                <p class="card-text small text-muted mb-2">{{ $video->deskripsi }}</p>
                                            @endif
                                            <video width="100%" controls style="max-height: 200px;">
                                                <source src="{{ $video->video_url }}" type="{{ $video->file_type }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if ($videoKhusus->count() == 0 && $videoGlobal->count() == 0)
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Belum ada video latihan untuk pasien ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('edit-btn').addEventListener('click', function() {
                const fields = document.querySelectorAll('#edit-form input, #edit-form select');
                fields.forEach(f => f.removeAttribute('disabled'));
                this.style.display = 'none';
                document.getElementById('save-btn').style.display = 'inline-block';
            });
        </script>
        @if ($errors->any())
            <script>
                document.getElementById('edit-btn').click();
            </script>
        @endif
    </div>
@endsection
