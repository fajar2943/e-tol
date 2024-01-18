<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
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

Route::get('/', [SiteController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);

Route::group(['middleware' => ['auth', 'CheckRoles:Customer']], function () {
    Route::post('/vehicle', [SiteController::class, 'vehicle']);
    Route::put('/vehicle/{id}', [SiteController::class, 'updateVehicle']);
    Route::get('/vehicle/{id}/delete', [SiteController::class, 'deleteVehicle']);
    Route::post('/topup', [SiteController::class, 'topup']);
    Route::get('/invoice/{inv_no}', [SiteController::class, 'invoice']);
});
Route::group(['middleware' => ['auth', 'CheckRoles:Customer,Admin']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::prefix('admin')->group(function(){
    Route::group(['middleware' => ['auth', 'CheckRoles:Admin']], function () {
        Route::get('/', [DashboardController::class, 'index']);
    });
});
