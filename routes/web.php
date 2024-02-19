<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleLineItemController;
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

// Route::resource('members', App\Http\Controllers\MemberController::class);
// Route::resource('sales', App\Http\Controllers\SaleController::class);
// Route::resource('items', App\Http\Controllers\ItemController::class);
// Route::resource('payments', App\Http\Controllers\PaymentController::class);


// Route::get('/sales-process', [SalesProcessController::class, 'index'])->name('sales.process');
// Route::resource('members', 'MemberController');

// Route::get('/members', [MemberController::class, 'indexView'])->name('members.index');
// // Route::get('/members/{id}', [MemberController::class, 'showView'])->name('members.show');
// // Route::get('/members/create', [MemberController::class, 'createView'])->name('members.create');

// // Route::get('members', [MemberController::class, 'index'])->name('members.index');
// Route::get('members/create', [MemberController::class, 'createView'])->name('members.create');
// Route::post('members', [MemberController::class, 'store'])->name('members.store');
// Route::get('members/{id}', [MemberController::class, 'showView'])->name('members.show');
// Route::get('members/{id}/edit', [MemberController::class, 'editView'])->name('members.edit');
// Route::put('members/{id}', [MemberController::class, 'update'])->name('members.update');
// Route::delete('members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
// // Add routes for create, update, and delete as needed
// Web Interface Routes

Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');

Route::get('/members', [MemberController::class, 'indexView'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'createView'])->name('members.create');
Route::get('/members/{id}', [MemberController::class, 'showView'])->name('members.show');
Route::get('/members/{id}/edit', [MemberController::class, 'editView'])->name('members.edit');
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');


Route::get('/items', [ItemController::class, 'indexView'])->name('items.indexView');
Route::get('/items/{id}/edit', [ItemController::class, 'editView'])->name('items.edit');
Route::put('/items/{id}', [ItemController::class, 'updateView'])->name('items.update');


Route::get('/payments', [PaymentController::class, 'indexView'])->name('payments.indexView');

Route::get('/sale-line-items', [SaleLineItemController::class, 'indexView'])->name('saleLineItems.indexView');