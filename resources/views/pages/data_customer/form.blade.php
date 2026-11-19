@extends('layouts.master')

@section('title', isset($data_customer) ? 'Edit Pelanggan' : 'Tambah Pelanggan')

@section('konten')

<style>
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }
    .col-span-2 {
        grid-column: span 2;
    }
    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
        .col-span-2 {
            grid-column: span 1;
        }
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ isset($customer) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</h2>
        <p class="text-body-secondary mb-0">
            {{ isset($customer) ? 'Perbarui data pelanggan di dalam sistem rental.' : 'Tambahkan data pelanggan baru ke dalam sistem rental.' }}
        </p>
    </div>

    <!-- Form -->
    <div class="card border shadow-sm">
        <div class="card-body p-4">

            <form action="{{ isset($customer) ? route('customer.update', $customer->id_customer) : route('customer.store') }}" method="POST" novalidate>
                @csrf
                @if (isset($customer))
                    @method('PUT')
                @endif

                <div class="form-grid-2">

                    <!-- Kolom 1: Nama Pelanggan -->
                    <div>
                        <label for="nama_customer" class="form-label fw-semibold">
                            Nama Lengkap Pelanggan
                        </label>
                        <input type="text"
                            id="nama_customer"
                            name="nama_customer"
                            class="form-control @error('nama_customer') is-invalid @enderror"
                            placeholder="Contoh: Budi Santoso"
                            value="{{ old('nama_customer', $customer->nama_customer ?? '') }}"
                            required>
                        @error('nama_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 2: Nomor KTP (NIK) -->
                    <div>
                        <label for="no_ktp" class="form-label fw-semibold">
                            Nomor KTP (NIK)
                        </label>
                        <input type="text"
                            id="no_ktp"
                            name="no_ktp"
                            maxlength="16"
                            class="form-control @error('no_ktp') is-invalid @enderror"
                            placeholder="Contoh: 337201xxxxxxxxxx"
                            value="{{ old('no_ktp', $customer->no_ktp ?? '') }}"
                            required>
                        @error('no_ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 3: Nomor HP / WhatsApp -->
                    <div class="col-span-2">
                        <label for="no_hp" class="form-label fw-semibold">
                            Nomor HP / WhatsApp
                        </label>
                        <input type="tel"
                            id="no_hp"
                            name="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror"
                            placeholder="Contoh: 081234567890"
                            value="{{ old('no_hp', $customer->no_hp ?? '') }}"
                            required>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 4: Alamat Lengkap (Membentang 2 Kolom) -->
                    <div class="col-span-2">
                        <label for="alamat" class="form-label fw-semibold">
                            Alamat Lengkap
                        </label>
                        <textarea id="alamat"
                            name="alamat"
                            rows="3"
                            class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Contoh: Jl. Slamet Riyadi No. 123, Surakarta"
                            required>{{ old('alamat', $customer->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary" style="background-color: #0d6efd; color: #ffffff; border-color: #0d6efd;">
                        <i class="bi bi-save me-1"></i>
                        {{ isset($customer) ? 'Update' : 'Simpan' }}
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection