<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCartHistory extends Model
{
    protected $fillable = [
        'transaction_id', 'product_id', 'quantity', 'amount_per_item', 'exclude_include_vat', 'created_at', 'updated_at'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
