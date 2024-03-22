<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class, 'index']);

Route::get('/masters/categories/get-all-data', [CategoryController::class, 'getAllData']);
Route::post('/masters/categories/activated/{category}', [CategoryController::class, 'activated']);
Route::resource('/masters/categories', CategoryController::class);

Route::get('/masters/authors/get-all-data', [AuthorController::class, 'getAllData']);
Route::post('/masters/authors/activated/{category}', [AuthorController::class, 'activated']);
Route::resource('/masters/authors', AuthorController::class);
