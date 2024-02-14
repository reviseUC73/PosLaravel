{{-- resources/views/sales/process.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sales Process Overview</h2>
    <h3>Member Information</h3>
    <p>Name: {{ $sale->member->name }}</p>
    <p>Balance: {{ $sale->member->balance }}</p>

    <h3>Items Purchased</h3>
    <ul>
        @foreach ($sale->saleLineItems as $lineItem)
            <li>{{ $lineItem->item->name }} - Quantity: {{ $lineItem->quantity }} - Price: ${{ $lineItem->item->price }}</li>
        @endforeach
    </ul>
    <p>Total Price: ${{ $totalPrice }}</p>

    <h3>Payment Details</h3>
    @foreach ($sale->payments as $payment)
        <p>Amount Paid: ${{ $payment->amount }} on {{ $payment->paymentDate }}</p>
    @endforeach
</div>
@endsection
