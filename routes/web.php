<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;

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

Route::get('/', [TrainController::class, 'index'])->name('home');

Route::resource('trains', TrainController::class);
Route::delete('train-cars/{train}/first', [TrainController::class, 'destroyFirstCar']);
Route::delete('train-cars/{train}/last', [TrainController::class, 'destroyLastCar']);
