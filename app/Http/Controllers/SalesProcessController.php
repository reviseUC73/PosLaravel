<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Payment;

class SalesProcessController extends Controller
{
    public function index(){
    // For simplicity, fetching the latest sale and its associated details
    $sale = Sale::with(['member', 'saleLineItems.item', 'payments'])->latest()->first();

    if (!$sale) {
        // If there are no sales, you can return a view with a message or redirect elsewhere
        return view('sales.process', ['message' => 'No sales found.']);
    }

    // Calculate the total price for the sale
    $totalPrice = $sale->saleLineItems->reduce(function ($carry, $lineItem) {
        return $carry + ($lineItem->quantity * $lineItem->item->price);
    }, 0);

    return view('sales.process', compact('sale', 'totalPrice'));
    }
}
