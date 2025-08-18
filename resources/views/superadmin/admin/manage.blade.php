@extends('superadmin.layouts.layout')
@section('superadmin_title')
    admin
@endsection
@section('superadmin_page_title')
    Edit admin
@endsection
@section('superadmin_layout')
    <div class="col-md-12">
        <form id="edit-form" action="{{ route('superadmin.admins.update', $admin->id) }}" method="POST"
            onsubmit="return confirm('Apakah anda yakin ingin menyimpan data ini?')">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Detail admin</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama"
                                    value="{{ old('name', $admin->name) }}"
                                    @if (!$errors->any()) disabled @endif />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror"
                                    @if (!$errors->any()) disabled @endif>
                                    <option value="0" {{ old('role', $admin->role) == 0 ? 'selected' : '' }}>Superadmin
                                    </option>
                                    <option value="1" {{ old('role', $admin->role) == 1 ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email"
                                    value="{{ old('email', $admin->email) }}"
                                    @if (!$errors->any()) disabled @endif />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password fields for manual reset --}}
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password Baru"
                                    @if (!$errors->any()) disabled @endif />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Konfirmasi Password Baru"
                                    @if (!$errors->any()) disabled @endif />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-action d-flex gap-2">
                    <div>
                        <button type="button" id="edit-btn" class="btn btn-warning" title="Edit">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button type="submit" id="save-btn" class="btn btn-success" title="Simpan Perubahan" style="display:none">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('superadmin.admins') }}" class="btn btn-danger" title="Batal">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <script>
            document.getElementById('edit-btn').addEventListener('click', function() {
                const fields = document.querySelectorAll('#edit-form input, #edit-form select');
                fields.forEach(f => f.removeAttribute('disabled'));
                this.style.display = 'none';
                document.getElementById('save-btn').style.display = 'inline-block';
            });
        </script>
        @if ($errors->any())
            <script>
                document.getElementById('edit-btn').click();
            </script>
        @endif
    </div>
@endsection
