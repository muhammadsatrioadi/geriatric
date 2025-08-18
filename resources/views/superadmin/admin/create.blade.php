@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Admin Users
@endsection
@section('superadmin_page_title')
    Tambah Admin
@endsection
@section('superadmin_layout')
    <div class="col-md-12">
        <form action="{{ route('superadmin.admins.store') }}" method="POST"
            onsubmit="return confirm('Yakin ingin menambah admin?')">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tambah Admin</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Masukkan Nama" value="{{ old('name') }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan Email" value="{{ old('email') }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan Password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Ulangi Password" />
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn radiu btn-success" title="Simpan">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-danger" title="Batal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
