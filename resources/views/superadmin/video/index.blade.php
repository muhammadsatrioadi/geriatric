@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Manajemen Video
@endsection
@section('superadmin_page_title')
    Manajemen Video
@endsection
@section('superadmin_layout')
    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Daftar Video</div>
                <div class="card-action">
                    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Upload Video Baru
                    </a>
                </div>
            </div> --}}
            <div class="card-header d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <h4 class="card-title">Daftar Video</h4>
                <div class="ms-md-auto py-2 py-md-0">
                    {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
                    <a href="{{ route('superadmin.videos.create') }}" class="btn btn-primary btn-round"><i
                            class="fa fa-plus mx-1"></i> Upload Video Baru</a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="categoryFilter" class="form-label">Filter Kategori:</label>
                        <select id="categoryFilter" class="form-control">
                            <option value="">Semua Kategori</option>
                            <option value="overall">Keseluruhan</option>
                            <option value="per_test">Per Tes</option>
                            <option value="self_assessment">Self Assessment</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="testTypeFilter" class="form-label">Filter Jenis Tes:</label>
                        <select id="testTypeFilter" class="form-control">
                            <option value="">Semua Tes</option>
                            <option value="barthel">Barthel Index</option>
                            <option value="two_minute">2-Minute Step Test</option>
                            <option value="single_leg">Single Leg Balance</option>
                            <option value="five_stand">Five Times Sit to Stand</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="levelFilter" class="form-label">Filter Level:</label>
                        <select id="levelFilter" class="form-control">
                            <option value="">Semua Level</option>
                            <option value="normal">Normal</option>
                            <option value="ringan">Ringan</option>
                            <option value="berat">Berat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Filter Status:</label>
                        <select id="statusFilter" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                @if ($videos->count() > 0)
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-bordered">
                            <thead class="text-center border">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Kategori</th>
                                    <th>Jenis Tes</th>
                                    <th>Level</th>
                                    <th>Klasifikasi</th>
                                    <th>Pasien</th>
                                    <th>Ukuran File</th>
                                    <th>Status</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($videos as $index => $video)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $video->judul }}</td>
                                        <td>
                                            <span class="badge badge-{{ $video->jenis == 'global' ? 'info' : 'warning' }}">
                                                {{ ucfirst($video->jenis) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($video->category_type == 'overall')
                                                <span class="badge badge-primary">{{ $video->category_type_label }}</span>
                                            @elseif($video->category_type == 'per_test')
                                                <span class="badge badge-success">{{ $video->category_type_label }}</span>
                                            @elseif($video->category_type == 'self_assessment')
                                                <span class="badge badge-warning">{{ $video->category_type_label }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $video->category_type_label }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($video->test_type)
                                                <span class="badge badge-info">{{ $video->test_type_label }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $video->level == 'normal' ? 'success' : ($video->level == 'ringan' ? 'warning' : 'danger') }}">
                                                {{ $video->level_label }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($video->klasifikasi)
                                                <span class="badge badge-secondary">{{ $video->klasifikasi }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($video->pasien)
                                                {{ $video->pasien->nama }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ number_format($video->file_size / 1024 / 1024, 2) }} MB</td>
                                        <td>
                                            <span class="badge badge-{{ $video->is_active ? 'success' : 'secondary' }}">
                                                {{ $video->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>{{ $video->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('superadmin.videos.show', $video->id) }}"
                                                    class="btn btn-sm btn-info mx-1" title="Lihat">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('superadmin.videos.edit', $video->id) }}"
                                                    class="btn btn-sm btn-warning mx-1" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('superadmin.videos.toggle', $video->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-{{ $video->is_active ? 'secondary' : 'success' }} mx-1"
                                                        title="{{ $video->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fa fa-{{ $video->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('superadmin.videos.destroy', $video->id) }}"
                                                    method="POST" style="display: inline;"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fa fa-video fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada video yang diupload</h5>
                        <p class="text-muted">Mulai dengan mengupload video latihan untuk pasien</p>
                        <a href="{{ route('superadmin.videos.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Upload Video Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include Video Index JavaScript -->
    <script src="{{ asset('admin/js/video-form.js') }}"></script>
@endsection
