<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Member; 
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SaleLineItem;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{

    public function showAll()
    {
        $sale = Sale::all();
        return response()->json($sale);
    }
    // get all
    public function showSaleDatailAll()
    {
        $sales = Sale::with(['saleLineItems.item'])->get();

        $salesDetails = $sales->map(function ($sale) {
            return [
                'sale_id' => $sale->id,
                'sale_date' => $sale->created_at->toDateString(), // Assuming you have timestamps enabled
                'total_price' => $sale->saleLineItems->reduce(function ($total, $lineItem) {
                    return $total + ($lineItem->quantity * $lineItem->item->price);
                }, 0),
                'items' => $sale->saleLineItems->map(function ($lineItem) {
                    return [
                        'item_id' => $lineItem->item->id,
                        'item_name' => $lineItem->item->name,
                        'quantity' => $lineItem->quantity,
                        'price_per_item' => $lineItem->item->price,
                        'total_price' => $lineItem->quantity * $lineItem->item->price,
                    ];
                }),
            ];
        });

        return response()->json($salesDetails);
    }

    // get by id
    public function showSaleDatailById($id)
    {
        $sale = Sale::with(['saleLineItems.item'])->find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], Response::HTTP_NOT_FOUND);
        }

        $saleDetails = [
            'sale_id' => $sale->id,
            'total_price' => $sale->saleLineItems->reduce(function ($total, $lineItem) {
                return $total + ($lineItem->quantity * $lineItem->item->price);
            }, 0),
            'items' => $sale->saleLineItems->map(function ($lineItem) {
                return [
                    'item_id' => $lineItem->item->id,
                    'item_name' => $lineItem->item->name,
                    'quantity' => $lineItem->quantity,
                    'price_per_item' => $lineItem->item->price,
                    'total_price' => $lineItem->quantity * $lineItem->item->price,
                ];
            }),
        ];

        return response()->json($saleDetails);
    }

    public function openSale(Request $request)
    {
        // Validate the incoming request data first
        $validatedData = $request->validate([
            'member_id' => 'required|integer',
            // Add other sale fields here as necessary
        ]);

        // Check if the member exists
        $member = Member::find($validatedData['member_id']);
        if (!$member) {
            return response()->json(['message' => 'Member not found'], Response::HTTP_NOT_FOUND); // 404
        }

        // Proceed to create the sale since the member exists
        $sale = Sale::create($validatedData);
        return response()->json(['message' => 'Sale created successfully', 'data' => $sale], Response::HTTP_CREATED); // 201
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], Response::HTTP_NOT_FOUND); // 404
        }

        $validatedData = $request->validate([
            'member_id' => 'sometimes|exists:members,id',
            'status' => 'required',
        ]);

        $sale->update($validatedData);
        return response()->json(['message' => 'Sale updated successfully', 'data' => $sale]);
    }

    public function closeSale($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], Response::HTTP_NOT_FOUND); // 404
        }

        $sale->delete();
        return response()->json(['message' => 'Sale deleted successfully'], Response::HTTP_OK); // 200
    }
     // store (add)
     public function addLineItem(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'sale_id' => 'required|exists:sales,id',
             'item_id' => 'required|exists:items,id',
             'quantity' => 'required|integer|min:1',
             // Optionally validate other fields as per your schema
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
 
         $saleLineItem = SaleLineItem::create($validator->validated());
 
         return response()->json($saleLineItem, 201);
     }
 
     // remove
     public function removeLineItem($id) // If you're not using route model binding
     {
         $saleLineItem = SaleLineItem::findOrFail($id);
         $saleLineItem->delete();
         return response()->json(['message' => 'Sale line item deleted successfully'], 200);
     }
 
}
