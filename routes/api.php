<?php

use App\Http\Controllers\Api\{CategoryController, StateController};
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('states', StateController::class);

Route::get('categories', [CategoryController::class, 'index'])->name('api-category-index');
Route::get('categories/{id}', [CategoryController::class, 'show'])->name('api-category-show');


// Authenticated routes 
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('categories', [CategoryController::class, 'store'])->name('api-category-create');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('api-category-update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('api-category-destroy');
});