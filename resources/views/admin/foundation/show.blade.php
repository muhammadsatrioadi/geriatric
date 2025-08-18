@extends('admin.layouts.layout')
@section('admin_title')
    Detail Yayasan
@endsection
@section('admin_page_title')
    Detail Yayasan
@endsection
@section('admin_layout')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Yayasan</h1>
        <div>
            <a href="{{ route('admin.foundations.edit', $foundation) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.foundations.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Yayasan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Nama Yayasan</strong></td>
                            <td>{{ $foundation->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Slug</strong></td>
                            <td><code>{{ $foundation->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @if($foundation->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Oleh</strong></td>
                            <td>{{ $foundation->creator ? $foundation->creator->name : 'Tidak diketahui' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            <td>{{ $foundation->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diupdate</strong></td>
                            <td>{{ $foundation->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h3 class="text-primary">{{ $foundation->users->count() }}</h3>
                                <p class="mb-0">Total User</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h3 class="text-success">{{ $foundation->patients->count() }}</h3>
                                <p class="mb-0">Total Pasien</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar User Yayasan</h5>
                </div>
                <div class="card-body">
                    @if($foundation->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($foundation->users as $user)
                                        <tr>
                                            <td>{{ $user->full_name ?: $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role == 2)
                                                    <span class="badge bg-warning">Foundation</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $user->role }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada user yang terdaftar di yayasan ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Pasien Yayasan</h5>
                </div>
                <div class="card-body">
                    @if($foundation->patients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($foundation->patients->take(5) as $patient)
                                        <tr>
                                            <td>{{ $patient->nama }}</td>
                                            <td>{{ $patient->nik }}</td>
                                            <td>
                                                @if($patient->public_visible)
                                                    <span class="badge bg-success">Public</span>
                                                @else
                                                    <span class="badge bg-secondary">Private</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($foundation->patients->count() > 5)
                                <small class="text-muted">Menampilkan 5 dari {{ $foundation->patients->count() }} pasien</small>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada pasien yang terdaftar di yayasan ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
