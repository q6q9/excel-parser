<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  [\App\Http\Controllers\ExcelController::class, 'index']);
Route::post('/upload', [\App\Http\Controllers\ExcelController::class, 'upload'])->name('upload');

Route::get('/rows',  [\App\Http\Controllers\RowsController::class, 'index']);

