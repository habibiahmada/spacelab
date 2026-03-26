<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Student\ClassroomController as StudentClassroomController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\RoomController as StudentRoomController;
use App\Http\Controllers\Student\ScheduleController as StudentScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Siswa'])
    ->prefix('student')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('index');
        Route::get('/schedules', [StudentScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/rooms', [StudentRoomController::class, 'index'])->name('rooms.index');
        Route::get('/classes', [StudentClassroomController::class, 'index'])->name('classroom.index');
        Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile.index');

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });
