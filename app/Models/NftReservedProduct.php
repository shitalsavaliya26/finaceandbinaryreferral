<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftReservedProduct extends Model
{
    use HasFactory;

    protected $table = "nft_reserved_products";

    protected $fillable = ['user_id', 'product_id','created_at', 'updated_at'];

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function nftproduct(){
        return $this->belongsTo(NftProduct::class,'product_id','id');
    }
}
