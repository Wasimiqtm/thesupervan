<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'paypal_id',
        'payment_method',
        'cart_id',
        'admin_id',
        'parent_id',
        'qty',
        'cost',
        'cost_of_goods',
        'discount',
        'tax',
        'amount',
        'cart_details',
        'trans_details',
        'type',
        'updated_columns',
        'is_latest',
        'order_date'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
    
    public function admin(){
        return $this->belongsTo(\App\Admin::class);
    }

    public function quotation(){
        return $this->hasOne(\App\Models\Quotation::class, 'transaction_id');
    }

    public function cart(){
        return $this->belongsTo(ShoppingCart::class,'cart_id');
    }

    public function purchasedItems(){
        return $this->hasMany(ShoppingCartHistory::class,'transaction_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    
    public function scopeDateFilter($query){
       
       
        return $query->whereDate('order_date','>=',request()->from_date)->whereDate('order_date','<=',request()->to_date);
    }
}
