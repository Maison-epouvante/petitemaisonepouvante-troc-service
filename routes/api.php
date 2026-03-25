<?php

use App\Http\Controllers\TrocController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'Troc Service is working!',
        'service' => 'petitemaisonepouvante-troc-service',
        'timestamp' => now()
    ]);
});

// Troc routes (authentication handled by API Gateway)
Route::get('/trocs', [TrocController::class, 'index']);
Route::post('/trocs', [TrocController::class, 'store']);
Route::get('/trocs/{id}', [TrocController::class, 'show']);
Route::put('/trocs/{id}', [TrocController::class, 'update']);
Route::delete('/trocs/{id}', [TrocController::class, 'destroy']);
