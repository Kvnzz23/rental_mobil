@extends('layouts.master')

@section('title', 'Data Rental')

@section('konten')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Rental</h2>
            <p class="text-body-secondary mb-0">Kelola data penyewaan mobil pelanggan.</p>
        </div>

        <a href="/data-rental/create" class="btn btn-primary" style="background-color: #0d6efd; color: #ffffff; border-color: #0d6efd;">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Rental
        </a>
    </div>

    <!-- Tabel -->
    <div class="card border shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Mobil</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_rental as $index => $rental)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $rental->customer->nama_customer ?? '-' }}</td>
                            <td>
                                {{ $rental->car->nama_mobil ?? '-' }}
                                <small class="text-body-secondary d-block">{{ $rental->car->plat_nomor ?? '' }}</small>
                            </td>
                            <td>{{ date('d M Y', strtotime($rental->tanggal_mulai)) }}</td>
                            <td>{{ date('d M Y', strtotime($rental->tanggal_selesai)) }}</td>
                            <td class="fw-semibold">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($rental->status == 'selesai')
                                <span class="badge" style="background-color: #198754; color: #ffffff;">Selesai</span>
                                @elseif ($rental->status == 'berjalan')
                                <span class="badge" style="background-color: #0d6efd; color: #ffffff;">Berjalan</span>
                                @elseif ($rental->status == 'batal')
                                <span class="badge" style="background-color: #dc3545; color: #ffffff;">Batal</span>
                                @else
                                <span class="badge" style="background-color: #ffc107; color: #000000;">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Tombol Selesai (muncul jika status bukan selesai/batal) -->
                                    @if ($rental->status == 'pending' || $rental->status == 'berjalan')
                                    <form action="{{ route('rental.selesai', $rental->id_rental) }}" method="POST" onsubmit="return confirm('Selesaikan sewa dan kembalikan status mobil menjadi tersedia?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm" style="background-color: #198754; color: #ffffff;" title="Selesaikan Sewa">
                                            <i class="bi bi-check-lg"></i> Selesai
                                        </button>
                                    </form>
                                    <a href="{{ route('rental.edit', $rental->id_rental) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @endif

                                    <button type="button"
                                        class="btn-solid theme-danger"
                                        data-bs-toggle="dialog"
                                        data-bs-target="#hapus{{ $rental->id_rental }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-body-secondary py-4">
                                Belum ada data rental.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @foreach ($data_rental as $rental)
                <dialog class="dialog" id="hapus{{ $rental->id_rental }}">
                    <div class="dialog-header">
                        <h1 class="dialog-title">Hapus Data Rental?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                    </div>

                    <div class="dialog-body">
                        <p>Apakah kamu yakin ingin menghapus data rental dari <strong>{{ $rental->customer->nama_customer }}</strong>?</p>
                    </div>

                    <div class="dialog-footer">
                        <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                            Batal
                        </button>

                        <form action="{{ route('rental.destroy', $rental->id_rental) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-solid theme-danger">
                                Hapus
                            </button>
                        </form>
                    </div>
                </dialog>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection