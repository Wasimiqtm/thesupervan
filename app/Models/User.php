<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * belongs To relation Store_products
     */

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function getFullNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getNameWithIdAttribute($value)
    {
        return $this->customer_id.' - '.$this->name;
    }

    public function getFullNameWithEmailAttribute($value)
    {
        return $this->first_name.' '.$this->last_name.' ('.$this->email.')';
    }
    
    public function getWholesalerNameAttribute($value)
    {
        $shopName = '';
        if (empty($this->owner_name)) {
            return $this->first_name.' '.$this->last_name;
        }
        if (!empty($this->shop_name)) {
            $shopName = ' (' . $this->shop_name . ')';
        }
        return $this->owner_name . $shopName;
    }
    
 public function getAmountSumAttribute(){
   
    return $this->transactions->sum('amount');
}

    public function getNameWithCustomerIdAndShopNameAttribute($value)
    {
        return $this->customer_id.' - '.$this->name.' - '. $this->shop_name;
    }

 public function scopeDropship($query)
    {
        return $query->whereType('dropshipper');
    }

    public function scopeWhole($query)
    {
        return $query->whereType('wholesaler');
    }
    
        public function shoppings()
    {
       return  $this->hasMany(ShoppingCart::class);
    }
    
      public function wallets()
    {
        return $this->hasMany(WholesellerWallet::class,'user_id');
    }

    public function user_wallets()
    {
        return $this->hasMany(UserWallet::class,'user_id');
   }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'first_name', 'last_name', 'profile_image', 'email', 'password','phone', 'mobile',
        'type', 'vat_number', 'company_name','wholesaler_type','quantity_1','percentage_1',
        'quantity_2','percentage_2','quantity_3','percentage_3','is_active','mark_up',
        'is_latest','address', 'name', 'shop_name', 'town', 'city', 'postal_code', 'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
