<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Front\QuizController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout/{user}', [AuthController::class, 'logout']);

    Route::prefix('quiz')->group(function () {
        Route::get('/', [QuizController::class, 'index']);
        Route::get('/{quiz}', [QuizController::class, 'show']);
        Route::post('/', [QuizController::class, 'store']);
        Route::put('/{quiz}', [QuizController::class, 'update']);
        Route::delete('/{quiz}', [QuizController::class, 'destroy']);
    });

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
