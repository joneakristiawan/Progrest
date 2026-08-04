<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollabController;
use App\Http\Controllers\CollabSubmissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskSubmissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){
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


    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('reset.password.submit'); 
}); 

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/users/search', [UserController::class, 'search'])
        ->name('users.search');

    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');

    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->name('projects.update');

    Route::delete('/projects/{project}', [ProjectController::class, 'delete'])
        ->name('projects.delete');

    Route::prefix('tasks/{task}')->name('tasks.')->group(function () {
        Route::post('/submit', [TaskSubmissionController::class, 'submit'])->name('submit');
    });

    Route::post(
        '/submissions/{submission}/approve',
        [TaskSubmissionController::class, 'approve']
    );

    Route::post(
        '/submissions/{submission}/reject',
        [TaskSubmissionController::class, 'reject']
    );

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    
    Route::get('/projects/{id}', [ProjectTaskController::class, 'index'])->name('projects.tasks');

    Route::delete(
        '/collab/{project}/leave',
        [CollabController::class,'leave']
        )->name('collab.leave');

    Route::post('/projects/{project}/tasks', [ProjectTaskController::class, 'store'])
        ->name('projects.tasks.store'); 

    Route::delete('/tasks/{task}', [TaskController::class, 'delete'])
        ->name('tasks.delete');

    Route::put('/tasks/{task}', [ProjectTaskController::class, 'update'])
        ->name('tasks.update');

    Route::post(
        '/submissions/{submission}/approve',
        [TaskSubmissionController::class, 'approve']
    );

    Route::post(
        '/submissions/{submission}/reject',
        [TaskSubmissionController::class, 'reject']
    );

    Route::post('/notifications/read', [NotificationController::class, 'markAllAsRead'])
        ->middleware('auth')
        ->name('notifications.read');

    Route::get('/collab', [CollabController::class, 'index'])->name('collab.index');

    Route::get('/collab/active', [CollabController::class, 'active'])
        ->name('collab.active');

    Route::post(
        '/collab/tasks/{task}/join',
        [CollabController::class, 'join']
    )->name('collab.join');

    Route::delete(
        '/collab/tasks/{task}/leave',
        [CollabController::class, 'leave']
    )->name('collab.leave'); 

    Route::get(
        '/projects/{project}/members/search',
        [UserController::class, 'searchProjectMembers']
    )->name('projects.members.search');
});

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');