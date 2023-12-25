<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class OrderUser extends Model
{
    
    public function getFullNameAttribute($value)
    {
        $name = $this->first_name.' '. $this->last_name;
        if ($this->shop_name != '') {
            $name .= ' (' . $this->shop_name . ')';
        }
        return $name;
    }
    
    /**
     * boot
     */
    protected static function boot ()
    {
    	parent::boot();
        
    	static::deleting(function($stores) {
    		
    	});
    }
    
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'owner_name', 'shop_name', 'contact_no', 'address', 'town', 'city', 'postal_code', 'notes'];
    
}
