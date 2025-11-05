<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-primary">Daftar Lowongan Kerja</h2>
                    <a href="{{ route('jobs.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Lowongan
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="25%">Judul Lowongan</th>
                                        <th width="20%">Perusahaan</th>
                                        <th width="15%">Lokasi</th>
                                        <th width="15%">Gaji</th>
                                        <th width="10%">Logo</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                    <tr>
                                        <td class="fw-bold">{{ $job->title }}</td>
                                        <td>{{ $job->company }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $job->location }}</span>
                                        </td>
                                        <td>
                                            @if($job->salary)
                                                <span class="text-success fw-bold">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($job->logo)
                                                <img src="{{ asset('storage/' . $job->logo) }}"
                                                     alt="{{ $job->company }}"
                                                     class="table-img img-thumbnail">
                                            @else
                                                <span class="text-muted">No Logo</span>
                                            @endif
                                        </td>
                                        <td class="action-buttons">
                                            <a href="{{ route('jobs.edit', $job->id) }}"
                                               class="btn btn-warning btn-sm mb-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('jobs.destroy', $job->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-1">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($jobs->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <br>
                                            Belum ada lowongan yang ditambahkan.
                                            <br>
                                            <a href="{{ route('jobs.create') }}" class="btn btn-primary mt-2">
                                                Tambah Lowongan Pertama
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if($jobs->count() > 0)
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $jobs->count() }} lowongan
                            </div>
                            <!-- Pagination bisa ditambahkan di sini jika menggunakan paginate -->
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome untuk icons -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
