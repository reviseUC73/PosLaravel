<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Member;

use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
        /**
     * Process a payment for a given sale ID and amount.
     *
     * @param  int  $saleId
     * @param  float  $amount
     * @return \Illuminate\Http\Response
     */
    public function pprocessPayment($saleId, $memberId)
    {
        // Begin a database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            $sale = Sale::with('saleLineItems.item')->find($saleId);
            $member = Member::find($memberId);

            // Check if sale and member exist
            if (!$sale || !$member) {
                return response()->json(['message' => 'Sale or Member not found'], Response::HTTP_NOT_FOUND);
            }

            // Calculate total sale price
            $totalSalePrice = $sale->saleLineItems->sum(function ($lineItem) {
                return $lineItem->quantity * $lineItem->item->price;
            });

            // Check if member has enough balance
            if ($member->balance < $totalSalePrice) {
                return response()->json(['message' => 'Insufficient balance'], Response::HTTP_BAD_REQUEST);
            }

            // Deduct sale price from member's balance and save
            $member->balance -= $totalSalePrice;
            $member->save();

            // Create a payment record
            $payment = new Payment([
                'sale_id' => $saleId,
                'member_id' => $memberId,
                'amount' => $totalSalePrice,
                // Add any other necessary fields
            ]);
            $payment->save();

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Payment processed successfully', 'payment' => $payment], Response::HTTP_OK);

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return response()->json(['message' => 'Payment processing failed', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    
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
        return response()->json(null, 202);
    }

    public function processPayment2($saleId)
{
    DB::beginTransaction();

    try {
        $sale = Sale::with(['member', 'saleLineItems.item'])->findOrFail($saleId);

        $totalSalePrice = $sale->saleLineItems->sum(function ($lineItem) {
            return $lineItem->quantity * $lineItem->item->price;
        });

        // Check if the member's balance covers the sale
        if ($sale->member->balance < $totalSalePrice) {
            return response()->json(['message' => 'Insufficient balance',
                                    "member_id" => $sale->member->id,
                                    "member_balance" => $sale->member->balance,
                                    'amount' => $totalSalePrice], Response::HTTP_BAD_REQUEST);
        }

        // Deduct the total price from the member's balance
        $sale->member->balance -= $totalSalePrice;
        $sale->member->save();

        // Update the member model in the sale relation if needed
        $sale->load('member'); // Refresh member data in the $sale relation

        // Create a payment record
        $payment = new Payment([
            'sale_id' => $sale->id,
            'member_id' => $sale->member->id,
            'amount' => $totalSalePrice,
            // Include additional fields as necessary
        ]);
        $payment->save();

        DB::commit();

        return response()->json([
            'message' => 'Payment processed successfully',
            'new_balance' => $sale->member->balance, // Reflect the new balance
            'payment_details' => [
                'payment_id' => $payment->id,
                'sale_id' => $sale->id,
                'member_id' => $sale->member->id,
                'amount' => $totalSalePrice,
            ]
        ], Response::HTTP_OK);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Payment processing failed', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
public function indexView()
{
    $payments = Payment::with(['member', 'sale'])->get(); // Assuming relationships are defined
    return view('payments.index', compact('payments'));
}

    
}
