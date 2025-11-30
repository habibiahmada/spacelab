    <?php

    use App\Http\Controllers\PagesController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;

    use App\Http\Controllers\Admin\{
        DashboardController as AdminDashboardController,
        TeacherController as AdminTeacherController,
        StudentController as AdminStudentController,
        ClassController as AdminClassController,
        MajorController as AdminMajorController,
        RoomController as AdminRoomController,
        ScheduleController as AdminScheduleController
    };

    use App\Http\Controllers\Student\{
        ClassroomController as StudentClassroomController,
        DashboardController as StudentDashboardController,
        ScheduleController as StudentScheduleController,
        ProfileController as StudentProfileController,
    };

    use App\Http\Controllers\Teacher\{
        DashboardController as TeacherDashboardController,
        ScheduleController as TeacherScheduleController,
    };

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
            'guru'     => redirect()->route('guru.index'),
            'siswa'    => redirect()->route('siswa.index'),
            'staff'    => redirect()->route('staff.dashboard'),
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

    Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/classes', [AdminClassController::class, 'index'])->name('classes.index');
        Route::get('/majors', [AdminMajorController::class, 'index'])->name('majors.index');
        Route::get('/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
        Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
    });

    Route::middleware(['auth', 'role:Guru'])->prefix('teacher')->name('guru.')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('index');

        Route::get('/schedules', [ TeacherScheduleController::class, 'index'])->name('schedules.index');
    });

    Route::middleware(['auth', 'role:Siswa'])->prefix('student')->name('siswa.')->group(function () {
        Route::get('/dashboard',[StudentDashboardController::class, 'index'])->name('index');

        Route::get('/schedules', [ StudentScheduleController::class, 'index'])->name('schedules.index');

        Route::get('/class', [ StudentClassroomController::class, 'index'])->name('classroom.index');

        Route::get('/profile', [ StudentProfileController::class, 'index' ])->name('profile.index');
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
