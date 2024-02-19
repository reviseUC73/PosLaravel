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
// use App\Http\Controllers\PaymentController;


// use App\Http\Controllers\SaleLineItemController;

Route::apiResource('members', App\Http\Controllers\MemberController::class);
Route::apiResource('sales', App\Http\Controllers\SaleController::class); http://127.0.0.1:8000/api/sales
Route::apiResource('items', App\Http\Controllers\ItemController::class); // http://127.0.0.1:8000/api/items (post)
Route::apiResource('payments', App\Http\Controllers\PaymentController::class);

// Members
Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::get('/members/{id}', [MemberController::class, 'show']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);

// Items - CRUD
Route::apiResource('/items', ItemController::class);

// Sales
Route::get('/saleAll', [SaleController::class, 'showAll']); // View a sale details
Route::get('/sales', [SaleController::class, 'showSaleDatailAll']); // View a sale details
Route::get('/sales/{sale}', [SaleController::class, 'showSaleDatailById']); // View a sale details
Route::post('/sales', [SaleController::class, 'openSale']); // Open a sale
Route::delete('/sales/{sale}', [SaleController::class, 'closeSale']); // Close a sale
// // Sale Line Items - Sale
Route::post('/sale/sale-line-items', [SaleController::class, 'addLineItem']);
Route::delete('/sale/sale-line-items/{id}', [SaleController::class, 'removeLineItem']);

// // Sale Line Items
Route::get('/sale-line-items', [SaleLineItemController::class, 'index']);
Route::post('/sale-line-items', [SaleLineItemController::class, 'addLineItem']);
Route::delete('/sale-line-items/{id}', [SaleLineItemController::class, 'removeLineItem']);

// Payments
Route::post('/process-payment2/sale/{saleId}', [PaymentController::class, 'processPayment2']);
Route::get('/payments/{paymentId}/validate-amount', [PaymentController::class, 'validatePaymentAmount']);
Route::post('/payments', [PaymentController::class, 'store']); // Process a payment