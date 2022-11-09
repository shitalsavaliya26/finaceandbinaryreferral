<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use HasFactory;

    // protected $table = "user_wallets";
    protected $fillable = [
        'user_id', 'crypto_wallet','yield_wallet','commission_wallet','nft_wallet','pairing_commission','referral_commission','withdrawal_balance','carry_forward','carry_forward_to','roi'
    ];
    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
