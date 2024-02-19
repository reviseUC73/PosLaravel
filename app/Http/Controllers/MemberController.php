<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Ensure you have a Member model at App\Models\Member

class MemberController extends Controller
{   

    public function indexView()
    {
        $members = Member::all();
        return view('members.index', ['members' => $members]);
    }

    public function showView($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', ['member' => $member]);
    }

 // Show the form for creating a new member
    public function createView()
    {
     return view('members.create');
    }
    
    // Show the form for editing the specified member
    public function editView($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', ['member' => $member]);
    }

        // Update the specified member in storage
        public function updateView(Request $request, $id)
        {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'balance' => 'sometimes|required|numeric',
                // Include other fields as necessary
            ]);
    
            $member = Member::findOrFail($id);
            $member->update($validatedData);
            return redirect()->route('members.index');
        }
    
        // Remove the specified member from storage
        public function destroyView($id)
        {
            $member = Member::findOrFail($id);
            $member->delete();
            return redirect()->route('members.index');
        }


    // Display a listing of members
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
    }

        // Display the specified member
        public function show($id)
        {
            $member = Member::findOrFail($id);
            return response()->json($member);
        }
    

    // Store a newly created member
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'location' => 'required|string|max:255',
            
        ]);

        $member = Member::create($validatedData);
         if ($request->ajax()) {
            return response()->json(['message' => 'Member added successfully', 'member' => $member], 201);
        }

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
 
        // return response()->json($member, 201);
    }



      // Store a newly created member
      public function storeAPI(Request $request)
      {
          $validatedData = $request->validate([
              'name' => 'required|string|max:255',
              'balance' => 'required|numeric',
              'location' => 'required|string|max:255',
              
          ]);
          $member = Member::create($validatedData);
          return response()->json($member, 201);
      }
    
      public function update(Request $request, $id)
      {
          $validatedData = $request->validate([
              'name' => 'required|string|max:255',
              'balance' => 'required|numeric',
              'location' => 'required|string|max:255',
          ]);
      
          $member = Member::findOrFail($id);
          $member->update($validatedData);
      
          if ($request->ajax()) {
              return response()->json(['message' => 'Member updated successfully', 'member' => $member], 200);
          }
      
          return redirect()->route('members.index')->with('success', 'Member updated successfully.');
      }
      

    // Update the specified member
    public function updateAPI(Request $request, $id)
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
            $member = Member::find($id);

            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            $member->delete();
            return response()->json(['message' => 'Member removed successfully'], 200);
        }
    }
