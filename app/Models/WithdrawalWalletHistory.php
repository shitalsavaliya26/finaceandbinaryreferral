<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalWalletHistory extends Model
{
    use HasFactory;

    protected $table = "withdrawal_wallet_histories";

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
