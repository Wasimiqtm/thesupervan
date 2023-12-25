<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'transaction_id',
        'invoice_no',
        'transaction_details',
        'is_canceled',
        'note'
    ];

}
