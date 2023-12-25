<?php

namespace App;

use App\Models\Transaction;
use App\Models\UserWallet;
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
        return $this->hasMany(Models\Transaction::class, 'user_id');
    }

    public function getFullNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
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

    public function transaction()
    {
        return $this->hasMany(Transaction::class,'user_id');
   }

   public function user_wallets()
    {
        return $this->hasMany(UserWallet::class,'user_id');
   }
}
