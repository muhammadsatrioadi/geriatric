@extends('admin.layouts.layout')
@section('admin_title')
    Tambah Yayasan
@endsection
@section('admin_page_title')
    Tambah Yayasan
@endsection
@section('admin_layout')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Yayasan Baru</h1>
        <a href="{{ route('admin.foundations.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.foundations.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Yayasan</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Yayasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Yayasan Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Admin Yayasan</h5>
                        
                        <div class="mb-3">
                            <label for="admin_name" class="form-label">Nama Lengkap Admin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('admin_name') is-invalid @enderror" 
                                   id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required>
                            @error('admin_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Email Admin <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('admin_email') is-invalid @enderror" 
                                   id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required>
                            @error('admin_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_password" class="form-label">Password Admin <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('admin_password') is-invalid @enderror" 
                                   id="admin_password" name="admin_password" required>
                            @error('admin_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Minimal 8 karakter</small>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Yayasan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
