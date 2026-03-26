<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SearchStudentController;
use App\Http\Controllers\SearchTeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('welcome');
Route::get('/attendance-qr', [PagesController::class, 'attendanceQr'])->name('attendance.qr');

Route::group([
    'prefix' => 'views',
    'as' => 'views.',
], function () {
    Route::get('/', [PagesController::class, 'views'])->name('index');
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('/search-student', [SearchStudentController::class, 'index'])->name('search-student');
    Route::get('/search-teacher', [SearchTeacherController::class, 'index'])->name('search-teacher');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Import route role
require __DIR__.'/roles/admin.php';
require __DIR__.'/roles/teacher.php';
require __DIR__.'/roles/student.php';
require __DIR__.'/roles/staff.php';

// Auth routes
require __DIR__.'/auth.php';
