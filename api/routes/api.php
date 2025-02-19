<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AdminAuthController;

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

Route::middleware(['api'])->prefix('v1')->group(function () {
    //Admin Login
    Route::post('/admin-login', [AdminAuthController::class, 'adminLogin']);
});

/*User routes*/
Route::middleware(['auth:api', 'scope:user'])->prefix('v1')->group(function () {});


Route::middleware(['auth:api', 'scope:admin'])->prefix('v1')->group(function () {
    //Admin Logout
    Route::post('/admin-logout', [AdminAuthController::class, 'adminLogout']);
});
