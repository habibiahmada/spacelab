<?php

use App\Http\Controllers\Admin\AttendanceSessionController as TeacherAttendanceSessionController;
use App\Http\Controllers\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\ClassroomController as TeacherClassroomController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\MajorHeadController as TeacherMajorHeadController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\ProgramCoordinatorController as TeacherProgramCoordinatorController;
use App\Http\Controllers\Teacher\ScheduleController as TeacherScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Guru'])
    ->prefix('teacher')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('index');
        Route::get('/schedules', [TeacherScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/class', [TeacherClassroomController::class, 'index'])->name('classroom.index');
        Route::get('/major/major-head', [TeacherMajorHeadController::class, 'index'])->name('major.majorhead.index');
        Route::get('/major/program-coordinator', [TeacherProgramCoordinatorController::class, 'index'])->name('major.majorprogram.index');
        Route::get('/profile', [TeacherProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile', [TeacherProfileController::class, 'index'])->name('profile.index');

        // Attendance - Manage Sessions
        Route::get('/attendance/sessions', [TeacherAttendanceSessionController::class, 'index'])->name('attendance.sessions.index');
        Route::post('/attendance/sessions', [TeacherAttendanceSessionController::class, 'store'])->name('attendance.sessions.store');
        Route::delete('/attendance/sessions/{session}', [TeacherAttendanceSessionController::class, 'destroy'])->name('attendance.sessions.destroy');

        // Attendance - Mark Attendance
        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [TeacherAttendanceController::class, 'store'])->name('attendance.store');
    });
