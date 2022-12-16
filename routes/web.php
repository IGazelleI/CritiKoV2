<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('guest')->group(function ()
{
    Route::controller(App\Http\Controllers\UserController::class)->group(function ()
    {
        Route::get('/', 'index')->name('index');
        Route::post('/user', 'store')->name('register');
        Route::post('/users/auth', 'auth')->name('auth');
        Route::get('/forgot-password', 'forgotPassword')->name('password.request');
        Route::post('/forgot-password', 'process')->name('password.email');
        Route::get('/reset-password/{token}', 'reset')->name('password.reset');
        Route::post('/reset-password', 'updatePassword')->name('password.update');
    });
});
Route::middleware('auth')->group(function ()
{
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

    /* Route::controller(App\Http\Controllers\AdminController::class)->group(function ()
    {
        Route::get('/profile', 'show')->name('student.profile');
        Route::put('/update', 'update')->name('student.update');
        Route::get('/evaluate', 'evaluate')->name('student.evaluate');
        Route::post('/changePic/{student}', 'changeProfilePicture')->name('student.changePic');
        Route::post('/changePeriod', 'changePeriod')->name('student.changePeriod');
        Route::get('/enrollment', 'enrollment')->name('student.enrollment');
        Route::post('/enroll', 'enroll')->name('student.submitEnroll');
    }); */

    Route::middleware('user-access:admin')->group(function ()
    {
        Route::get('/a/report', [AdminController::class, 'report'])->name('admin.report');
        Route::post('/a/prevLimit', [AdminController::class, 'changePrevLimit'])->name('admin.changePrevLimit');
        Route::controller(App\Http\Controllers\UserController::class)->group(function ()
        {
            Route::get('/asd', 's')->name('s');
            Route::get('/u/m/{type?}', 'manage')->name('user.manage');
            Route::post('/u/create', 'create')->name('user.add');
            Route::get('/assign/{department}', 'assignDean')->name('user.assignDean');
            Route::post('/assignDeanProcess', 'assignDeanProcess')->name('user.assignDeanProcess');
            Route::get('/assign/associate/{department}', 'assignAssociate')->name('user.assignAssociate');
            Route::post('/assignAssociateProcess', 'assignAssociateProcess')->name('user.assignAssociateProcess');
            Route::get('/assign/chairman/{department}', 'assignChairman')->name('user.assignChairman');
            Route::post('/assignChairmanProcess', 'assignChairmanProcess')->name('user.assignChairmanProcess');
        });

        Route::controller(App\Http\Controllers\PeriodController::class)->group(function ()
        {
            Route::post('/period', 'store')->name('period.store');
            Route::put('/period', 'update')->name('period.update');
            Route::delete('/period', 'destroy')->name('period.delete');
        });

        Route::controller(App\Http\Controllers\DepartmentController::class)->group(function ()
        {
            Route::post('/department', 'store')->name('department.store');
            Route::put('/department', 'update')->name('department.update');
            Route::delete('/deparmtment', 'destroy')->name('department.delete');
        });

        Route::controller(App\Http\Controllers\CourseController::class)->group(function ()
        {
            Route::get('/c/{department?}', 'index')->name('course.manage');
            Route::post('/course', 'store')->name('course.store');
            Route::put('/course', 'update')->name('course.update');
            Route::delete('/course', 'destroy')->name('course.delete');
        });

        Route::controller(App\Http\Controllers\BlockController::class)->group(function ()
        {
            Route::get('/b/{period?}', 'index')->name('block.manage');
            Route::get('/b/p/{period}/{course}/{year_level?}', 'show')->name('block.show');
            Route::post('/block', 'store')->name('block.store');
            Route::put('/block', 'update')->name('block.update');
            Route::delete('/block', 'destroy')->name('block.delete');
        });

        Route::controller(App\Http\Controllers\SubjectController::class)->group(function ()
        {
            Route::get('s/{course?}', 'index')->name('subject.manage');
            Route::post('/subject', 'store')->name('subject.store');
            Route::put('/subject', 'update')->name('subject.update');
            Route::delete('/subject ', 'destroy')->name('subject.delete');
        });

        Route::controller(App\Http\Controllers\KlaseController::class)->group(function ()
        {
            Route::get('/k/{block}', 'index')->name('klase.manage');
            Route::get('/k', 'assignInstructor')->name('klase.assignInstructor');
            Route::post('/k/{klase}', 'assignInstructorProcess')->name('klase.assignInstructorProcess');
            Route::get('k/s/{klase}', 'classStudent')->name('klase.students');
        });
    });

    Route::middleware('user-access:sast')->group(function ()
    {
        Route::controller(App\Http\Controllers\SASTController::class)->group(function ()
        {
            Route::get('/mss/profile', 'show')->name('sast.profile');
            Route::post('/changePicss/{sast}', 'changeProfilePicture')->name('sast.changePic');
            Route::put('/sast', 'update')->name('sast.update');
            Route::post('/changePeriodsast', 'changePeriod')->name('sast.changePeriod');
            Route::put('/setEvaluationDate', 'setEvaluationDate')->name('sast.setEvaluationDate');
        });
        Route::controller(App\Http\Controllers\QCategoryController::class)->group(function ()
        {
            Route::post('/qCategory', 'store')->name('qCat.store');
            Route::put('/qCategory', 'update')->name('qCat.update');
            Route::delete('/qCategory', 'destroy')->name('qCat.delete');
        });
        Route::controller(App\Http\Controllers\QuestionController::class)->group(function ()
        {
            Route::get('/q/{type?}', 'index')->name('question.manage');
            Route::post('/question', 'store')->name('question.store');
            Route::put('/question', 'update')->name('question.update');
            Route::delete('/question', 'destroy')->name('question.delete');
        });
    });
    
    Route::middleware('user-access:faculty')->group(function ()
    {
        Route::controller(App\Http\Controllers\FacultyController::class)->group(function ()
        {
            //dean routes
            Route::middleware('user-access:dean')->group(function ()
            {
                Route::get('/enrollments', 'enrollment')->name('dean.enrollment');
                Route::post('/enrollment/{enroll}', 'processEnrollment')->name('dean.processEnrollment');
                Route::get('/d/report', 'report')->name('dean.report');
            });

            Route::get('/mf/profile', 'show')->name('faculty.profile');
            Route::put('/faculty', 'update')->name('faculty.update');
            Route::post('/changePicf/{faculty}', 'changeProfilePicture')->name('faculty.changePic');
            Route::post('/changePeriodf', 'changePeriod')->name('faculty.changePeriod');
            Route::post('/changeSelectedf', 'changeSelected')->name('faculty.changeSelected');
            Route::get('/evaluatef', 'evaluate')->name('faculty.evaluate');
            Route::post('evaluate/processf', 'evaluateProcess')->name('faculty.evaluateProcess');
            Route::post('/f/prevLimit', 'changePrevLimit')->name('faculty.changePrevLimit');
        });
    });

    Route::middleware('user-access:student')->group(function ()
    {
        Route::controller(App\Http\Controllers\StudentController::class)->group(function ()
        {
            Route::get('/ms/profile', 'show')->name('student.profile');
            Route::put('/student', 'update')->name('student.update');
            Route::get('/evaluates', 'evaluate')->name('student.evaluate');
            Route::post('/evaluate/processs', 'evaluateProcess')->name('student.evaluateProcess');
            Route::post('/changePics/{student}', 'changeProfilePicture')->name('student.changePic');
            Route::post('/changePeriods', 'changePeriod')->name('student.changePeriod');
            Route::post('/changeSelecteds', 'changeSelected')->name('student.changeSelected');
            Route::post('/changeEnrollType', 'changeEnrollType')->name('student.changeEnrollmentType');
            Route::post('/changeCourse', 'changeCourse')->name('student.changeCourse');
            Route::post('/changeYear', 'changeYear')->name('student.changeYear');
            Route::get('/enrollment', 'enrollment')->name('student.enrollment');
            Route::post('/enroll', 'enroll')->name('student.submitEnroll');
        });
    });
});
