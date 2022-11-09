<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairingCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','left_sale','right_sale','carry_forward','actual_amount','commission_got_from','pairing_commission','pairing_percent','daily_limit','actual_commission_amount','carry_forward_used'
    ];
}
