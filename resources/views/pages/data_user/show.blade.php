@extends('layouts.master')
@section('title', 'Data User')

@section('konten')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0 fw-bold">Data Pengguna (User)</h4>
            <small class="text-muted">Kelola akun Admin dan Staff yang dapat mengakses sistem</small>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Tambah User
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 ms-auto">
                    <form action="/data-user" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari user..."
                                value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat Pada</th>
                            <th class="text-center" style="width: 18%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_user as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                <span class="badge bg-info text-dark ms-1">Akun Anda</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                                @else
                                <span class="badge bg-secondary">Staff</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @if ($user->id !== auth()->id())
                                <button type="button"
                                    class="btn-solid theme-danger"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#hapus{{ $user->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data pengguna yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @foreach ($data_user as $user)
                <dialog class="dialog" id="hapus{{ $user->id }}">
                    <div class="dialog-header">
                        <h1 class="dialog-title">Hapus Data Mobil?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
                    </div>

                    <div class="dialog-body">
                        <p>Apakah kamu yakin ingin menghapus data user <strong>{{ $user->name }}</strong>?</p>
                    </div>

                    <div class="dialog-footer">
                        <button type="button" class="btn-solid theme-secondary" data-bs-dismiss="dialog">
                            Batal
                        </button>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
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