<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\BookController;

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
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resources([
        'book' => BookController::class
    ]);
    Route::get('clients', [UserController::class, 'clients']);
    Route::get('booksActive', [BookController::class, 'actives']);
    Route::get('booksreserved', [BookController::class, 'booksreserved']);
    Route::get('booksreservedXClient', [BookController::class, 'booksreservedXClient']);
    Route::post('booksXClient', [BookController::class, 'booksXClient']);
    Route::post('reserveBook', [BookController::class, 'reserveBook']);
    Route::post('returnBook', [BookController::class, 'returnBook']);
    Route::post('close', [AuthController::class, 'close']);
});
