<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lowongan Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Tambah Lowongan Kerja</h4>
                            <a href="#" class="btn btn-sm btn-light">← Kembali</a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Lowongan</label>
                                <input type="text" name="title" id="title" placeholder="Masukkan judul lowongan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Pekerjaan</label>
                                <textarea name="description" id="description" placeholder="Jelaskan deskripsi pekerjaan" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi</label>
                                <input type="text" name="location" id="location" placeholder="Masukkan lokasi kerja" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="company" class="form-label">Nama Perusahaan</label>
                                <input type="text" name="company" id="company" placeholder="Masukkan nama perusahaan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="salary" class="form-label">Gaji</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="salary" id="salary" placeholder="Masukkan jumlah gaji" class="form-control">
                                </div>
                                <div class="form-text">Opsional</div>
                            </div>

                            <div class="mb-4">
                                <label for="logo" class="form-label">Logo Perusahaan</label>
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF (maks. 2MB)</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan Lowongan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
