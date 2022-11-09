<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftPurchaseHistory extends Model
{
    use HasFactory;

    protected $table = "nft_purchase_histories";
    protected $fillable = ['user_id', 'product_id', 'amount', 'order_id', 'purchase_date', 'status','sell_date','type','created_at', 'updated_at'];

    protected $dates = ['purchase_date', 'sell_date'];

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function nftproduct(){
        return $this->belongsTo(NftProduct::class,'product_id','id');
    }

    public function withdrawal(){
        return $this->hasMany(NftWithdrawalRequest::class,'nft_id')->where('status','!=','2');
    }
}
