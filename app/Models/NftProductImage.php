<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftProductImage extends Model
{
    use HasFactory;

    protected $table = "nft_product_images";

    public function nftproduct(){
        return $this->belongsTo(NftProduct::class,'product_id','id');
    }
}
