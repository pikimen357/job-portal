<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar - Job Portal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
        }
        .table-actions {
            white-space: nowrap;
        }
        .status-badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-briefcase-fill"></i> Job Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/applications">
                            <i class="bi bi-file-text"></i> Lamaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications.index') }}">
                            <i class="bi bi-bell"></i> Notifikasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="header-gradient">
        <div class="container">
            <h1 class="mb-0">
                <i class="bi bi-people-fill"></i> Daftar Pelamar
            </h1>
            <p class="mb-0 opacity-75">Kelola semua lamaran pekerjaan</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter & Export Section -->
                <div class="row mb-4 align-items-center">
                    <!-- Filter by Job -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="input-group">
                            <label class="input-group-text" for="job-filter">
                                <i class="bi bi-funnel"></i> Filter Lowongan
                            </label>
                            <select id="job-filter" name="job_id" class="form-select" onchange="filterApplications(this.value)">
                                <option value="">Semua Lowongan</option>
                                @foreach($jobs as $job)
                                    <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                        {{ $job->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    <div class="col-md-6 text-md-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('applications.export') }}" class="btn btn-primary">
                                <i class="bi bi-download"></i> Export Semua
                            </a>
                            @if(request('job_id'))
                                <a href="{{ route('applications.export.job', request('job_id')) }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-excel"></i> Export Filter
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h3 class="text-primary">{{ $applications->count() }}</h3>
                                <p class="text-muted mb-0">Total Lamaran</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <h3 class="text-warning">{{ $applications->where('status', 'Pending')->count() }}</h3>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h3 class="text-success">{{ $applications->where('status', 'Accepted')->count() }}</h3>
                                <p class="text-muted mb-0">Diterima</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-danger">
                            <div class="card-body text-center">
                                <h3 class="text-danger">{{ $applications->where('status', 'Rejected')->count() }}</h3>
                                <p class="text-muted mb-0">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelamar</th>
                                <th>Lowongan</th>
                                <th>Tanggal Melamar</th>
                                <th>CV</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $index => $app)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                             style="width: 40px; height: 40px; font-weight: bold;">
                                            {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $app->user->name }}</div>
                                            <small class="text-muted">{{ $app->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $app->job->title }}</span>
                                </td>
                                <td>
                                    <small>{{ $app->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ asset('storage/' . $app->cv) }}" target="_blank"
                                           class="btn btn-outline-primary" title="Lihat CV">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $app->cv) }}" download
                                           class="btn btn-outline-success" title="Download CV">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if($app->status === 'Pending')
                                        <span class="badge bg-warning text-dark status-badge">
                                            <i class="bi bi-clock"></i> Pending
                                        </span>
                                    @elseif($app->status === 'Accepted')
                                        <span class="badge bg-success status-badge">
                                            <i class="bi bi-check-circle"></i> Diterima
                                        </span>
                                    @else
                                        <span class="badge bg-danger status-badge">
                                            <i class="bi bi-x-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="table-actions text-center">
                                    @if($app->status === 'Pending')
                                        <div class="btn-group btn-group-sm" role="group">
                                            <form action="{{ route('applications.accept', $app->id) }}" method="POST" class="d-inline me-2"
                                                  onsubmit="return confirm('Terima lamaran dari {{ $app->user->name }}?')">
                                                @csrf
                                                <button type="submit" class="btn btn-success" title="Terima">
                                                    <i class="bi bi-check-lg"></i> Terima
                                                </button>
                                            </form>

                                            <form action="{{ route('applications.reject', $app->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tolak lamaran dari {{ $app->user->name }}?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" title="Tolak">
                                                    <i class="bi bi-x-lg"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-lock"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Tidak ada data pelamar</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        function filterApplications(jobId) {
            const url = new URL(window.location.href);
            if (jobId) {
                url.searchParams.set('job_id', jobId);
            } else {
                url.searchParams.delete('job_id');
            }
            window.location.href = url.toString();
        }

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
