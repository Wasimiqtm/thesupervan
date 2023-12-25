<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WholesellerWallet extends Model
{
    protected $table = 'wholeseller_wallets';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
    
    protected $fillable = [
        'user_id', 'order_id','credit','debit'
    ];
    
     public function user()
    {
        return $this->belongsToMany(Models\User::class,'user_id');
    }
}
