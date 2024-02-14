<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Ensure you have a Member model at App\Models\Member

class MemberController extends Controller
{
    // Display a listing of members
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
    }

    // Store a newly created member
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'type' => 'required|string',
        ]);

        $member = Member::create($validatedData);
        return response()->json($member, 201);
    }

    // Display the specified member
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    // Update the specified member
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'balance' => 'sometimes|required|numeric',
        ]);

        $member = Member::findOrFail($id);
        $member->update($validatedData);
        return response()->json($member);
    }

    // Remove the specified member
    public function destroy($id)
    {
        Member::destroy($id);
        return response()->json(null, 204);
    }
}
