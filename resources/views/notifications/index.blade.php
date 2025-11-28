<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Dashboard Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .notification-item {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .notification-item.unread {
            background-color: #e7f3ff;
            border-left-color: #0d6efd;
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-card {
            border-left: 4px solid #0d6efd;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 10px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Navbar (Optional) -->
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
                        <a class="nav-link" href="{{ route('applications.index') }}">
                            <i class="bi bi-file-text"></i> Lamaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('notifications.index') }}">
                            <i class="bi bi-bell-fill"></i> Notifikasi
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="badge bg-danger rounded-pill">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1 class="mb-1">
                            <i class="bi bi-bell-fill"></i> Notifikasi
                        </h1>
                        <p class="mb-0 opacity-75">Kelola semua notifikasi Anda</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-light">
                                    <i class="bi bi-check-all"></i> Tandai Semua Dibaca
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->notifications->count() > 0)
                            <form action="{{ route('notifications.destroyAll') }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus semua notifikasi?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus Semua
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-number">{{ auth()->user()->notifications->count() }}</div>
                        <div class="text-muted">Total Notifikasi</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-number text-primary">{{ auth()->user()->unreadNotifications->count() }}</div>
                        <div class="text-muted">Belum Dibaca</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-number text-success">{{ auth()->user()->readNotifications->count() }}</div>
                        <div class="text-muted">Sudah Dibaca</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul"></i> Daftar Notifikasi
                </h5>
            </div>
            <div class="card-body p-0">
                @forelse($notifications as $notification)
                    <div class="notification-item {{ $notification->read_at ? '' : 'unread' }} border-bottom">
                        <div class="d-flex gap-3 p-3">
                            <!-- Icon -->
                            <div class="notification-icon flex-shrink-0">
                                📋
                            </div>

                            <!-- Content -->
                            <div class="flex-grow-1">
                                <!-- Title -->
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h6 class="mb-0 fw-bold">
                                        {{ $notification->data['job_title'] ?? 'Notifikasi Baru' }}
                                    </h6>
                                    @if(!$notification->read_at)
                                        <span class="badge bg-primary">Baru</span>
                                    @endif
                                </div>

                                <!-- Message -->
                                <p class="text-muted mb-2">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>

                                <!-- Details -->
                                <div class="small mb-3">
                                    @if(isset($notification->data['user_name']))
                                        <div class="mb-1">
                                            <strong><i class="bi bi-person"></i> Pelamar:</strong>
                                            {{ $notification->data['user_name'] }}
                                        </div>
                                    @endif
                                    @if(isset($notification->data['user_email']))
                                        <div class="mb-1">
                                            <strong><i class="bi bi-envelope"></i> Email:</strong>
                                            <a href="mailto:{{ $notification->data['user_email'] }}">
                                                {{ $notification->data['user_email'] }}
                                            </a>
                                        </div>
                                    @endif
                                    <div class="text-muted">
                                        <i class="bi bi-clock"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                        ({{ $notification->created_at->format('d M Y, H:i') }})
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 flex-wrap">
                                    @if(isset($notification->data['application_id']))
                                        <a href="{{ route('applications.index') }}?application_id={{ $notification->data['application_id'] }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Lihat Lamaran
                                        </a>
                                    @endif

                                    @if(isset($notification->data['cv_path']))
                                        <a href="{{ url(Storage::url($notification->data['cv_path'])) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-file-pdf"></i> Download CV
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons (Right Side) -->
                            <div class="d-flex flex-column gap-2">
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-secondary action-btn"
                                                title="Tandai dibaca">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.destroy', $notification->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger action-btn"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div style="font-size: 5rem;" class="text-muted mb-3">
                            <i class="bi bi-bell-slash"></i>
                        </div>
                        <h5 class="text-muted">Tidak Ada Notifikasi</h5>
                        <p class="text-muted">Semua notifikasi akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto dismiss alerts -->
    <script>
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
