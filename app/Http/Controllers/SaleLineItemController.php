<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleLineItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response; 

class SaleLineItemController extends Controller
{
    /**
     * Store a newly created sale line item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // index
    public function index()
    {
        $saleLineItems = SaleLineItem::all();
        return response()->json($saleLineItems);
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

    // update
    public function update(Request $request, $id)
    {
        $saleLineItem = SaleLineItem::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'sale_id' => 'exists:sales,id',
            'item_id' => 'exists:items,id',
            'quantity' => 'integer|min:1',
            // Optionally validate other fields as per your schema
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $saleLineItem->update($validator->validated());

        return response()->json($saleLineItem);
    }
}
