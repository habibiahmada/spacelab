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
        RoomController as StudentRoomController
    };

    use App\Http\Controllers\Teacher\{
        DashboardController as TeacherDashboardController,
        ScheduleController as TeacherScheduleController,
        ClassroomController as TeacherClassroomController,
        MajorHeadController as TeacherMajorHeadController,
        ProgramCoordinatorController as TeacherProgramCoordinatorController,
        ProfileController as TeacherProfileController,
    };

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

    Route::get('/', [PagesController::class, 'index'])->name('welcome');

    /*
    |--------------------------------------------------------------------------
    | Redirect After Login Based on Role
    |--------------------------------------------------------------------------
    */

    Route::get('/redirect', function () {
        $role = Auth::user()->role->lower_name;
        return match ($role) {
            'admin'    => redirect()->route('admin.index'),
            'guru'     => redirect()->route('guru.index'),
            'siswa'    => redirect()->route('siswa.index'),
            'staff'    => redirect()->route('staff.index'),
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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('index');
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

        Route::get('/class', [ TeacherClassroomController::class, 'index'])->name('classroom.index');

        Route::get('/major/major-head', [TeacherMajorHeadController::class, 'Index' ])->name('major.majorhead.index');

        Route::get('/major/program-coordinator', [TeacherProgramCoordinatorController::class, 'Index' ])->name('major.majorprogram.index');

        Route::get('/profile', [ TeacherProfileController::class, 'index' ])->name('profile.index');
    });

    Route::middleware(['auth', 'role:Siswa'])->prefix('student')->name('siswa.')->group(function () {
        Route::get('/dashboard',[StudentDashboardController::class, 'index'])->name('index');

        Route::get('/schedules', [ StudentScheduleController::class, 'index'])->name('schedules.index');

        Route::get('/rooms', [ StudentRoomController::class, 'index'])->name('rooms.index');

        Route::get('/classes', [ StudentClassroomController::class, 'index'])->name('classroom.index');

        Route::get('/profile', [ StudentProfileController::class, 'index' ])->name('profile.index');
    });

    Route::middleware(['auth', 'role:Staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('index');

        Route::get('/terms', [StaffTermController::class, 'index'])->name('terms.index');

        Route::get('/majors', [StaffMajorController::class, 'index'])->name('majors.index');

        Route::get('/classes', [StaffClassController::class, 'index'])->name('classes.index');

        Route::get('/teachers', [StaffTeacherController::class, 'index'])->name('teachers.index');

        Route::get('/students', [StaffStudentController::class, 'index'])->name('students.index');

        Route::get('/rooms', [StaffRoomController::class, 'index'])->name('rooms.index');

        Route::get('/rooms/history', [StaffRoomHistoryController::class, 'index'])->name('rooms.history');


        Route::get('/schedules', [StaffScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/major/{majorId}', [StaffScheduleController::class, 'getMajorSchedules'])->name('schedules.major');


    });

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/auth.php';
