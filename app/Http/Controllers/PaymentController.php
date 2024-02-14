<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id',
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric',
            'paymentDate' => 'required|date',
        ]);

        $payment = Payment::create($validatedData);
        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $validatedData = $request->validate([
            'member_id' => 'exists:members,id',
            'sale_id' => 'exists:sales,id',
            'amount' => 'required|numeric',
            'paymentDate' => 'required|date',
        ]);

        $payment->update($validatedData);
        return response()->json($payment);
    }

    public function destroy($id)
    {
        Payment::destroy($id);
        return response()->json(null, 204);
    }
}
