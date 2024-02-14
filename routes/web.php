<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('members', App\Http\Controllers\MemberController::class);
Route::resource('sales', App\Http\Controllers\SaleController::class);
Route::resource('items', App\Http\Controllers\ItemController::class);
Route::resource('payments', App\Http\Controllers\PaymentController::class);


use App\Http\Controllers\SalesProcessController;
Route::get('/sales-process', [SalesProcessController::class, 'index'])->name('sales.process');
