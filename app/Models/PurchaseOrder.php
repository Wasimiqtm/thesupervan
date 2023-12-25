<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class PurchaseOrder extends Model
{
    
    
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['supplier_id', 'supplier_name', 'total_quantity', 'total_price', 'products'];
    
}
