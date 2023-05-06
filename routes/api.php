<?php

use App\Http\Controllers\LicenseController;
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

Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::middleware('auth:api')->get('/users/{id}', [App\Http\Controllers\Api\UsersController::class, 'show']);


Route::post('/validate-purchase-code', [LicenseController::class, 'validateLicense']);
Route::post('/generate-purchase-code', [LicenseController::class, 'generatePurchaseCode'])->middleware('auth:sanctum');
