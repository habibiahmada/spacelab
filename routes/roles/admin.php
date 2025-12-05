<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    TeacherController as AdminTeacherController,
    StudentController as AdminStudentController,
    ClassController as AdminClassController,
    MajorController as AdminMajorController,
    RoomController as AdminRoomController,
    ScheduleController as AdminScheduleController
};

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('index');
        Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/classes', [AdminClassController::class, 'index'])->name('classes.index');
        Route::get('/majors', [AdminMajorController::class, 'index'])->name('majors.index');
        Route::get('/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
        Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
    });
