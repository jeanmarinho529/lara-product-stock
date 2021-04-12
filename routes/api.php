<?php

use App\Http\Controllers\Api\{CategoryController, ProductController, StateController};
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

// Public routes
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::get('states', StateController::class);

Route::get('categories', [CategoryController::class, 'index'])->name('api-category-index');
Route::get('categories/{id}', [CategoryController::class, 'show'])->name('api-category-show');

Route::get('products', [ProductController::class, 'index'])->name('api-product-index');
Route::get('products/{slug}', [ProductController::class, 'show'])->name('api-product-show');

// Authenticated routes 
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::post('categories', [CategoryController::class, 'store'])->name('api-category-create');

    // Route authorized for admin only
    Route::group(['middleware' => ['is.admin']], function () {
        Route::put('categories/{id}', [CategoryController::class, 'update'])->name('api-category-update');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('api-category-destroy');
    });

    Route::post('products', [ProductController::class, 'store'])->name('api-product-create');
    Route::post('products/movement/{slug}', [ProductController::class, 'movement'])->name('api-product-movement');
    Route::put('products/{slug}', [ProductController::class, 'update'])->name('api-product-update');
    Route::delete('products/{slug}', [ProductController::class, 'destroy'])->name('api-product-destroy');
});