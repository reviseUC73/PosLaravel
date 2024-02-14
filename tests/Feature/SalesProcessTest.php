<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member; // Use Model classes directly, not Factory classes.
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleLineItem;
use App\Models\Payment;

class SalesProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testMemberPurchasesAndPayment()
    {
        // Create a member named Rew with a balance of 2000
        $member = Member::factory()->create(['name' => 'Rew', 'balance' => 2000]);

        // Create items
        $phone = Item::factory()->create(['name' => 'Phone', 'price' => 500]);
        $computer = Item::factory()->create(['name' => 'Computer', 'price' => 1000]);
        $food = Item::factory()->create(['name' => 'Food', 'price' => 100]);
        $water = Item::factory()->create(['name' => 'Water', 'price' => 50]);

        // Create a sale
        $sale = Sale::factory()->create(['member_id' => $member->id]);

        // Add items to the sale as line items
        SaleLineItem::factory()->create(['sale_id' => $sale->id, 'item_id' => $phone->id, 'quantity' => 1]);
        SaleLineItem::factory()->create(['sale_id' => $sale->id, 'item_id' => $computer->id, 'quantity' => 1]);
        SaleLineItem::factory()->create(['sale_id' => $sale->id, 'item_id' => $food->id, 'quantity' => 1]);
        SaleLineItem::factory()->create(['sale_id' => $sale->id, 'item_id' => $water->id, 'quantity' => 2]);

        // Calculate total price
        $totalPrice = $sale->saleLineItems->reduce(function ($carry, $lineItem) {
            return $carry + ($lineItem->quantity * $lineItem->item->price);
        }, 0);

        // Assert the total price is as expected
        $expectedTotal = (1 * 500) + (1 * 1000) + (1 * 100) + (2 * 50); // Total expected price calculation
        $this->assertEquals($expectedTotal, $totalPrice);

        // Create a payment for the total price
        $payment = Payment::factory()->create([
            'member_id' => $member->id,
            'sale_id' => $sale->id,
            'amount' => $totalPrice,
            'paymentDate' => now(),
        ]);

        // Assert the payment was created successfully
        $this->assertDatabaseHas('payments', [
            'member_id' => $member->id,
            'sale_id' => $sale->id,
            'amount' => $totalPrice,
        ]);

        // Optionally, assert member's balance is updated if your logic includes this
        // This line assumes that you handle balance updates elsewhere in your application.
        // $this->assertEquals(1000, $member->fresh()->balance);
    }
}
