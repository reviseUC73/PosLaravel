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
    public function store(Request $request)
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

    public function destroy($id)
    {
        $saleLineItem = SaleLineItem::findOrFail($id);
        $saleLineItem->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT); // 204 No Content
    }

    // index
    public function index()
    {
        $saleLineItems = SaleLineItem::all();
        return response()->json($saleLineItems);
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
