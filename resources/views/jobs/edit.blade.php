<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pekerjaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 25px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
        }
        .logo-preview {
            max-width: 120px;
            max-height: 120px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 8px;
            margin-top: 10px;
        }
        .required-label::after {
            content: " *";
            color: #dc3545;
        }
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Lowongan Pekerjaan</h4>
                        <p class="mb-0 mt-1 opacity-75">Perbarui informasi lowongan pekerjaan</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Informasi Pekerjaan -->
                            <h5 class="section-title">Informasi Pekerjaan</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label required-label">Judul Lowongan</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $job->title) }}" required>
                                    @error('title')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis_pekerjaan" class="form-label required-label">Jenis Pekerjaan</label>
                                    <select class="form-select" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                                        <option value="">Pilih Jenis Pekerjaan</option>
                                        <option value="full_time" {{ old('jenis_pekerjaan', $job->jenis_pekerjaan) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part_time" {{ old('jenis_pekerjaan', $job->jenis_pekerjaan) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                    </select>
                                    @error('jenis_pekerjaan')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label required-label">Deskripsi Pekerjaan</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $job->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Informasi Perusahaan -->
                            <h5 class="section-title mt-4">Informasi Perusahaan</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company" class="form-label required-label">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $job->company) }}" required>
                                    @error('company')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label required-label">Lokasi</label>
                                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $job->location) }}" required>
                                    @error('location')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Detail Tambahan -->
                            <h5 class="section-title mt-4">Detail Tambahan</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="salary" class="form-label">Gaji</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary', $job->salary) }}" min="0" placeholder="0">
                                    </div>
                                    @error('salary')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="logo" class="form-label">Logo Perusahaan</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/jpg,image/png,image/jpeg">
                                    <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 2MB.</div>
                                    @error('logo')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Logo Preview -->
                            <div class="row">
                                <div class="col-12">
                                    <div id="logoPreview" class="mb-3">
                                        <!-- Preview logo baru akan muncul di sini -->
                                    </div>

                                    <!-- Current Logo -->
                                    @if($job->logo)
                                    <div class="mb-3">
                                        <p class="mb-1 fw-semibold">Logo saat ini:</p>
                                        <img src="{{ asset('storage/' . $job->logo) }}" alt="Logo Perusahaan" class="logo-preview">
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-left me-1"></i>Kembali
                                        </a>
                                        <div>
                                            <button type="reset" class="btn btn-outline-danger me-2">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-lg me-1"></i>Update Lowongan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Preview Logo -->
    <script>
        document.getElementById('logo').addEventListener('change', function(e) {
            const preview = document.getElementById('logoPreview');
            preview.innerHTML = '';

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('logo-preview');
                    preview.innerHTML = '<p class="mb-1 fw-semibold">Pratinjau logo baru:</p>';
                    preview.appendChild(img);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>
</html>
