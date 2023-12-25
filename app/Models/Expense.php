<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\Admin;

class Expense extends Model
{
    
    /**
     * belongs To relation User
     */

    public function admin()
    {
    	return $this->belongsTo(Admin::class);
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
    protected $fillable = ['admin_id', 'type_id', 'name', 'admin', 'image', 'date', 'amount'];
    
}
