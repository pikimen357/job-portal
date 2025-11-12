<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('/logout', [AuthController::class,
'logout'])->name('logout');

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


Route::post('/jobs/{job}/apply',
    [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');

Route::get('/jobs/{job}/applicants',
    [ApplicationController::class, 'index'])
    ->name('applications.index')
    ->middleware('isAdmin');

Route::resource('applications',ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('applications',ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

Route::get('/applications/export',
    [ApplicationController::class,'export'])
    ->name('applications.export')
    ->middleware('isAdmin');

Route::post('/jobs/import',
    [JobVacancyController::class,'import'])
    ->name('jobs.import')
    ->middleware('isAdmin');
