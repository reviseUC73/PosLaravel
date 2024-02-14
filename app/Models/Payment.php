<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['member_id', 'sale_id', 'amount', 'paymentDate'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
