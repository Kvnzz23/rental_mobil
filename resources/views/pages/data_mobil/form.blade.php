@extends('layouts.master')

@section('title', isset($data_mobil) ? 'Edit Mobil' : 'Tambah Mobil')

@section('konten')

<style>
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    /* Responsif: otomatis jadi 1 kolom jika dibuka di layar HP */
    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    /* Merapikan tampilan dropdown Status Mobil di BS 6 Alpha */
    .form-select-custom {
        display: block;
        width: 100%;
        padding: 0.45rem 0.75rem;
        font-size: 1rem;
        color: #212529;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ isset($data_mobil) ? 'Edit Mobil' : 'Tambah Mobil' }}</h2>
        <p class="text-body-secondary mb-0">
            {{ isset($data_mobil) ? 'Perbarui data mobil di dalam sistem rental.' : 'Tambahkan data mobil baru ke dalam sistem rental.' }}
        </p>
    </div>

    <!-- Form -->
    <div class="card border shadow-sm">
        <div class="card-body p-4">

            <form action="{{ isset($data_mobil) ? route('cars.update', $data_mobil->id_cars) : route('cars.store') }}" method="POST" novalidate>
                @csrf
                @if (isset($data_mobil))
                @method('PUT')
                @endif

                <div class="form-grid-2">

                    <!-- Kolom 1: Nama Mobil -->
                    <div>
                        <label for="nama_mobil" class="form-label fw-semibold">
                            Nama Mobil
                        </label>
                        <input type="text"
                            id="nama_mobil"
                            name="nama_mobil"
                            class="form-control @error('nama_mobil') is-invalid @enderror"
                            placeholder="Contoh: Avanza"
                            value="{{ old('nama_mobil', $data_mobil->nama_mobil ?? '') }}"
                            required>
                        @error('nama_mobil')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 2: Merk -->
                    <div>
                        <label for="merk" class="form-label fw-semibold">
                            Merk
                        </label>
                        <input type="text"
                            id="merk"
                            name="merk"
                            class="form-control @error('merk') is-invalid @enderror"
                            placeholder="Contoh: Toyota"
                            value="{{ old('merk', $data_mobil->merk ?? '') }}"
                            required>
                        @error('merk')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 3: Tipe -->
                    <div>
                        <label for="tipe" class="form-label fw-semibold">
                            Tipe Mobil
                        </label>
                        <input type="text"
                            id="tipe"
                            name="tipe"
                            class="form-control @error('tipe') is-invalid @enderror"
                            placeholder="Contoh: MPV"
                            value="{{ old('tipe', $data_mobil->tipe ?? '') }}"
                            required>
                        @error('tipe')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 4: Tahun -->
                    <div>
                        <label for="tahun" class="form-label fw-semibold">
                            Tahun
                        </label>
                        <input type="number"
                            id="tahun"
                            name="tahun"
                            class="form-control @error('tahun') is-invalid @enderror"
                            placeholder="Contoh: 2023"
                            value="{{ old('tahun', $data_mobil->tahun ?? '') }}"
                            min="1900"
                            max="{{ date('Y') + 1 }}"
                            required>
                        @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 5: Plat Nomor -->
                    <div>
                        <label for="plat_nomor" class="form-label fw-semibold">
                            Plat Nomor
                        </label>
                        <input type="text"
                            id="plat_nomor"
                            name="plat_nomor"
                            class="form-control @error('plat_nomor') is-invalid @enderror"
                            placeholder="Contoh: AD 1234 AB"
                            value="{{ old('plat_nomor', $data_mobil->plat_nomor ?? '') }}"
                            required>
                        @error('plat_nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 6: Harga Sewa -->
                    <div>
                        <label for="harga_sewa" class="form-label fw-semibold">
                            Harga Sewa / Hari
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">Rp</span>
                            <input type="number"
                                id="harga_sewa"
                                name="harga_sewa"
                                class="form-control @error('harga_sewa') is-invalid @enderror"
                                placeholder="Contoh: 350000"
                                value="{{ old('harga_sewa', $data_mobil->harga_sewa ?? '') }}"
                                min="0"
                                step="0.01"
                                required>
                            @error('harga_sewa')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom 7: Status -->
                    <div>
                        <label for="status" class="form-label fw-semibold">
                            Status Mobil
                        </label>
                        <select id="status"
                            name="status"
                            class="form-select-custom @error('status') is-invalid @enderror"
                            required>
                            <option value="" disabled {{ old('status', $data_mobil->status ?? '') == '' ? 'selected' : '' }}>
                                Pilih Status
                            </option>
                            <option value="tersedia" {{ old('status', $data_mobil->status ?? '') == 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="disewa" {{ old('status', $data_mobil->status ?? '') == 'disewa' ? 'selected' : '' }}>
                                Disewa
                            </option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary" style="background-color: #0d6efd; color: #ffffff; border-color: #0d6efd;">
                        <i class="bi bi-save me-1"></i>
                        {{ isset($data_mobil) ? 'Update' : 'Simpan' }}
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection