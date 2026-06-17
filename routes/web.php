<?php

use App\Http\Controllers\AuthController; 
use App\Http\Controllers\CollabController; 

use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ProjectController; 
use Illuminate\Support\Facades\Route; 

Route::get('/test-speed', function(){
    return 'Hello World'; 
}); 

Route::get('/', function() {
    return view('landing.index'); 
})->name('landing'); 

Route::get('/register', function() {
    return view('auth.register'); 
})->name('register'); 
Route::post('/register', [AuthController::class, 'register']); 

Route::get('/login', [AuthController::class, 'index'])
    ->name('login'); 
Route::post('/login', [AuthController::class, 'login']); 
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth'); 

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard'); 
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index'); 
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store'); 
}); 

Route::get('/projects/tasks', function(){
    $projects = [];
    $menu = [
        [
            'navigations' => [
                ['name' => 'Dashboard', 'path' => '/dashboard'], 
                ['name' => 'Projects', 'path' => '/projects'], 
                ['name' => 'Collab', 'path' => '/collab'], 
                ['name' => 'Profiles', 'path' => '/profile']
            ]
        ]
    ];
    return view('projects.tasks.index', compact('projects', 'menu'));
});
Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->middleware('auth'); 

Route::get('/collab', [CollabController::class, 'index']); 
Route::get('/profile', [ProfileController::class, 'index']);
