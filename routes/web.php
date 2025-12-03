<?php

use App\Http\Controllers\Api\ApplicationApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/status', fn()=> ['status' => 'API is running']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/me', fn(Request $r) => $r->user());
});

Route::get('/', function () {
    return view('welcome');
});

// --- Auth Routes ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// HAPUS DUPLIKASI INI (Ini arahnya ke API controller, tidak lazim di web.php jika sudah ada register di atas)
// Route::post('/register',[\App\Http\Controllers\Api\AuthController::class,'register']);

Route::get('/about', [AuthController::class, 'about'])->name('about');
Route::get('/hello', function () { return "Halo, ini halaman percobaan route!"; })->name('hello');

// HAPUS INI (Bentrok dengan Resource 'jobs' di bawah)
// Route::get('/jobs', [JobController::class, 'index']);


// --- API-like Routes in Web (Consider moving to api.php if possible) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::patch('/applications/{id}/status', [ApplicationApiController::class, 'updateStatus']);
});

// Public Job Routes (API Controller dipakai di Web?)
Route::get('/public/jobs', [JobApiController::class, 'publicIndex']);
Route::get('/public/jobs/{job}', [JobApiController::class, 'publicShow']);

// Protected Job Routes (API Controller)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobs-api', [JobApiController::class, 'index']); // Ganti URL agar tidak bentrok dengan resource jobs
    Route::get('/jobs-api/{job}', [JobApiController::class, 'show']);
    Route::post('/jobs-api', [JobApiController::class, 'store']);
    Route::put('/jobs-api/{job}', [JobApiController::class, 'update']);
    Route::delete('/jobs-api/{job}', [JobApiController::class, 'destroy']);
});


// --- ADMIN ROUTES ---
Route::group([
    'middleware' => 'isAdmin',
    'prefix' => 'admin'
], function () {
    Route::get('/', [JobController::class,'admin']);
    Route::get('/jobs', [JobController::class,'adminJobs']);
});

// --- USER PROFILE ---
Route::group([
    'middleware' => 'auth',
    'controller' => AuthController::class,
], function () {
    // Route::get('/about', 'about')->name('about'); // Sudah ada di baris 38
    Route::get('/profile',  'profile')->name('profile');
});


// ============================================
// JOB VACANCY ROUTES
// ============================================

// Custom Routes (HARUS DI ATAS RESOURCE)
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/jobs/template', [JobVacancyController::class, 'downloadTemplate'])->name('jobs.template');
    Route::post('/jobs/import', [JobVacancyController::class,'import'])->name('jobs.import');
});

// Resource: Job Seeker (Read Only)
Route::resource('jobs', JobVacancyController::class)
    ->parameters(['jobs' => 'jobVacancy'])
    ->middleware(['auth'])
    ->only(['index','show']);

// Resource: Admin (Write Only)
Route::resource('jobs', JobVacancyController::class)
    ->parameters(['jobs' => 'jobVacancy'])
    ->middleware(['auth', 'isAdmin'])
    ->except(['index','show']); // Create, Store, Edit, Update, Destroy


// ============================================
// APPLICATION ROUTES
// ============================================

// Apply for job
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');


// PERBAIKAN UTAMA DI SINI: Ganti nama route agar tidak bentrok dengan resource

//Lama: route('applications.index', $job->id)
//Baru: route('jobs.applicants', $job->id)

// BERPOTENSI ROUTE error karena sebelumnya ada route dengan nama 'jobs.index'
Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
    ->name('jobs.applicants') // <--- GANTI JADI INI
    ->middleware(['auth', 'isAdmin']);

// Export applications
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/applications/export', [ApplicationController::class,'export'])->name('applications.export');
    Route::get('/applications/export/{job}', [ApplicationController::class, 'exportByJob'])->name('applications.export.job');
});

// Resource: Admin (Write Only)
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

// Resource: User/General (Read Only)
// Ini yang akan men-generate nama 'applications.index' yang sah
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

Route::middleware(['auth'])->group(function () {
    Route::post('/applications/{id}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
});


// ============================================
// NOTIFICATION ROUTES
// ============================================

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
});


### Langkah Selanjutnya

// Setelah Anda copy-paste kode di atas ke routes/web.php, jalankan perintah berikut di terminal container Anda:

//bash
//php artisan route:clear
//php artisan route:cache
