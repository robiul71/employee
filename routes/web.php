<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CompanyController
Route::resource('admin-employee', EmployeeController::class)->names('employee');
Route::get('admin-employee-status/{id}', [EmployeeController::class, 'status'])->name('employee.status');
Route::get('admin-employee-delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
Route::get('admin-employee-delete-all', [EmployeeController::class, 'delete_all'])->name('employee.delete_all');
Route::post('admin-employee-destroy-all', [EmployeeController::class, 'destroy_all'])->name('employee.destroy_all');
// AttendanceController
Route::resource('employee-attendance', AttendanceController::class)->names('attendance');
Route::get('employee-attendance-status/{id}', [AttendanceController::class, 'status'])->name('attendance.status');
Route::get('employee-attendance-delete/{id}', [AttendanceController::class, 'delete'])->name('attendance.delete');
Route::get('employee-attendance-delete-all', [AttendanceController::class, 'delete_all'])->name('attendance.delete_all');
Route::post('employee-attendance-destroy-all', [AttendanceController::class, 'destroy_all'])->name('attendance.destroy_all');
