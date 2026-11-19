@extends('layouts.master')
@section('title', 'Data Mobil')

@section('konten')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Mobil</h2>
            <p class="text-muted mb-0">
                Kelola data mobil rental kamu.
            </p>
        </div>
        @if (auth()->user()->role == 'admin')
        <a href="{{ route('cars.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Tambah Mobil
        </a>
        @endif
    </div>

    <!-- Card Tabel -->
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-4 ms-auto">
                    <form action="/data-mobil" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari mobil..."
                                value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Merk</th>
                            <th>Nomor Polisi</th>
                            <th>Tahun</th>
                            <th>Harga Sewa</th>
                            <th>Status</th>
                            @if (auth()->user()->role == 'admin')
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_mobil as $mobil)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $mobil->nama_mobil }}
                            </td>

                            <td>{{ $mobil->merk }}</td>

                            <td>{{ $mobil->plat_nomor }}</td>

                            <td>{{ $mobil->tahun }}</td>

                            <td>
                                Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($mobil->status == 'tersedia')
                                <span class="badge badge-solid theme-success">
                                    Tersedia
                                </span>
                                @else
                                <span class="badge badge-solid theme-danger">
                                    Disewa
                                </span>
                                @endif
                            </td>
                            @if (auth()->user()->role == 'admin')
                            <td class="text-center">
                                <a href="{{ route('cars.edit', $mobil->id_cars) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button type="button"
                                    class="btn-solid theme-danger"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#hapus{{ $mobil->id_cars }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </td>
                            @endif
                        </tr>
                        @empty

                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-car-front fs-1 text-muted"></i>

                                <p class="text-muted mb-0 mt-2">
                                    Belum ada data mobil.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                @foreach ($data_mobil as $mobil)
                <dialog class="dialog" id="hapus{{ $mobil->id_cars }}">
                    <div class="dialog-header">
                        <h1 class="dialog-title">Hapus Data Mobil?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                    </div>

                    <div class="dialog-body">
                        <p>Apakah kamu yakin ingin menghapus data mobil <strong>{{ $mobil->nama_mobil }}</strong>?</p>
                    </div>

                    <div class="dialog-footer">
                        <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                            Batal
                        </button>

                        <form action="{{ route('cars.destroy', $mobil->id_cars) }}" method="POST" class="d-inline">
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