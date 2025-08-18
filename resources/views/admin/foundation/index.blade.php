@extends('admin.layouts.layout')
@section('admin_title')
    Manajemen Yayasan
@endsection
@section('admin_page_title')
    Manajemen Yayasan
@endsection
@section('admin_layout')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Daftar Yayasan</h1>
        <a href="{{ route('admin.foundations.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Yayasan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="foundationsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Yayasan</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Jumlah User</th>
                            <th>Jumlah Pasien</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($foundations as $index => $foundation)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $foundation->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $foundation->slug }}</small>
                                </td>
                                <td>
                                    @if($foundation->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if($foundation->creator)
                                        {{ $foundation->creator->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $foundation->users->count() }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{ $foundation->patients->count() }}</span>
                                </td>
                                <td>{{ $foundation->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.foundations.show', $foundation) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.foundations.edit', $foundation) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.foundations.toggle', $foundation) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-secondary" 
                                                    title="{{ $foundation->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    onclick="return confirm('Yakin ingin {{ $foundation->is_active ? 'menonaktifkan' : 'mengaktifkan' }} yayasan ini?')">
                                                <i class="fa fa-{{ $foundation->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.foundations.destroy', $foundation) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus yayasan ini?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data yayasan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#foundationsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endsection
