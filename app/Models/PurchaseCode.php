<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_code',
        'activated',
        'activation_date',
        'expires_at',
    ];

}
