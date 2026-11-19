@extends('layouts.master')
@section('title', 'Data pelanggan')

@section('konten')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Customer</h2>
            <p class="text-muted mb-0">
                Kelola data customer di rental kamu.
            </p>
        </div>

        <a href="{{ route('customer.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Tambah Customer
        </a>
    </div>

    <!-- Card Tabel -->
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-4 ms-auto">
                    <form action="/data-customer" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari customer..."
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
                            <th>Nama Customer</th>
                            <th>No KTP</th>
                            <th>No Hp</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_customer as $customer)
                        @if ($customer)

                        @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $customer->nama_customer }}
                            </td>

                            <td>{{ $customer->no_ktp }}</td>

                            <td>{{ $customer->no_hp }}</td>

                            <td>{{ $customer->alamat }}</td>

                            <td class="text-center">
                                <a href="{{ route('customer.edit', $customer->id_customer) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button type="button"
                                    class="btn-solid theme-danger"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#hapus{{ $customer->id_customer }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </td>
                        </tr>
                        @empty

                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-person fs-1 text-muted"></i>

                                <p class="text-muted mb-0 mt-2">
                                    Belum ada data customer.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                @foreach ($data_customer as $customer)
                <dialog class="dialog" id="hapus{{ $customer->id_customer }}">
                    <div class="dialog-header">
                        <h1 class="dialog-title">Hapus Data Customer?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                    </div>

                    <div class="dialog-body">
                        <p>Apakah kamu yakin ingin menghapus data customer <strong>{{ $customer->nama_customer }}</strong>?</p>
                    </div>

                    <div class="dialog-footer">
                        <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                            Batal
                        </button>

                        <form action="{{ route('customer.destroy', $customer->id_customer) }}" method="POST" class="d-inline">
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