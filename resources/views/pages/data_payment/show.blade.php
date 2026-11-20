@extends('layouts.master')
@section('title', 'Data Pembayaran')

@section('konten')
<style>
    .clean-table-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }

    .clean-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.9rem 1rem;
    }

    .clean-table tbody td {
        padding: 0.95rem 1rem;
        color: #334155;
        font-size: 0.93rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .clean-table tbody tr:last-child td {
        border-bottom: none;
    }

    .clean-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge-unpaid {
        background-color: #fef3c7;
        color: #b45309;
        font-weight: 600;
        padding: 0.4em 0.75em;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    .badge-paid {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 600;
        padding: 0.4em 0.75em;
        border-radius: 6px;
        font-size: 0.8rem;
    }
</style>

<div class="container-fluid py-4">
    {{-- Header Judul --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Data Pembayaran Rental</h3>
            <p class="text-muted mb-0">Kelola tagihan penyewaan mobil dan konfirmasi status pembayaran pelanggan.</p>
        </div>

        {{-- Filter Ringkas (Tampilan Visual) --}}
        <div class="d-flex gap-2">
            <select id="filterStatus" class="form-select form-select-sm" style="width: 180px; border-radius: 8px;">
                <option value="all" selected>Semua Status</option>
                <option value="unpaid">Belum Terbayar</option>
                <option value="paid">Terbayar</option>
            </select>
        </div>
    </div>

    {{-- Card Tabel Pembayaran --}}
    <div class="clean-table-card">
        <div class="table-responsive">
            <table class="table clean-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Kode Sewa</th>
                        <th>Pelanggan</th>
                        <th>Unit Mobil</th>
                        <th>Periode Sewa</th>
                        <th>Total Tagihan</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 1. Daftar Tagihan Belum Terbayar (Pending) --}}
                    @foreach($pendingPayment as $pending)
                    <tr class="payment-row" data-status="unpaid">
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold text-primary">#RNT-{{ str_pad($pending->id_rental, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $pending->customer->nama_customer ?? '-' }}</div>
                            <div class="small text-muted">{{ $pending->customer->no_hp ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $pending->car->nama_mobil ?? '-' }}</div>
                            <div class="small text-muted">{{ $pending->car->plat_nomor ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($pending->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($pending->tanggal_selesai)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="fw-bold text-dark">Rp {{ number_format($pending->total_harga, 0, ',', '.') }}</td>
                        <td class="text-muted">{{ $pending->payment->tgl_pembayaran ?? '-' }}</td>
                        <td>
                            <span class="badge-unpaid">Unpaid</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button"
                                    class="btn-solid theme-primary"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#detail{{ $pending->id_rental }}"
                                    title="Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button type="button"
                                    class="btn-solid theme-success"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#paid{{ $pending->id_rental }}"
                                    title="Tandai Terbayar">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    {{-- 2. Daftar Pembayaran Lunas (Paid) --}}
                    @foreach($paidPayment as $paid)
                    <tr class="payment-row" data-status="paid">
                        <td>{{ $pendingPayment->count() + $loop->iteration }}</td>
                        <td class="fw-semibold text-primary">#RNT-{{ str_pad($paid->rental->id_rental, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $paid->rental->customer->nama_customer ?? '-' }}</div>
                            <div class="small text-muted">{{ $paid->rental->customer->no_hp ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $paid->rental->car->nama_mobil ?? '-' }}</div>
                            <div class="small text-muted">{{ $paid->rental->car->plat_nomor ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($paid->rental->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($paid->rental->tanggal_selesai)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="fw-bold text-dark">Rp {{ number_format($paid->total, 0, ',', '.') }}</td>
                        <td class="text-muted">
                            {{ $paid->tgl_pembayaran ? \Carbon\Carbon::parse($paid->tgl_pembayaran)->format('d M Y') : '-' }}
                        </td>
                        <td>
                            <span class="badge-paid text-capitalize">{{ $paid->status }}</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <button type="button"
                                    class="btn-solid theme-primary"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#detail{{ $paid->rental->id_rental }}"
                                    title="Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <span class="text-muted small d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-check2-all text-success"></i> Lunas
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    {{-- 3. Jika Keduanya Benar-Benar Kosong --}}
                    @if ($pendingPayment->isEmpty() && $paidPayment->isEmpty())
                    <tr id="emptyFilterRow">
                        <td colspan="9" class="text-center py-4">
                            <i class="bi bi-receipt fs-1 text-muted"></i>
                            <p class="text-muted mb-0 mt-2">
                                Belum ada data pembayaran.
                            </p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            @foreach ($pendingPayment as $pending)
            <dialog class="dialog" id="paid{{ $pending->id_rental }}">
                <div class="dialog-header">
                    <h1 class="dialog-title">Konfirmasi Pembayaran Rental</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                </div>

                <div class="dialog-body">
                    <p>Apakah kamu yakin kode sewa #RNT-{{ str_pad($pending->id_rental, 3, '0', STR_PAD_LEFT) }} sudah lunas?</strong>?</p>
                </div>

                <div class="dialog-footer">
                    <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                        Batal
                    </button>

                    <form action="{{ route('payment.paid', $pending->id_rental) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-solid theme-danger">
                            Confirm
                        </button>
                    </form>
                </div>
            </dialog>

            <dialog class="dialog" id="detail{{ $pending->id_rental }}">
                <div class="dialog-header">
                    <h1 class="dialog-title">Detail Rental #RNT-{{ str_pad($pending->id_rental, 3, '0', STR_PAD_LEFT) }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                </div>

                <div class="dialog-body">
                    {{-- Header Status & Kode Sewa --}}
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Kode Sewa</span>
                            <span class="fw-bold text-primary fs-5">#RNT-{{ str_pad($pending->id_rental, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <span class="badge-unpaid">Belum Terbayar</span>
                    </div>

                    {{-- Informasi Pelanggan & Mobil --}}
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <span class="text-muted small d-block">Pelanggan</span>
                            <span class="fw-semibold text-dark d-block">{{ $pending->customer->nama_customer ?? '-' }}</span>
                            <span class="small text-muted">{{ $pending->customer->no_hp ?? '-' }}</span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small d-block">Unit Mobil</span>
                            <span class="fw-semibold text-dark d-block">{{ $pending->car->nama_mobil ?? '-' }}</span>
                            <span class="small text-muted">{{ $pending->car->plat_nomor ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Rincian Waktu & Biaya --}}
                    <div class="bg-light p-3 rounded-3 border">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tanggal Mulai</span>
                            <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($pending->tanggal_mulai)->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tanggal Selesai</span>
                            <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($pending->tanggal_selesai)->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tanggal Pembayaran</span>
                            <span class="text-muted">-</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-dark">Total Tagihan</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($pending->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="dialog-footer">
                    <button type="button"
                        data-url="{{ route('payment.nota', $pending->id_rental) }}"
                        onclick="window.location.href = this.dataset.url"
                        class="btn btn-sm btn-outline-primary"
                        title="Cetak Nota">
                        <i class="bi bi-printer"></i>
                    </button>
                    <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                        Selesai
                    </button>
                </div>
            </dialog>
            @endforeach
            @foreach ($paidPayment as $paid)
            <dialog class="dialog" id="detail{{ $paid->rental->id_rental }}">
                <div class="dialog-header">
                    <h1 class="dialog-title">Detail Rental #RNT-{{ str_pad($paid->rental->id_rental, 3, '0', STR_PAD_LEFT) }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                </div>

                <div class="dialog-body">
                    {{-- Header Status & Kode Sewa --}}
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Kode Sewa</span>
                            <span class="fw-bold text-primary fs-5">#RNT-{{ str_pad($paid->rental->id_rental, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <span class="badge-paid">Terbayar</span>
                    </div>

                    {{-- Informasi Pelanggan & Mobil --}}
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <span class="text-muted small d-block">Pelanggan</span>
                            <span class="fw-semibold text-dark d-block">{{ $paid->rental->customer->nama_customer ?? '-' }}</span>
                            <span class="small text-muted">{{ $paid->rental->customer->no_hp ?? '-' }}</span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small d-block">Unit Mobil</span>
                            <span class="fw-semibold text-dark d-block">{{ $paid->rental->car->nama_mobil ?? '-' }}</span>
                            <span class="small text-muted">{{ $paid->rental->car->plat_nomor ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Rincian Waktu & Biaya --}}
                    <div class="bg-light p-3 rounded-3 border">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tanggal Mulai</span>
                            <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($paid->rental->tanggal_mulai)->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tanggal Selesai</span>
                            <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($paid->rental->tanggal_selesai)->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tanggal Pembayaran</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($paid->tgl_pembayaran)->format('d M Y') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-dark">Total Tagihan</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($paid->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="dialog-footer">
                    <button type="button"
                        data-url="{{ route('payment.nota', $paid->rental->id_rental) }}"
                        onclick="window.location.href = this.dataset.url"
                        class="btn btn-sm btn-outline-primary"
                        title="Cetak Nota">
                        <i class="bi bi-printer"></i>
                    </button>
                    <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                        Selesai
                    </button>
                </div>
                @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filterStatus');
        const rows = document.querySelectorAll('.payment-row');
        const emptyRow = document.getElementById('emptyFilterRow');

        filterSelect.addEventListener('change', function() {
            const selected = this.value;
            let visibleCount = 0;

            rows.forEach(function(row) {
                const status = row.dataset.status;

                if (selected === 'all' || status === selected) {
                    row.style.display = '';
                    visibleCount++;
                    // Perbarui nomor urut agar tetap rapi (1, 2, 3...)
                    const numberCell = row.querySelector('.row-number');
                    if (numberCell) {
                        numberCell.textContent = visibleCount;
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        });
    });
</script>
@endsection