<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // get method
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    // post method
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        $item = Item::create($validatedData);
        return response()->json($item, 201);
    }

    // get method
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    // update method
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        $item->update($validatedData);
        return response()->json($item);
    }

    // delete method
    public function destroy($id)
    {
        Item::destroy($id);
        return response()->json(null, 204);
    }
}
