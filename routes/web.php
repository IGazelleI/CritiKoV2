<?php

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

    Route::controller(App\Http\Controllers\AdminController::class)->group(function ()
    {
        Route::get('/profile', 'show')->name('student.profile');
        Route::put('/update', 'update')->name('student.update');
        Route::get('/evaluate', 'evaluate')->name('student.evaluate');
        Route::post('/changePic/{student}', 'changeProfilePicture')->name('student.changePic');
        Route::post('/changePeriod', 'changePeriod')->name('student.changePeriod');
        Route::get('/enrollment', 'enrollment')->name('student.enrollment');
        Route::post('/enroll', 'enroll')->name('student.submitEnroll');
    });

    Route::middleware('user-access: student')->group(function ()
    {
        Route::controller(App\Http\Controllers\StudentController::class)->group(function ()
        {
            Route::get('/profile', 'show')->name('student.profile');
            Route::put('/update', 'update')->name('student.update');
            Route::get('/evaluate', 'evaluate')->name('student.evaluate');
            Route::post('/changePic/{student}', 'changeProfilePicture')->name('student.changePic');
            Route::post('/changePeriod', 'changePeriod')->name('student.changePeriod');
            Route::get('/enrollment', 'enrollment')->name('student.enrollment');
            Route::post('/enroll', 'enroll')->name('student.submitEnroll');
        });
    });
    

    Route::middleware('user-access: admin')->group(function ()
    {
        Route::controller(App\Http\Controllers\UserController::class)->group(function ()
        {
            Route::get('/u/manage/{type}', 'manage')->name('user.manage');
            Route::post('/user/create', 'create')->name('user.add');
        });

        Route::controller(App\Http\Controllers\DepartmentController::class)->group(function ()
        {
            Route::post('/department', 'store')->name('department.store');
            Route::put('/department', 'update')->name('department.update');
            Route::delete('/deparmtment', 'destroy')->name('department.delete');
        });

        Route::controller(App\Http\Controllers\CourseController::class)->group(function ()
        {
            Route::get('/c/{department}', 'index')->name('course.manage');
            Route::post('/course', 'store')->name('course.store');
            Route::put('/course', 'update')->name('course.update');
            Route::delete('/course', 'destroy')->name('course.delete');
        });

        Route::controller(App\Http\Controllers\BlockController::class)->group(function ()
        {
            Route::get('/b/{course}', 'index')->name('block.manage');
            Route::post('/block', 'store')->name('block.store');
            Route::put('/block', 'update')->name('block.update');
            Route::delete('/block', 'destroy')->name('block.delete');
        });

        Route::controller(App\Http\Controllers\PeriodController::class)->group(function ()
        {
            Route::post('/period', 'store')->name('period.store');
            Route::put('/period', 'update')->name('period.update');
            Route::delete('/period', 'destroy')->name('period.delete');
        });

        Route::controller(App\Http\Controllers)->group(function ()
        {
            Route::
            Route::
            Route::
        });
    });
});