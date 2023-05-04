<?php

use App\Http\Controllers\PurchaseCodeController;
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


Route::post('/validate-purchase-code', [PurchaseCodeController::class, 'validatePurchaseCode']);
Route::post('/generate-purchase-code', [PurchaseCodeController::class, 'generatePurchaseCode'])->middleware('auth:sanctum');
