<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\{
    DashboardController as StaffDashboardController,
    ScheduleController as StaffScheduleController,
    TermController as StaffTermController,
    MajorController as StaffMajorController,
    ClassroomController as StaffClassController,
    TeacherController as StaffTeacherController,
    StudentController as StaffStudentController,
    RoomController as StaffRoomController,
    RoomHistoryController as StaffRoomHistoryController
};

Route::middleware(['auth', 'role:Staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('index');

        // Terms
        Route::get('/terms', [StaffTermController::class, 'index'])->name('terms.index');
        Route::post('/terms', [StaffTermController::class, 'store'])->name('terms.store');
        Route::get('/terms/{term}/edit', [StaffTermController::class, 'edit'])->name('terms.edit');
        Route::put('/terms/{term}', [StaffTermController::class, 'update'])->name('terms.update');
        Route::delete('/terms/{term}', [StaffTermController::class, 'destroy'])->name('terms.destroy');

        // Blocks
        Route::post('/blocks', [StaffTermController::class, 'storeBlock'])->name('blocks.store');
        Route::get('/blocks/{block}/edit', [StaffTermController::class, 'editBlock'])->name('blocks.edit');
        Route::put('/blocks/{block}', [StaffTermController::class, 'updateBlock'])->name('blocks.update');
        Route::delete('/blocks/{block}', [StaffTermController::class, 'destroyBlock'])->name('blocks.destroy');

        Route::get('/majors', [StaffMajorController::class, 'index'])->name('majors.index');
        Route::get('/majors/create', [StaffMajorController::class, 'create'])->name('majors.create');
        Route::post('/majors', [StaffMajorController::class, 'store'])->name('majors.store');
        Route::get('/majors/{major}/edit', [StaffMajorController::class, 'edit'])->name('majors.edit');
        Route::put('/majors/{major}', [StaffMajorController::class, 'update'])->name('majors.update');
        Route::delete('/majors/{major}', [StaffMajorController::class, 'destroy'])->name('majors.destroy');

        Route::get('/majors/{major}', [StaffMajorController::class, 'show'])->name('majors.show');
        Route::post('/majors/{major}/company-relation', [StaffMajorController::class, 'storeCompanyRelation'])->name('majors.company-relation.store');
        Route::put('/majors/{major}/company-relation/{companyRelation}', [StaffMajorController::class, 'updateCompanyRelation'])->name('majors.company-relation.update');
        Route::delete('/majors/{major}/company-relation/{companyRelation}', [StaffMajorController::class, 'destroyCompanyRelation'])->name('majors.company-relation.destroy');
        Route::put('/majors/{major}/role-assignment', [StaffMajorController::class, 'updateRoleAssignment'])->name('majors.role-assignment.update');

        Route::get('/classrooms', [StaffClassController::class, 'index'])->name('classrooms.index');
        Route::get('/classroomsjson/{id}', [StaffClassController::class, 'showJson'])->name('classrooms.json');
        Route::post('/classrooms', [StaffClassController::class, 'store'])->name('classrooms.store');
        Route::get('/classrooms/{id}', [StaffClassController::class, 'show'])->name('classrooms.show');
        Route::put('/classrooms/{id}', [StaffClassController::class, 'update'])->name('classrooms.update');
        Route::delete('/classrooms/{id}', [StaffClassController::class, 'destroy'])->name('classrooms.destroy');
        Route::post('/classrooms/{id}/guardian', [StaffClassController::class, 'updateGuardian'])->name('classrooms.guardian.update');
        Route::post('/classrooms/{id}/students', [StaffClassController::class, 'storeStudent'])->name('classrooms.students.store');
        Route::delete('/classrooms/{id}/students/{studentId}', [StaffClassController::class, 'destroyStudent'])->name('classrooms.students.destroy');

        Route::get('/teachers', [StaffTeacherController::class, 'index'])->name('teachers.index');
        Route::get('/students', [StaffStudentController::class, 'index'])->name('students.index');
        Route::get('/students/fetch', [StaffStudentController::class, 'fetchStudents'])->name('students.fetch');
        Route::get('/students/{id}', [StaffStudentController::class, 'show'])->name('students.show');
        Route::post('/students', [StaffStudentController::class, 'store'])->name('students.store');
        Route::put('/students/{id}', [StaffStudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{id}', [StaffStudentController::class, 'destroy'])->name('students.destroy');
        Route::post('/students/import', [StaffStudentController::class, 'import'])->name('students.import');
        Route::get('/students/template', [StaffStudentController::class, 'downloadTemplate'])->name('students.template');
        Route::get('/rooms', [StaffRoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/history', [StaffRoomHistoryController::class, 'index'])->name('rooms.history');

        Route::get('/schedules', [StaffScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/major/{majorId}', [StaffScheduleController::class, 'getMajorSchedules'])->name('schedules.major');
    });
