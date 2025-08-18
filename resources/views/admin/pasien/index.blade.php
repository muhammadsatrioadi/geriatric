@extends('admin.layouts.layout')
@section('admin_title')
    Manajemen Pasien
@endsection
@section('admin_page_title')
    Manajemen Pasien
@endsection
@section('admin_layout')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <h4 class="card-title">Daftar Pasien</h4>
                    <div class="ms-md-auto py-2 py-md-0">
                        {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
                        <a href="{{ route('admin.pasiens.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus mx-1"></i> Tambah Pasien</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover table-bordered">
                            <thead class="text-center border">
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($pasiens as $pasien)
                                    <tr>
                                        <td>{{ $pasien->nik }}</td>
                                        <td>{{ $pasien->nama }}</td>
                                        <td>{{ $pasien->tanggal_lahir->format('d/m/Y') }}</td>
                                        <td>{{ $pasien->jenis_kelamin }}</td>
                                        <td>
                                            <a href="{{ route('admin.pasiens.show', $pasien->id) }}"
                                                class="btn btn-sm btn-primary" title="Detail">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            <a href="{{ route('admin.pasiens.manage', $pasien->id) }}"
                                                class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.pasiens.destroy', $pasien->id) }}" method="POST"
                                                class="d-inline ms-1"
                                                onsubmit="return confirm('Yakin ingin menghapus data pasien ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">Belum ada data pasien</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
