<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\MemberController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleLineItemController;
// use App\Http\Controllers\SaleLineItemController;

// Route::apiResource('members', App\Http\Controllers\MemberController::class);
// Route::apiResource('sales', App\Http\Controllers\SaleController::class); http://127.0.0.1:8000/api/sales
// Route::apiResource('items', App\Http\Controllers\ItemController::class); // http://127.0.0.1:8000/api/items (post)
// Route::apiResource('payments', App\Http\Controllers\PaymentController::class);


// Members
Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::get('/members/{id}', [MemberController::class, 'show']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);

// Items - CRUD
Route::apiResource('/items', ItemController::class);

// Sales
Route::post('/sales', [SaleController::class, 'store']); // Open a sale
Route::get('/sales/{sale}', [SaleController::class, 'show']); // View a sale details

// Payments
Route::post('/payments', [PaymentController::class, 'store']); // Process a payment

// // Sale Line Items
Route::post('/sale-line-items', [SaleLineItemController::class, 'store']);
Route::delete('/sale-line-items/{id}', [SaleLineItemController::class, 'destroy']);
