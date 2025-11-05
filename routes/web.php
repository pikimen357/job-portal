<?php

use App\Http\Controllers\JobController;
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

Route::resource('jobs', \App\Http\Controllers\JobVacancyController::class)
        ->middleware('isAdmin');

