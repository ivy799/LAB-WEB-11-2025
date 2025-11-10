<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It Simulator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #d32f2f;  /* Merah utama */
            --bs-primary-rgb: 211, 47, 47;
            --bs-body-bg: #fff5f5; /* Latar belakang lembut */
            --bs-success: #ef5350;
        }

        body {
            background-color: var(--bs-body-bg);
        }

        .navbar {
            background-color: var(--bs-primary) !important;
        }

        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .btn-primary:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }

        .table-primary {
            background-color: #ffcdd2 !important;
        }

        .alert-success {
            background-color: #ef9a9a;
            border-color: #e57373;
            color: #b71c1c;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('fishes.index') }}">Fish It Simulator</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('fishes.index') }}">Daftar Ikan</a>
                <a class="nav-link" href="{{ route('fishes.create') }}">Tambah Ikan</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
