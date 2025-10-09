<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PagesController::class, 'index'])->name('welcome');

/*
|--------------------------------------------------------------------------
| Redirect After Login Based on Role
|--------------------------------------------------------------------------
*/

Route::get('/redirect', function () {
    $role = Auth::user()->role->lower_name;


    return match ($role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'guru'     => redirect()->route('guru.dashboard'),
        'siswa'    => redirect()->route('siswa.dashboard'),
        'staff'    => redirect()->route('staff.dashboard'),
        'operator' => redirect()->route('operator.dashboard'),
        default    => abort(403, 'Unauthorized role'),
    };
})->middleware('auth')->name('redirect');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Role-Based Dashboards
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/teachers', [AdminController::class, 'getTeacher'])->name('admin.teachers.index');
});

Route::middleware(['auth', 'role:Guru'])->group(function () {
    Route::get('/teacher/dashboard',fn () => view('teacher.dashboard'))->name('guru.dashboard');
});

Route::middleware(['auth', 'role:Siswa'])->group(function () {
    Route::get('/student/dashboard',fn () => view('student.dashboard'))->name('siswa.dashboard');
});

Route::middleware(['auth', 'role:Staff'])->group(function () {
    Route::get('/staff/dashboard',fn () => view('staff.dashboard'))->name('staff.dashboard');
});

Route::middleware(['auth', 'role:Operator'])->group(function () {
    Route::get('/operator/dashboard',fn () => view('operator.dashboard'))->name('operator.dashboard');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';