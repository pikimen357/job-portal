<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

Route::get('/status', fn()=> ['status' => 'API is running']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/me', fn(Request $r) => $r->user());
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class,
'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class,
'showRegisterForm'])->name('register');

Route::post('/register', [AuthController::class,
'register']);

//Route::post('/logout', [AuthController::class,
//'logout'])->name('logout');

Route::get('/about', [AuthController::class, 'about'])
    ->name('about');

Route::get('/hello', function () {
    return "Halo, ini halaman percobaan route!";
})->name('hello');


Route::get('/jobs', [JobController::class, 'index']);


// yang hanya bisa diakses oleh admin
Route::group([
    'middleware' => 'isAdmin',
    'prefix' => 'admin'
], function () {

    Route::get('/',
        [JobController::class,'admin']);

    Route::get('/jobs',
        [JobController::class,'adminJobs']);

});

//yang hanya bisa diakses oleh user login
Route::group([
    'middleware' => 'auth',
    'controller' => AuthController::class,
    ], function () {

        Route::get('/about', 'about')
            ->name('about');

        Route::get('/profile',  'profile')
            ->name('profile');
    });

// ============================================
// PENTING: Route spesifik harus di ATAS route resource!
// ============================================

// Download template - HARUS DI ATAS route resource jobs
Route::get('/jobs/template',
    [JobVacancyController::class, 'downloadTemplate'])
    ->name('jobs.template')
    ->middleware(['auth', 'isAdmin']);

// Import jobs - HARUS DI ATAS route resource jobs
Route::post('/jobs/import',
    [JobVacancyController::class,'import'])
    ->name('jobs.import')
    ->middleware(['auth', 'isAdmin']);

// Export applications - route spesifik
Route::get('/applications/export',
    [ApplicationController::class,'export'])
    ->name('applications.export')
    ->middleware(['auth', 'isAdmin']);

Route::get('/applications/export/{job}',
    [ApplicationController::class, 'exportByJob'])
    ->name('applications.export.job')
    ->middleware(['auth', 'isAdmin']);

// ============================================
// Route resource di BAWAH
// ============================================

// for job_seeker
Route::resource('jobs', JobVacancyController::class)
    ->parameters(['jobs' => 'jobVacancy'])
    ->middleware(['auth'])
    ->only(['index','show']);

// for admin
Route::resource('jobs', JobVacancyController::class)
    ->parameters(['jobs' => 'jobVacancy'])
    ->middleware(['auth', 'isAdmin'])
    ->except(['index','show']);

// Apply for job
Route::post('/jobs/{job}/apply',
    [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');

// View applicants for specific job
Route::get('/jobs/{job}/applicants',
    [ApplicationController::class, 'index'])
    ->name('applications.index')
    ->middleware(['auth', 'isAdmin']);

// Application resource routes
Route::resource('applications',ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('applications',ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

Route::middleware(['auth'])->group(function () {

    Route::post('/applications/{id}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])
        ->name('notifications.destroyAll');

    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
        ->name('notifications.unreadCount');
});
