    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\StudentAuthController;
    use App\Http\Middleware\AdminAuth;
    use App\Http\Middleware\StudentAuth;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\FeesRecordController;
    use App\Http\Controllers\AttendanceController;
    use App\Http\Controllers\BatchController;
    use App\Http\Controllers\EnquiryController;
    use App\Http\Controllers\FeesChartController;
    use App\Http\Controllers\StudentProfileController;
    use App\Http\Controllers\NotificationController;
    use App\Http\Controllers\EventController;
    use App\Http\Controllers\TimetableController;   
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\BroadcastController;
    use App\Http\Controllers\SettingController;


    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return view('index');
    })->name('home');

    Route::get('/aboutpage', function () {
        return view('about-us');
    })->name('about');

    Route::get('/course', function () {
        return view('Courses');
    })->name('course');

    Route::get('/achivements', function () {
        return view('Achivements');
    })->name('achivement');

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

    /*
    |--------------------------------------------------------------------------
    | Authentication for students  Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/student/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');

    // Route::get('/student/register', [StudentAuthController::class, 'showRegisterForm'])->name('student.register');
    // Route::post('/student/register', [StudentAuthController::class, 'register'])->name('student.register.submit');

    Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');


    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['adminAuth'])->group(function () {

        //system setting
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        // Dashboard & Logout
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Change Password
        Route::get('/admin/change-password', [AuthController::class, 'showChangePasswordForm'])->name('admin.change.password.form');
        Route::post('/admin/change-password', [AuthController::class, 'changePassword'])->name('admin.change.password');


        // Student Management
        Route::resource('students', StudentController::class);
        Route::delete('/students/{student}/attachments/{attachment}', [StudentController::class, 'deleteAttachment'])->name('students.attachments.destroy');

        // Enquiries
        Route::resource('enquiries', EnquiryController::class);

        // Fees
        Route::resource('fees_chart', FeesChartController::class);
        Route::resource('fees-records', FeesRecordController::class);


         Route::get('/installment/{id}/download-receipt', [FeesRecordController::class, 'downloadReceipt'])
        ->name('admin.installments.downloadReceipt'); 


        // Attendance
        Route::resource('attendance', AttendanceController::class);
        Route::get('/attendance/edit', [AttendanceController::class, 'editByDate'])->name('attendance.editByDate');
        Route::post('/attendance/update', [AttendanceController::class, 'updateByDate'])->name('attendance.updateByDate');
        Route::get('/attendance/student-report', [AttendanceController::class, 'studentReport'])->name('attendance.studentReport');

        // Batches
        Route::resource('batches', BatchController::class);

        Route::resource('notifications', NotificationController::class);   


        Route::resource('events', EventController::class);
        Route::resource('timetables', TimetableController::class);

        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');


        // Route to show the broadcast message form
    Route::get('/broadcast', [BroadcastController::class, 'create'])->name('broadcast.create');

    // Route to handle sending the broadcast message
    Route::post('/broadcast', [BroadcastController::class, 'store'])->name('broadcast.store');

    });


    Route::middleware(['studentAuth'])->group(function () {

    // Dashboard & Logout
        Route::get('/student/dashboard', [DashboardController::class, 'showStudentIndex'])->name('student.dashboard');
        //Route::get('/student/logout', [AuthController::class, 'logout'])->name('admin.logout');
        //Route::get('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
            // NOTE: The duplicate GET route for 'student.logout' has been removed from here.


        // Change Password
        Route::get('/student/change-password', [StudentAuthController::class, 'showChangePasswordForm'])->name('student.change.password.form');
        Route::post('/student/change-password', [StudentAuthController::class, 'changePassword'])->name('student.change.password');


        Route::get('/edit-profile', [StudentProfileController::class, 'editStudentProfile'])->name('student.editProfile');
        Route::post('/edit-profile', [StudentProfileController::class, 'updateStudentProfile'])->name('student.profile.update');
        Route::get('/fees-profile/{id}', [StudentProfileController::class, 'showFeesProfile'])->name('student.fees.details');
        Route::get('/attendance/summary/{id}', [StudentProfileController::class, 'attendSummary'])->name('student.attendance.summary');

        
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    //Route::resource('timetables', TimetableController::class);
    //Route::resource('events', EventController::class);
    // Timetables
    Route::get('/student/timetables', [TimetableController::class, 'showStudentTimetable'])->name('student.timetables');

    // Events
    Route::get('/student/events', [EventController::class, 'showStudentEvents'])->name('student.events');


     // ✅ ADD THESE TWO LINES
    Route::get('/student/messages', [\App\Http\Controllers\StudentMessageController::class, 'index'])->name('student.messages.index');
    Route::post('/student/messages', [\App\Http\Controllers\StudentMessageController::class, 'store'])->name('student.messages.store');
 Route::get('/installments/{id}/download-receipt', [FeesRecordController::class, 'downloadReceipt'])
        ->name('student.installments.downloadReceipt'); 
    });