@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Detail Pasien
@endsection
@section('superadmin_page_title')
    Detail Pasien
@endsection
@section('superadmin_layout')
    <div class="row">
        <div class="col-md-12">
            <!-- Header with back button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title">Detail Pasien</h4>
                <div>
                    <a href="{{ route('superadmin.pasiens') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('superadmin.pasiens.manage', $pasien->id) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Biodata Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa fa-user"></i> Biodata Pasien</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Nama</strong></td>
                                    <td width="20"><strong>:</strong></td>
                                    <td>{{ $pasien->nama }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIK</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->nik }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->tanggal_lahir->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Umur</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->tanggal_lahir->age }} tahun</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Berat Badan</strong></td>
                                    <td width="20"><strong>:</strong></td>
                                    <td>{{ $pasien->berat_badan ? $pasien->berat_badan . ' kg' : 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tinggi Badan</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->tinggi_badan ? $pasien->tinggi_badan . ' cm' : 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tekanan Darah</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->tekanan_darah ?: 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori Stroke</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->kategori_stroke ?: 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Riwayat Jatuh</strong></td>
                                    <td><strong>:</strong></td>
                                    <td>{{ $pasien->riwayat_jatuh ?: 'Belum diisi' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Klasifikasi Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa fa-chart-bar"></i> Klasifikasi Keseluruhan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Klasifikasi Pasien:</h6>
                            <span class="badge badge-{{ $pasien->classification == 'Tinggi' ? 'success' : ($pasien->classification == 'Sedang' ? 'warning' : 'danger') }} fs-6">
                                {{ $pasien->classification }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            @if($overallVideo)
                                <h6>Video Rekomendasi:</h6>
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $overallVideo->judul }}</h6>
                                        @if($overallVideo->deskripsi)
                                            <p class="card-text text-muted">{{ $overallVideo->deskripsi }}</p>
                                        @endif
                                        <video class="w-100" controls style="max-height: 200px;">
                                            <source src="{{ $overallVideo->video_url }}" type="{{ $overallVideo->file_type }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    </div>
                                </div>
                            @else
                                <h6>Video Rekomendasi:</h6>
                                <p class="text-muted">Video belum tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Pemeriksaan Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa fa-clipboard-check"></i> Hasil Pemeriksaan 4 Tes</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $age = $pasien->tanggal_lahir->age;
                            $gender = $pasien->jenis_kelamin;
                            $testLabels = [
                                'barthel' => 'Barthel Index',
                                'two_minute' => '2-Minute Step Test',
                                'single_leg' => 'Single Leg Balance',
                                'five_stand' => 'Five Times Sit to Stand'
                            ];
                        @endphp

                        <!-- Barthel Index -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">{{ $testLabels['barthel'] }}</h6>
                                </div>
                                <div class="card-body">
                                    @if($pasien->barthel_index !== null)
                                        <p><strong>Nilai:</strong> {{ $pasien->barthel_index }}</p>
                                        @php
                                            $isBarthelNormal = \App\Helpers\PemeriksaanHelper::isBarthelNormal($pasien->barthel_index);
                                        @endphp
                                        <p><strong>Status:</strong> 
                                            <span class="badge badge-{{ $isBarthelNormal ? 'success' : 'danger' }}">
                                                {{ $isBarthelNormal ? 'Normal' : 'Tidak Normal' }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-muted">Belum diperiksa</p>
                                    @endif

                                    @if(isset($perTestVideos['barthel']) && $perTestVideos['barthel'])
                                        <hr>
                                        <h6>Video Rekomendasi:</h6>
                                        <video class="w-100" controls style="max-height: 150px;">
                                            <source src="{{ $perTestVideos['barthel']->video_url }}" type="{{ $perTestVideos['barthel']->file_type }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- 2-Minute Step Test -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">{{ $testLabels['two_minute'] }}</h6>
                                </div>
                                <div class="card-body">
                                    @if($pasien->step_test !== null)
                                        <p><strong>Nilai:</strong> {{ $pasien->step_test }} langkah</p>
                                        @php
                                            $isStepNormal = \App\Helpers\PemeriksaanHelper::isStepNormal($pasien->step_test, $age, $gender);
                                        @endphp
                                        <p><strong>Status:</strong> 
                                            <span class="badge badge-{{ $isStepNormal ? 'success' : 'danger' }}">
                                                {{ $isStepNormal ? 'Normal' : 'Tidak Normal' }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-muted">Belum diperiksa</p>
                                    @endif

                                    @if(isset($perTestVideos['two_minute']) && $perTestVideos['two_minute'])
                                        <hr>
                                        <h6>Video Rekomendasi:</h6>
                                        <video class="w-100" controls style="max-height: 150px;">
                                            <source src="{{ $perTestVideos['two_minute']->video_url }}" type="{{ $perTestVideos['two_minute']->file_type }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Single Leg Balance -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">{{ $testLabels['single_leg'] }}</h6>
                                </div>
                                <div class="card-body">
                                    @if($pasien->single_leg_open !== null)
                                        <p><strong>Mata Terbuka:</strong> {{ $pasien->single_leg_open }} detik</p>
                                        <p><strong>Mata Tertutup:</strong> {{ $pasien->single_leg_closed ?: 'Belum diukur' }} detik</p>
                                        @php
                                            $isSingleLegNormal = \App\Helpers\PemeriksaanHelper::isSingleLegNormal($pasien->single_leg_open, $age, false);
                                        @endphp
                                        <p><strong>Status:</strong> 
                                            <span class="badge badge-{{ $isSingleLegNormal ? 'success' : 'danger' }}">
                                                {{ $isSingleLegNormal ? 'Normal' : 'Tidak Normal' }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-muted">Belum diperiksa</p>
                                    @endif

                                    @if(isset($perTestVideos['single_leg']) && $perTestVideos['single_leg'])
                                        <hr>
                                        <h6>Video Rekomendasi:</h6>
                                        <video class="w-100" controls style="max-height: 150px;">
                                            <source src="{{ $perTestVideos['single_leg']->video_url }}" type="{{ $perTestVideos['single_leg']->file_type }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Five Times Sit to Stand -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">{{ $testLabels['five_stand'] }}</h6>
                                </div>
                                <div class="card-body">
                                    @if($pasien->sit_to_stand !== null)
                                        <p><strong>Nilai:</strong> {{ $pasien->sit_to_stand }} detik</p>
                                        @php
                                            $isSitStandNormal = \App\Helpers\PemeriksaanHelper::isSitStandNormal($pasien->sit_to_stand, $age);
                                        @endphp
                                        <p><strong>Status:</strong> 
                                            <span class="badge badge-{{ $isSitStandNormal ? 'success' : 'danger' }}">
                                                {{ $isSitStandNormal ? 'Normal' : 'Tidak Normal' }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-muted">Belum diperiksa</p>
                                    @endif

                                    @if(isset($perTestVideos['five_stand']) && $perTestVideos['five_stand'])
                                        <hr>
                                        <h6>Video Rekomendasi:</h6>
                                        <video class="w-100" controls style="max-height: 150px;">
                                            <source src="{{ $perTestVideos['five_stand']->video_url }}" type="{{ $perTestVideos['five_stand']->file_type }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 