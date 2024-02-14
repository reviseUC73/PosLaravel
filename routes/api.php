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


Route::apiResource('members', App\Http\Controllers\MemberController::class);
Route::apiResource('sales', App\Http\Controllers\SaleController::class); http://127.0.0.1:8000/api/sales
Route::apiResource('items', App\Http\Controllers\ItemController::class); // http://127.0.0.1:8000/api/items (post)
Route::apiResource('payments', App\Http\Controllers\PaymentController::class);


// Members
// For API routes (routes/api.php)
Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::get('/members/{id}', [MemberController::class, 'show']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);

Route::post('/members', [MemberController::class, 'store']);
Route::get('/members', [MemberController::class, 'index']);
Route::apiResource('members', MemberController::class);

// Items - CRUD
Route::apiResource('/items', ItemController::class);

// Sales
Route::post('/sales', [SaleController::class, 'store']); // Open a sale
Route::get('/sales/{sale}', [SaleController::class, 'show']); // View a sale details

// // Sale Line Items
// Route::post('/sales/{sale}/line-items', [SaleLineItemController::class, 'store']); // Add a sale line item
// Route::delete('/line-items/{lineItem}', [SaleLineItemController::class, 'destroy']); // Remove a sale line item

// Payments
Route::post('/payments', [PaymentController::class, 'store']); // Process a payment


// Define the route for adding a new sale line item
Route::get('/sale-line-items', [SaleLineItemController::class, 'index']);
Route::post('/sale-line-items', [SaleLineItemController::class, 'store']);
Route::delete('/sale-line-items/{id}', [SaleLineItemController::class, 'destroy']);
