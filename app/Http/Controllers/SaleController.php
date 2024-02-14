<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return response()->json($sales);
    }

    // post method
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'member_id' => 'required|exists:members,id',
        // Add other sale fields here
    ]);

    $sale = Sale::create($validatedData);
    return response()->json($sale, 201);
    }

    // get method
    public function show($id)
    {
        $sale = Sale::findOrFail($id);
        return response()->json($sale);
    }

    // update method
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $validatedData = $request->validate([
            'member_id' => 'exists:members,id',
            'status' => 'required',
        ]);

        $sale->update($validatedData);
        return response()->json($sale);
    }

    public function destroy($id)
    {
        Sale::destroy($id);
        return response()->json(null, 204);
    }
}
