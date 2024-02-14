<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['member_id', 'status', 'totalPrice'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function saleLineItems()
    {
        return $this->hasMany(SaleLineItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function calculateTotalPrice()
    {
        return $this->saleLineItems->sum(function($lineItem) {
            return $lineItem->quantity * $lineItem->item->price;
        });
    }
}
