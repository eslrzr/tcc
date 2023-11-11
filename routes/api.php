<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function () {
    // users
    Route::prefix('users')->group(function () {
        Route::put('/{id}/status', [UserController::class, 'changeStatus'])->name('changeStatus');
    });
    // documents
    Route::prefix('documents')->group(function () {
        Route::post('/change-process-status', [DocumentController::class, 'changeProcessStatus'])->name('changeProcessStatus');
    });
    // employees
    Route::prefix('employees')->group(function () {
        Route::post('/confirm-payment', [EmployeeController::class, 'confirmPayment'])->name('confirmPayment');
    });
    // projects
    Route::prefix('projects')->group(function () {
        Route::post('/create', [ProjectController::class, 'create'])->name('createProject');
        Route::post('/update', [ProjectController::class, 'update'])->name('updateProject');
    });
})->middleware('auth');

Route::prefix('auth')->group(function () {
    Route::get('/is-logged-in', [AuthController::class, 'isLoggedIn'])->name('isLoggedIn');
});