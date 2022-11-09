<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftPurchaseLog extends Model
{
    use HasFactory;

    protected $table = "nft_purchase_logs";
    
    protected $fillable = ['purchase_user_type', 'product_id','purchase_amount','created_at', 'updated_at'];
   

    public function nftproduct(){
        return $this->belongsTo(NftProduct::class,'product_id','id');
    }
}
