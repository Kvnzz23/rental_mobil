<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- 1. Tambahkan CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .password-wrapper {
            position: relative;
        }

        .btn-toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .btn-toggle-eye:hover {
            color: #0d6efd;
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card border shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-1">Login Sistem</h4>
            <p class="text-body-secondary small mb-4">Masuk sebagai Admin atau Staff.</p>

            @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@rental.com" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    {{-- 2. Bungkus input dan tombol dengan .password-wrapper --}}
                    <div class="password-wrapper">
                        <input id="password" type="password" name="password" class="form-control pe-5" placeholder="••••••••" required>
                        <button type="button"
                            class="btn-toggle-eye"
                            onclick="togglePassword('password', this)"
                            title="Tampilkan / Sembunyikan Password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold">Masuk</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            // 3. Gunakan parameter inputId
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
</body>

</html>