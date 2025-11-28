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
        .import-section {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
        }
        .import-section:hover {
            border-color: #0d6efd;
            background: #e7f1ff;
        }
        .btn-group-custom {
            gap: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-primary">Daftar Lowongan Kerja</h2>

                    @if($isAdmin)
                    <div class="d-flex gap-2">
                        <a href="{{ route('jobs.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Lowongan
                        </a>
                    </div>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Import Section - Hanya untuk Admin -->
                @if($isAdmin)
                <div class="import-section mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0">
                                <i class="fas fa-file-excel text-success"></i> Import Data
                            </h6>
                            <small class="text-muted">Import lowongan dari Excel</small>
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <!-- Download Template Button -->
                                <a href="{{ route('jobs.template') }}"
                                   class="btn btn-outline-success">
                                    <i class="fas fa-download"></i> Download Template
                                </a>

                                <!-- Import Form -->
                                <form action="{{ route('jobs.import') }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      class="d-flex gap-2 align-items-center flex-grow-1"
                                      id="importForm">
                                    @csrf
                                    <div class="input-group" style="max-width: 400px;">
                                        <input type="file"
                                               name="file"
                                               required
                                               class="form-control"
                                               id="fileInput"
                                               accept=".xlsx,.xls"
                                               onchange="updateFileName(this)">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-file-import"></i> Import
                                        </button>
                                    </div>
                                </form>

                                <!-- Info Button -->
                                <button type="button"
                                        class="btn btn-outline-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#importInfoModal">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </div>
                            <small class="text-muted" id="selectedFileName"></small>
                        </div>
                    </div>
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
                                        <td class="fw-bold">
                                            <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none text-primary">
                                                {{ $job->title }}
                                            </a>
                                        </td>

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
                                                     alt="Logo {{ $job->company }}"
                                                     class="table-img">
                                            @else
                                                <span class="text-muted">No Logo</span>
                                            @endif
                                        </td>
                                        <td class="action-buttons">
                                            @if($isAdmin)
                                                <!-- Tombol untuk Admin -->
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
                                            @else
                                                <!-- Tombol untuk Job Seeker -->
                                                <form action="{{ route('apply.store', $job->id) }}"
                                                      method="POST"
                                                      enctype="multipart/form-data"
                                                      class="d-inline">
                                                    @csrf
                                                    <input type="file"
                                                           name="cv"
                                                           required
                                                           class="d-none"
                                                           id="cv-{{ $job->id }}"
                                                           accept=".pdf,.doc,.docx"
                                                           onchange="this.form.submit()">
                                                    <label for="cv-{{ $job->id }}" class="btn btn-primary btn-sm mb-1">
                                                        <i class="fas fa-file-upload"></i> Lamar
                                                    </label>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($jobs->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <br>
                                            Belum ada lowongan yang ditambahkan.
                                            @if($isAdmin)
                                            <br>
                                            <a href="{{ route('jobs.create') }}" class="btn btn-primary mt-2">
                                                Tambah Lowongan Pertama
                                            </a>
                                            @endif
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
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Info Import -->
    <div class="modal fade" id="importInfoModal" tabindex="-1" aria-labelledby="importInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="importInfoModalLabel">
                        <i class="fas fa-info-circle"></i> Panduan Import Data Lowongan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Tips:</strong> Download template terlebih dahulu untuk melihat format yang benar!
                    </div>

                    <h6 class="fw-bold mb-3">Langkah-langkah Import:</h6>
                    <ol class="mb-4">
                        <li class="mb-2">Klik tombol <span class="badge bg-success">Download Template</span> untuk mendapatkan file Excel kosong</li>
                        <li class="mb-2">Buka file template dan isi data sesuai kolom yang tersedia</li>
                        <li class="mb-2">Simpan file Excel Anda</li>
                        <li class="mb-2">Klik tombol <span class="badge bg-secondary">Choose File</span> dan pilih file Excel Anda</li>
                        <li class="mb-2">Klik tombol <span class="badge bg-primary">Import</span> untuk mengunggah data</li>
                    </ol>

                    <h6 class="fw-bold mb-3">Format Kolom Excel:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th width="20%">Kolom</th>
                                    <th width="40%">Keterangan</th>
                                    <th width="40%">Contoh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Title</strong></td>
                                    <td>Judul lowongan pekerjaan</td>
                                    <td class="text-muted">Software Engineer</td>
                                </tr>
                                <tr>
                                    <td><strong>Description</strong></td>
                                    <td>Deskripsi lengkap pekerjaan</td>
                                    <td class="text-muted">Develop and maintain web applications</td>
                                </tr>
                                <tr>
                                    <td><strong>Location</strong></td>
                                    <td>Lokasi penempatan kerja</td>
                                    <td class="text-muted">Jakarta</td>
                                </tr>
                                <tr>
                                    <td><strong>Company</strong></td>
                                    <td>Nama perusahaan</td>
                                    <td class="text-muted">PT Tech Indonesia</td>
                                </tr>
                                <tr>
                                    <td><strong>Salary</strong></td>
                                    <td>Gaji (angka saja, tanpa titik/koma)</td>
                                    <td class="text-muted">8000000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong>
                        <ul class="mb-0 mt-2">
                            <li>File harus berformat Excel (.xlsx atau .xls)</li>
                            <li>Maksimal ukuran file 2MB</li>
                            <li>Pastikan semua kolom wajib terisi</li>
                            <li>Gaji harus berupa angka tanpa pemisah ribuan</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('jobs.template') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome untuk icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            const fileNameElement = document.getElementById('selectedFileName');
            if (fileName) {
                fileNameElement.innerHTML = `<i class="fas fa-file-excel text-success"></i> File terpilih: <strong>${fileName}</strong>`;
            } else {
                fileNameElement.innerHTML = '';
            }
        }

        // Auto submit confirmation
        document.getElementById('importForm')?.addEventListener('submit', function(e) {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length === 0) {
                e.preventDefault();
                alert('Silakan pilih file Excel terlebih dahulu!');
                return false;
            }

            if (!confirm('Apakah Anda yakin ingin mengimport data dari file ini?')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>
