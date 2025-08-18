@extends('admin.layouts.layout')
@section('admin_title')
    Detail Video
@endsection
@section('admin_page_title')
    Detail Video: {{ $video->judul }}
@endsection
@section('admin_layout')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Video</div>
                <div class="card-action">
                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 mb-4 mb-md-0">
                        <div class="ratio ratio-16x9 mb-4">
                            <video controls class="w-100 h-100">
                                <source src="{{ $video->video_url }}" type="{{ $video->file_type }}">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-4 mb-md-0">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">Informasi Video</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Judul:</strong></td>
                                            <td>{{ $video->judul }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis:</strong></td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $video->jenis == 'global' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($video->jenis) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @if ($video->klasifikasi)
                                            <tr>
                                                <td><strong>Klasifikasi:</strong></td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $video->klasifikasi == 'Tinggi' ? 'success' : ($video->klasifikasi == 'Sedang' ? 'warning' : 'danger') }}">
                                                        {{ $video->klasifikasi }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($video->pasien)
                                            <tr>
                                                <td><strong>Pasien:</strong></td>
                                                <td>{{ $video->pasien->nama }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Ukuran File:</strong></td>
                                            <td>{{ number_format($video->file_size / 1024 / 1024, 2) }} MB</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Format:</strong></td>
                                            <td>{{ strtoupper(pathinfo($video->file_name, PATHINFO_EXTENSION)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $video->is_active ? 'success' : 'secondary' }}">
                                                    {{ $video->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Upload oleh:</strong></td>
                                            <td>{{ $video->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Upload:</strong></td>
                                            <td>{{ $video->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>

                                @if ($video->deskripsi)
                                    <div class="mt-3">
                                        <h6>Deskripsi:</h6>
                                        <p class="text-muted">{{ $video->deskripsi }}</p>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <h6>URL Video:</h6>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $video->video_url }}"
                                            readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="copyToClipboard('{{ $video->video_url }}')">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('URL video berhasil disalin ke clipboard!');
            }, function(err) {
                console.error('Gagal menyalin URL: ', err);
            });
        }
    </script>
@endsection
