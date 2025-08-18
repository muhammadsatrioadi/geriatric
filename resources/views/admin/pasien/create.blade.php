@extends('admin.layouts.layout')
@section('admin_title')
    Pasien
@endsection
@section('admin_page_title')
    Tambah Pasien
@endsection
@section('admin_layout')
    <div class="col-md-12">
        <form action="{{ route('admin.pasiens.store') }}" method="POST"
            onsubmit="return confirm('Apakah anda yakin ingin menyimpan data ini?')">
            @csrf
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
                                    value="{{ old('nama') }}" />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="NIK">NIK</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                    placeholder="Masukkan NIK" value="{{ old('nik') }}" />
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-select form-control @error('jenis_kelamin') is-invalid @enderror"
                                    name="jenis_kelamin">
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis
                                        Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
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
                                    value="{{ old('tanggal_lahir') }}" />
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="berat_badan">Berat Badan</label>
                                <div class="input-group">
                                    <input type="number" name="berat_badan"
                                        class="form-control @error('berat_badan') is-invalid @enderror"
                                        placeholder="Masukkan Berat Badan" value="{{ old('berat_badan') }}" />
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
                                        placeholder="Masukkan Tinggi Badan" value="{{ old('tinggi_badan') }}" />
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
                                <div class="input-group">
                                    <input type="text" name="tekanan_darah"
                                        class="form-control @error('tekanan_darah') is-invalid @enderror"
                                        placeholder="Masukkan Tekanan Darah" value="{{ old('tekanan_darah') }}" />
                                    <span class="input-group-text">mmHg</span>
                                </div>
                                @error('tekanan_darah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kategori_stroke">Kategori Stroke</label>
                                <select class="form-select form-control @error('kategori_stroke') is-invalid @enderror"
                                    name="kategori_stroke">
                                    <option value="" disabled {{ old('kategori_stroke') ? '' : 'selected' }}>Pilih
                                        Kategori Stroke
                                    </option>
                                    <option value="Pra" {{ old('kategori_stroke') == 'Pra' ? 'selected' : '' }}>Pra
                                    </option>
                                    <option value="Sedang" {{ old('kategori_stroke') == 'Sedang' ? 'selected' : '' }}>
                                        Sedang
                                    </option>
                                    <option value="Pasca" {{ old('kategori_stroke') == 'Pasca' ? 'selected' : '' }}>Pasca
                                    </option>
                                </select>
                                @error('kategori_stroke')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="riwayat_jatuh">Pernah Jatuh?</label>
                                <select class="form-select form-control @error('riwayat_jatuh') is-invalid @enderror"
                                    name="riwayat_jatuh">
                                    <option value="" disabled {{ old('riwayat_jatuh') ? '' : 'selected' }}>Pilih Opsi
                                    </option>
                                    <option value="Pernah" {{ old('riwayat_jatuh') == 'Pernah' ? 'selected' : '' }}>Pernah
                                    </option>
                                    <option value="Tidak" {{ old('riwayat_jatuh') == 'Tidak' ? 'selected' : '' }}>Tidak
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
                                        placeholder="Masukkan Index Barthel" value="{{ old('barthel_index') }}" />
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
                                        placeholder="Masukkan Jumlah Langkah" value="{{ old('step_test') }}" />
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
                                        placeholder="Durasi (detik)" value="{{ old('single_leg_open') }}" />
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
                                        placeholder="Durasi (detik)" value="{{ old('single_leg_closed') }}" />
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
                                        placeholder="Durasi dalam detik" value="{{ old('sit_to_stand') }}" />
                                    <span class="input-group-text">detik</span>
                                </div>
                                @error('sit_to_stand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn radiu btn-success">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </form>
    </div>
@endsection
