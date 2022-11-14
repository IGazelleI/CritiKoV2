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

Route::get('/login', [App\Http\Controllers\UserController::class, 'index'])->name('index');
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

Route::get('/home', function(){
    return view('student.index');
});
Route::middleware('auth')->group(function ()
{
    Route::controller(App\Http\Controllers\AdminController::class)->group(function ()
    {
        Route::get('/admin/home', 'index')->name('admin.home');
        Route::get('/profile', 'show')->name('student.profile');
        Route::put('/update', 'update')->name('student.update');
        Route::get('/evaluate', 'evaluate')->name('student.evaluate');
        Route::post('/changePic/{student}', 'changeProfilePicture')->name('student.changePic');
        Route::post('/changePeriod', 'changePeriod')->name('student.changePeriod');
        Route::get('/enrollment', 'enrollment')->name('student.enrollment');
        Route::post('/enroll', 'enroll')->name('student.submitEnroll');
    });

    Route::controller(App\Http\Controllers\StudentController::class)->group(function ()
    {
        Route::get('/home', 'index')->name('student.home');
        Route::get('/profile', 'show')->name('student.profile');
        Route::put('/update', 'update')->name('student.update');
        Route::get('/evaluate', 'evaluate')->name('student.evaluate');
        Route::post('/changePic/{student}', 'changeProfilePicture')->name('student.changePic');
        Route::post('/changePeriod', 'changePeriod')->name('student.changePeriod');
        Route::get('/enrollment', 'enrollment')->name('student.enrollment');
        Route::post('/enroll', 'enroll')->name('student.submitEnroll');
    });


    
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
});
