<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseTemplateController; // 改為引用新的控制器
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CourseController;

Route::middleware(['auth', 'can:access-admin-panel'])->prefix('admin')->name('admin.')->group(function () {

    // 2. 建立根路由，自動導向日曆
    Route::get('/', function () {
        return redirect()->route('admin.calendar.index');
    })->name('dashboard');

    // 3. 建立日曆頁面的路由
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // 新增這一行，專門給日曆抓取課程資料
    Route::get('/get-courses', [CalendarController::class, 'getEvents'])->name('calendar.getEvents');



    // 這一行程式碼，就等於自動幫我們建立了所有管理課程模板所需要的網址
    Route::resource('course-templates', CourseTemplateController::class);
    Route::resource('schools', SchoolController::class); 
    Route::resource('users', UserController::class);

    Route::resource('users', UserController::class);
    Route::resource('courses', CourseController::class);

    });