<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File, Hashids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VanStoreProduct extends Model
{


    /**
     * belongs To relation Product
     */

    public function product()
    {
    	return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * boot
     */
    protected static function boot ()
    {
    	parent::boot();
    	static::deleting(function($product) {

    	});
    }


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'admin_id', 'quantity'];

}

