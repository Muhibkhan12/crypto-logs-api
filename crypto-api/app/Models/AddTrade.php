<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddTrade extends Model
{
    protected $fillable = [
        'user_id',
        'coin',
        'type',
        'entry_price',
        'quantity',
        'status',
        'opened_at',
        'closed_at',
        'timestamp',
    ];
}
