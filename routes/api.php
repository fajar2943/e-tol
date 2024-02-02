<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TopupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/midtrans-callback', [SiteController::class, 'callback']);
Route::post('/transaction', [SiteController::class, 'transaction']);
Route::get('/transaction-chart', [DashboardController::class, 'transaction_chart']);
Route::get('/revenue-chart', [DashboardController::class, 'revenue_chart']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/payment/{token}', function($token){
    return view('api.payment', compact('token'));
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::resource('/topups', TopupController::class);
});
