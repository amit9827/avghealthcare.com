<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_type',
        'transaction_id',
        'status',
        'amount',
        'payment_details',
        'payment_mode',
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];
}
