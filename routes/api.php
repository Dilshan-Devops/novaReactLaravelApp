<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\NovaAuthController;
use App\Http\Controllers\API\NovaUsersController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [NovaAuthController::class, 'novaLogout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/users', NovaUsersController::class);
});

Route::post('/register', [NovaAuthController::class, 'novaRegister']);
Route::post('/login', [NovaAuthController::class, 'novaLogin']);
