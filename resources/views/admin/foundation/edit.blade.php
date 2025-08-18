@extends('admin.layouts.layout')
@section('admin_title')
    Edit Yayasan
@endsection
@section('admin_page_title')
    Edit Yayasan
@endsection
@section('admin_layout')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Yayasan</h1>
        <a href="{{ route('admin.foundations.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.foundations.update', $foundation) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Yayasan</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Yayasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $foundation->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $foundation->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Yayasan Aktif
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control" value="{{ $foundation->slug }}" readonly>
                            <small class="form-text text-muted">Slug akan otomatis di-generate dari nama yayasan</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Tambahan</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Dibuat Oleh</label>
                            <input type="text" class="form-control" 
                                   value="{{ $foundation->creator ? $foundation->creator->name : 'Tidak diketahui' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Dibuat</label>
                            <input type="text" class="form-control" 
                                   value="{{ $foundation->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Terakhir Diupdate</label>
                            <input type="text" class="form-control" 
                                   value="{{ $foundation->updated_at->format('d/m/Y H:i') }}" readonly>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update Yayasan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
