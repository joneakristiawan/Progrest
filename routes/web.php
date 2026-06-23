<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollabController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('landing');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot', function () {
    return view('auth.forgot');
})->name('forgot');

Route::post('/forgot', [AuthController::class, 'sendOtp'])->name('forgot.send');

Route::get('/otp', function () {
    return view('auth.otp');
})->name('otp');

Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify'); 

Route::get('/reset-password', function () {
    return view('auth.reset');
})->name('reset.password');

// Route::post('/reset-password', function () {
//     return redirect()->route('login');
// })->name('reset.password.submit');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('reset.password.submit'); 

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');
});

Route::get('/projects/tasks', function () {
    $projects = [];

    $menu = [
        [
            'navigations' => [
                ['name' => 'Dashboard', 'path' => '/dashboard'],
                ['name' => 'Projects', 'path' => '/projects'],
                ['name' => 'Collab', 'path' => '/collab'],
                ['name' => 'Profiles', 'path' => '/profile'],
            ]
        ]
    ];

    return view('projects.tasks.index', compact('projects', 'menu'));
})->name('projects.tasks');

Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->middleware('auth');

Route::get('/collab', [CollabController::class, 'index']);

Route::get('/profile', [ProfileController::class, 'index']);