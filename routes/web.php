<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'loginView'])->name('loginView');

// auth
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth.check'])->group(function () {
    // admin
    Route::prefix('admin')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        // users
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'view'])->name('users');
            Route::post('/create', [UserController::class, 'create'])->name('createUser');
        });
        // documents
        Route::prefix('documents')->group(function () {
            Route::get('/', [DocumentController::class, 'view'])->name('documents');
            Route::post('/create', [DocumentController::class, 'create'])->name('createDocument');
        });
        // employees
        Route::prefix('employees')->group(function () {
            Route::get('/', [EmployeeController::class, 'view'])->name('employees');
            Route::get('/all', [EmployeeController::class, 'all'])->name('employeesAll');
            Route::get('/view', [EmployeeController::class, 'info'])->name('viewEmployee');
            Route::post('/create', [EmployeeController::class, 'create'])->name('createEmployee');
            Route::post('/update', [EmployeeController::class, 'update'])->name('updateEmployee');
            // shift
            Route::prefix('shift')->group(function () {
                Route::post('/', [EmployeeController::class, 'shift'])->name('shiftEmployee');
                Route::get('/info', [ShiftController::class, 'weekShifts'])->name('calculateEmployeeShift');
                Route::post('/create', [ShiftController::class, 'register'])->name('createShiftEmployee');
            });
            // Route::post('/delete', [EmployeeController::class, 'delete'])->name('deleteEmployee');
        });
        // services
        Route::prefix('services')->group(function () {
            Route::get('/', [ServiceController::class, 'view'])->name('services');
            Route::get('/all', [ServiceController::class, 'all'])->name('servicesAll');
            Route::post('/create', [ServiceController::class, 'create'])->name('createService');
            Route::get('/{id}', [ServiceController::class, 'viewOnce'])->name('viewService');
        });
        // projects
        Route::prefix('projects')->group(function () {
            Route::post('/delete', [ProjectController::class, 'delete'])->name('deleteProject');
        });
        // cash
        Route::prefix('cash')->group(function () {
            Route::get('/', [CashController::class, 'view'])->name('cash');
            Route::post('/update', [CashController::class, 'update'])->name('updateCash');
            Route::prefix('in-out')->group(function () {
                Route::post('/create', [CashController::class, 'createInOut'])->name('createInOut');
            });
        });
        // settings
        Route::prefix('settings')->group(function () {
            Route::get('/', [UserController::class, 'settingsView'])->name('settingsView');
        });
    });
});