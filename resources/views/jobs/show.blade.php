<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - Detail Lowongan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .company-logo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Header Job --}}
            <div class="d-flex align-items-center mb-4">
                @if($job->logo)
                    <img src="{{ asset('storage/' . $job->logo) }}"
                         alt="Logo {{ $job->company }}"
                         class="company-logo me-3">
                @endif
                <div>
                    <h2 class="mb-0">{{ $job->title }}</h2>
                    <p class="text-muted mb-1">{{ $job->company }}</p>
                    <span class="badge bg-secondary">{{ $job->location }}</span>
                </div>
            </div>

            {{-- Deskripsi --}}
            <h5>Deskripsi Pekerjaan</h5>
            <p>{{ $job->description }}</p>

            {{-- Gaji --}}
            <h5>Gaji</h5>
            <p>
                @if($job->salary)
                    <span class="text-success fw-bold">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                @else
                    <span class="text-muted">Tidak disebutkan</span>
                @endif
            </p>

            <hr>

            {{-- Aksi --}}
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-secondary">← Kembali</a>

                @if(auth()->check() && auth()->user()->role !== 'admin')
                    <!-- Tombol buka modal upload CV -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
                        Lamar Sekarang
                    </button>
                @else
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Login untuk Melamar
                        </a>
                    @endguest
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Upload CV --}}
@if(auth()->check() && auth()->user()->role !== 'admin')
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="applyModalLabel">Lamar Pekerjaan - {{ $job->title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <p>Unggah CV Anda dalam format <strong>PDF, DOC, atau DOCX</strong>.</p>
            <div class="mb-3">
                <label for="cv" class="form-label">File CV</label>
                <input type="file" name="cv" id="cv" class="form-control" required accept=".pdf,.doc,.docx">
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Kirim Lamaran</button>
        </div>
    </form>
  </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
