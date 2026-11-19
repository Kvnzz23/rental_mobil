@extends('layouts.master')

@section('title', 'Dashboard')

@section('konten')

<style>
    .stat-card {
        border-radius: 1rem;
        border: none;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #fff;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18) !important;
    }

    .stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    .stat-card .stat-label {
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        opacity: 0.88;
    }

    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.1;
        margin: 0.2rem 0 0;
    }

    .stat-card-blue {
        background: linear-gradient(135deg, #0d6efd, #3d8bfd);
    }

    .stat-card-green {
        background: linear-gradient(135deg, #198754, #2ecc8e);
    }

    .stat-card-red {
        background: linear-gradient(135deg, #dc3545, #f06574);
    }

    .stat-card-purple {
        background: linear-gradient(135deg, #6f42c1, #9d70e0);
    }

    /* Tabel */
    .table thead th {
        background-color: #f8f9fa;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #6c757d;
        border-bottom: 2px solid #e9ecef;
        padding: 0.85rem 1rem;
    }

    .table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        border-color: #f1f3f5;
    }

    .table tbody tr:hover td {
        background-color: #f8f9ff;
    }

    /* Quick Action buttons */
    .quick-action-btn {
        border-radius: 0.75rem;
        padding: 1rem 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.9rem;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s, transform 0.15s;
        border: 1.5px solid;
    }

    .quick-action-btn:hover {
        transform: translateX(3px);
    }

    .quick-action-btn .qa-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .qa-primary {
        border-color: #0d6efd;
        color: #0d6efd;
        background: #fff;
    }

    .qa-primary:hover {
        background: #0d6efd;
        color: #fff;
    }

    .qa-primary .qa-icon {
        background: rgba(13, 110, 253, 0.1);
    }

    .qa-primary:hover .qa-icon {
        background: rgba(255, 255, 255, 0.2);
    }

    .qa-success {
        border-color: #198754;
        color: #198754;
        background: #fff;
    }

    .qa-success:hover {
        background: #198754;
        color: #fff;
    }

    .qa-success .qa-icon {
        background: rgba(25, 135, 84, 0.1);
    }

    .qa-success:hover .qa-icon {
        background: rgba(255, 255, 255, 0.2);
    }

    .qa-secondary {
        border-color: #6c757d;
        color: #495057;
        background: #fff;
    }

    .qa-secondary:hover {
        background: #6c757d;
        color: #fff;
    }

    .qa-secondary .qa-icon {
        background: rgba(108, 117, 125, 0.1);
    }

    .qa-secondary:hover .qa-icon {
        background: rgba(255, 255, 255, 0.2);
    }

    .section-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .section-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.25rem 1.5rem;
        border-radius: 1rem 1rem 0 0 !important;
    }

    .page-header-badge {
        background: linear-gradient(135deg, #0d6efd22, #0d6efd11);
        border: 1px solid #0d6efd33;
        color: #0d6efd;
        border-radius: 50rem;
        padding: 0.3rem 0.9rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .availability-bar {
        height: 6px;
        border-radius: 3px;
        background: #e9ecef;
        overflow: hidden;
        margin-top: 0.4rem;
    }

    .availability-bar-fill {
        height: 100%;
        border-radius: 3px;
        background: linear-gradient(90deg, #198754, #2ecc8e);
        transition: width 0.6s ease;
    }
</style>

<div class="container-fluid px-1">

    {{-- ── Header ── --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="page-header-badge">
                    <i class="bi bi-speedometer2 me-1"></i>Overview
                </span>
            </div>
            <h2 class="fw-bold mb-1" style="font-size:1.6rem;">Dasbor Rental Mobil</h2>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Ringkasan operasional & ketersediaan armada secara real-time.
            </p>
        </div>
        @if (auth()->user()->role == 'admin')
        <a href="{{ route('cars.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4"
            style="border-radius: 0.6rem; font-weight: 600;">
            <i class="bi bi-plus-circle-fill"></i>
            Tambah Mobil
        </a>
        @endif
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-card-blue shadow-sm">
                <div>
                    <p class="stat-label mb-0">Total Armada</p>
                    <p class="stat-value">{{ $totalMobil ?? 0 }}</p>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-car-front-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-card-green shadow-sm">
                <div>
                    <p class="stat-label mb-0">Tersedia</p>
                    <p class="stat-value">{{ $mobilTersedia ?? 0 }}</p>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-card-red shadow-sm">
                <div>
                    <p class="stat-label mb-0">Sedang Disewa</p>
                    <p class="stat-value">{{ $mobilDisewa ?? 0 }}</p>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-key-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-card-purple shadow-sm">
                <div>
                    <p class="stat-label mb-0">Total Pelanggan</p>
                    <p class="stat-value">{{ $totalPelanggan ?? 0 }}</p>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Ketersediaan Armada Mini-Bar ── --}}
    @php
    $total = (int) ($totalMobil ?? 0);
    $avail = (int) ($mobilTersedia ?? 0);
    $pct = $total > 0 ? (int) round($avail / $total * 100) : 0;
    $barWidth = $pct . '%';
    @endphp
    <div class="card section-card mb-4 px-4 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-semibold" style="font-size:0.9rem;">Tingkat Ketersediaan Armada</span>
                <span class="text-muted ms-2" style="font-size:0.82rem;">
                    {{ $avail }} dari {{ $total }} unit siap disewa
                </span>
            </div>
            <span class="fw-bold" style="color:#198754; font-size:1rem;">{{ $pct }}%</span>
        </div>
        <div class="progress mt-2" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" style="--bar-width: {{ $barWidth }}; width: var(--bar-width);"></div>
        </div>
    </div>

    {{-- ── Main Grid: Tabel + Aksi Cepat ── --}}
    <div class="row g-4">

        {{-- Kolom Kiri: Tabel Armada Terbaru --}}
        <div class="col-12 col-lg-8">
            <div class="card section-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:4px; height:20px; background:#0d6efd; border-radius:2px;"></div>
                        <h6 class="fw-bold mb-0">Status Armada Terbaru</h6>
                    </div>
                    <a href="{{ route('cars.index') }}"
                        class="text-decoration-none d-flex align-items-center gap-1"
                        style="font-size:0.82rem; font-weight:600; color:#0d6efd;">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th style="padding-left:1.5rem;">#</th>
                                    <th>Nama Mobil</th>
                                    <th>Plat Nomor</th>
                                    <th>Harga / Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mobilTerbaru ?? [] as $i => $mobil)
                                <tr>
                                    <td style="padding-left:1.5rem; color:#adb5bd; font-size:0.82rem;">
                                        {{ $i + 1 }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:34px; height:34px; border-radius:8px; background:#e9ecef;
                                                        display:flex; align-items:center; justify-content:center;
                                                        color:#6c757d; font-size:1rem; flex-shrink:0;">
                                                <i class="bi bi-car-front"></i>
                                            </div>
                                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $mobil->nama_mobil }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <code style="background:#f1f3f5; border-radius:4px; padding:0.2rem 0.5rem;
                                                     font-size:0.82rem; color:#495057;">
                                            {{ $mobil->plat_nomor }}
                                        </code>
                                    </td>
                                    <td class="fw-semibold" style="font-size:0.88rem;">
                                        Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if ($mobil->status == 'tersedia')
                                        <span class="badge d-inline-flex align-items-center gap-1"
                                            style="background:#d1fae5; color:#065f46; border-radius:50rem;
                                                         font-weight:600; padding:0.35rem 0.75rem; font-size:0.75rem;">
                                            <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                                            Tersedia
                                        </span>
                                        @else
                                        <span class="badge d-inline-flex align-items-center gap-1"
                                            style="background:#fee2e2; color:#991b1b; border-radius:50rem;
                                                         font-weight:600; padding:0.35rem 0.75rem; font-size:0.75rem;">
                                            <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                                            Disewa
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5" style="color:#adb5bd;">
                                        <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:0.5rem;"></i>
                                        Belum ada data mobil.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi Cepat --}}
        <div class="col-12 col-lg-4">
            <div class="card section-card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:4px; height:20px; background:#6f42c1; border-radius:2px;"></div>
                        <h6 class="fw-bold mb-0">Aksi Cepat</h6>
                    </div>
                    <p class="text-muted mb-0 mt-1" style="font-size:0.8rem; padding-left:0.75rem;">
                        Pintasan untuk mencatat transaksi &amp; kelola data.
                    </p>
                </div>

                <div class="card-body d-flex flex-column gap-3 pt-4">

                    <a href="/data-rental" class="quick-action-btn qa-primary">
                        <div class="qa-icon">
                            <i class="bi bi-journal-plus"></i>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:0.88rem;">Transaksi Rental Baru</div>
                            <small style="opacity:0.7; font-size:0.78rem;">Catat penyewaan mobil pelanggan</small>
                        </div>
                    </a>

                    <a href="{{ route('customer.index') }}" class="quick-action-btn qa-success">
                        <div class="qa-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:0.88rem;">Kelola Data Pelanggan</div>
                            <small style="opacity:0.7; font-size:0.78rem;">Tambah atau perbarui profil penyewa</small>
                        </div>
                    </a>
                    @if (auth()->user()->role == 'admin')
                    <a href="/laporan" class="quick-action-btn qa-secondary">
                        <div class="qa-icon">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:0.88rem;">Lihat Laporan</div>
                            <small style="opacity:0.7; font-size:0.78rem;">Rekap pendapatan &amp; riwayat sewa</small>
                        </div>
                    </a>
                    @endif

                    <div class="mt-auto pt-2" style="border-top: 1px dashed #e9ecef;">
                        <div class="d-flex align-items-center justify-content-between text-muted"
                            style="font-size:0.78rem;">
                            <span><i class="bi bi-clock me-1"></i>Diperbarui: {{ now()->format('d/m/Y H:i') }}</span>
                            <span class="d-flex align-items-center gap-1">
                                <i class="bi bi-circle-fill text-success" style="font-size:0.45rem;"></i>
                                Live
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection