<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\{
    DashboardController as TeacherDashboardController,
    ScheduleController as TeacherScheduleController,
    ClassroomController as TeacherClassroomController,
    MajorHeadController as TeacherMajorHeadController,
    ProgramCoordinatorController as TeacherProgramCoordinatorController,
    ProfileController as TeacherProfileController,
};

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
    });
