<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'price', 'description', 'type'];

    public function saleLineItems()
    {
        return $this->hasMany(SaleLineItem::class);
    }
}
