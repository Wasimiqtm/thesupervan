<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User2Pay extends Model
{
    protected $table = 'user_2pay';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
    
    protected $fillable = [
        'user_id', 'order_id','credit','debit','date','note'
    ];
    
     public function user()
    {
        return $this->belongsToMany(Models\User::class,'user_id');
    }
}
