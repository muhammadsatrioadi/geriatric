@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Admin
@endsection
@section('superadmin_layout')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <h4 class="card-title">Daftar Admin</h4>
                    <div class="ms-md-auto py-2 py-md-0">
                        {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
                        <a href="{{ route('superadmin.admins.create') }}" class="btn btn-primary btn-round"
                            title="Tambah Admin">
                            <i class="fa fa-plus"></i> Tambah Admin
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($admins as $index => $admin)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            @if (in_array($admin->id, $onlineUserIds ?? []))
                                                <span class="badge bg-success">Online</span>
                                            @else
                                                <span class="badge bg-secondary">Offline</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('superadmin.admins.manage', $admin->id) }}"
                                                class="btn btn-sm btn-label-info" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <form action="{{ route('superadmin.admins.destroy', $admin->id) }}"
                                                method="POST" class="d-inline ms-1"
                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-label-danger"
                                                    title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Belum ada pengguna admin</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
