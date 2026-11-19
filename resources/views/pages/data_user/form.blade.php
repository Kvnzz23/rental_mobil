@extends('layouts.master')
@section('title', isset($user) ? 'Edit Data' : "Tambah Data")

@section('konten')
<style>
    .clean-form-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    }

    .clean-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.45rem;
    }

    .clean-input,
    .clean-select {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.6rem 0.85rem;
        font-size: 0.95rem;
        color: #334155;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .clean-input:focus,
    .clean-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    .password-field-wrapper {
        position: relative;
    }

    .btn-toggle-eye {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #64748b;
        padding: 0.25rem;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .btn-toggle-eye:hover {
        color: #0d6efd;
    }

    .btn-back-clean {
        background-color: #f1f5f9;
        color: #334155;
        border: none;
        border-radius: 8px;
        padding: 0.55rem 1.15rem;
        font-weight: 500;
        transition: background-color 0.15s ease;
    }

    .btn-back-clean:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }

    .btn-save-clean {
        border-radius: 8px;
        padding: 0.55rem 1.25rem;
        font-weight: 500;
    }
</style>

<div class="container-fluid py-4">
    {{-- Header Judul & Subjudul di Luar Card --}}
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
        <p class="text-muted mb-0">Isi nama lengkap, alamat email, role hak akses, dan kata sandi pengguna.</p>
    </div>

    {{-- Card Form Utama --}}
    <div class="clean-form-card p-4">
        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" novalidate>
            @csrf
            @if (isset($user))
            @method('PUT')
            @endif
            {{-- Baris 1: Nama Lengkap & Alamat Email (2 Kolom) --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label clean-label">Nama Lengkap</label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control clean-input @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name ?? '')}}"
                        placeholder="Masukkan nama lengkap"
                        required
                        autofocus>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label clean-label">Alamat Email</label>
                    <input type="email"
                        id="email"
                        name="email"
                        class="form-control clean-input @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email ?? '') }}"
                        placeholder="contoh@email.com"
                        required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Baris 2: Password & Konfirmasi Password dengan Toggle Eye (2 Kolom) --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="password" class="form-label clean-label">{{ isset($user) ? 'Password Baru (kosongkan jika tidak diubah)' :  'Password'}}</label>
                    <div class="password-field-wrapper">
                        <input type="password"
                            id="password"
                            name="password"
                            class="form-control clean-input pe-5 @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            required>
                        <button type="button"
                            class="btn-toggle-eye"
                            onclick="togglePassword('password', this)"
                            title="Tampilkan / Sembunyikan Password">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label clean-label">Konfirmasi Password</label>
                    <div class="password-field-wrapper">
                        <input type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control clean-input pe-5"
                            placeholder="Ulangi password"
                            required>
                        <button type="button"
                            class="btn-toggle-eye"
                            onclick="togglePassword('password_confirmation', this)"
                            title="Tampilkan / Sembunyikan Password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Baris 3: Pilihan Role (Lebar Penuh seperti Status Transaksi) --}}
            <div class="mb-4">
                <label for="role" class="form-label clean-label">Role Pengguna</label>
                <select id="role"
                    name="role"
                    class="form-select clean-select @error('role') is-invalid @enderror"
                    required>
                    <option value="" disabled {{ old('role', $user->role ?? '') ? '' : 'selected' }}>-- Pilih Role --</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role', $user->role ?? '') === $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                    @endforeach
                </select>
                @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Garis Pembatas & Tombol Aksi di Kanan Bawah --}}
            <hr class="text-secondary opacity-25 my-4">

            <div class="d-flex justify-content-end align-items-center gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-back-clean d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-save-clean d-inline-flex align-items-center gap-2">
                    <i class="bi bi-save"></i> {{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection