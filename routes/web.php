<?php

use App\Http\Controllers\CryptographyController;
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

Route::get('/', [CryptographyController::class, 'index']);

Route::post('/encrypt', [CryptographyController::class, 'encrypt']);
Route::post('/decrypt', [CryptographyController::class, 'decrypt']);
