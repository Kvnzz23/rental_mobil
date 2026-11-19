@extends('layouts.master')

@section('title', isset($rental) ? 'Edit Transaksi Rental' : 'Tambah Transaksi Rental')

@section('konten')

<style>
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

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

    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ isset($rental) ? 'Edit Transaksi Rental' : 'Tambah Transaksi Rental' }}</h2>
        <p class="text-body-secondary mb-0">
            {{ isset($rental) ? 'Perbarui data transaksi penyewaan mobil.' : 'Pilih pelanggan, mobil yang tersedia, dan tanggal penyewaan.' }}
        </p>
    </div>

    @if ($errors->any())
    <div class="mb-4 p-3 rounded-2" style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7;">
        <strong>Gagal menyimpan data:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card border shadow-sm">
        <div class="card-body p-4">

            <form action="{{ isset($rental) ? route('rental.update', $rental->id_rental) : route('rental.store') }}" method="POST">
                @csrf
                @if (isset($rental))
                @method('PUT')
                @endif

                <div class="form-grid-2">

                    <!-- Pelanggan -->
                    <div>
                        <label for="customer_id" class="form-label fw-semibold">Pelanggan</label>
                        <select id="customer_id" name="customer_id" class="form-select-custom" required>
                            <option value="" disabled {{ !isset($rental) ? 'selected' : '' }}>-- Pilih Pelanggan --</option>
                            @foreach ($customers as $customer)
                            <option value="{{ $customer->id_customer }}"
                                {{ (old('customer_id', $rental->customer_id ?? '') == $customer->id_customer) ? 'selected' : '' }}>
                                {{ $customer->nama_customer }} ({{ $customer->no_hp }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mobil -->
                    <div>
                        <label for="car_id" class="form-label fw-semibold">Mobil</label>
                        <select id="car_id" name="car_id" class="form-select-custom" required>
                            <option value="" data-harga="0" disabled {{ !isset($rental) ? 'selected' : '' }}>-- Pilih Mobil --</option>
                            @foreach ($cars as $car)
                            <option value="{{ $car->id_cars }}" data-harga="{{ $car->harga_sewa }}"
                                {{ (old('car_id', $rental->car_id ?? '') == $car->id_cars) ? 'selected' : '' }}>
                                {{ $car->nama_mobil }} - {{ $car->plat_nomor }} (Rp {{ number_format($car->harga_sewa, 0, ',', '.') }}/hari)
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control"
                            value="{{ old('tanggal_mulai', $rental->tanggal_mulai ?? date('Y-m-d')) }}" required>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control"
                            value="{{ old('tanggal_selesai', $rental->tanggal_selesai ?? '') }}" required>
                    </div>

                    <!-- Dropdown Status (Baru Ditambahkan) -->
                    <div style="grid-column: span 2;">
                        <label for="status" class="form-label fw-semibold">Status Transaksi</label>
                        <select id="status" name="status" class="form-select-custom" required>
                            <option value="pending" {{ old('status', $rental->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                            <option value="berjalan" {{ old('status', $rental->status ?? '') == 'berjalan' ? 'selected' : '' }}>Berjalan (Sedang Disewa)</option>
                            <option value="selesai" {{ old('status', $rental->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Dikembalikan)</option>
                            <option value="batal" {{ old('status', $rental->status ?? '') == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    <!-- Estimasi Total Biaya Sewa -->
                    <div style="grid-column: span 2;">
                        <div class="p-3 rounded-2" style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
                            <span class="text-body-secondary small d-block">Estimasi Total Biaya Sewa:</span>
                            <h4 class="fw-bold mb-0 text-primary" id="estimasi_harga">
                                Rp {{ isset($rental) ? number_format($rental->total_harga, 0, ',', '.') : '0' }}
                            </h4>
                            <input type="hidden" name="total_harga" id="total_harga_input" value="{{ old('total_harga', $rental->total_harga ?? 0) }}">
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="/data-rental" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="background-color: #0d6efd; color: #ffffff; border-color: #0d6efd;">
                        <i class="bi bi-save me-1"></i> {{ isset($rental) ? 'Update Transaksi' : 'Simpan Transaksi' }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    const carSelect = document.getElementById('car_id');
    const tglMulai = document.getElementById('tanggal_mulai');
    const tglSelesai = document.getElementById('tanggal_selesai');
    const estimasiEl = document.getElementById('estimasi_harga');
    const totalHargaInput = document.getElementById('total_harga_input');

    function hitungTotal() {
        const selectedOption = carSelect.options[carSelect.selectedIndex];
        const hargaPerHari = parseFloat(selectedOption.getAttribute('data-harga')) || 0;

        if (tglMulai.value && tglSelesai.value && hargaPerHari > 0) {
            const start = new Date(tglMulai.value);
            const end = new Date(tglSelesai.value);
            const diffTime = end - start;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays < 1) diffDays = 1;

            const total = diffDays * hargaPerHari;
            estimasiEl.textContent = 'Rp ' + total.toLocaleString('id-ID') + ` (${diffDays} hari)`;
            totalHargaInput.value = total;
        }
    }

    carSelect.addEventListener('change', hitungTotal);
    tglMulai.addEventListener('change', hitungTotal);
    tglSelesai.addEventListener('change', hitungTotal);
</script>
@endsection