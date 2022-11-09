<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftProduct extends Model
{
    use HasFactory;

    protected $table = "nft_products";
    protected $fillable = ['is_deleted'];

    public function nftcategory(){
        return $this->belongsTo(NftCategory::class,'category_id','id');
    }

    public function nftpurchasehistory(){
        return $this->hasMany(NftPurchaseHistory::class,'product_id','id')->whereIn('status',[1,2]);
    }

    public function opennftpurchasehistory(){
        return $this->hasMany(NftPurchaseHistory::class,'product_id','id')->whereIn('status',[1,2])->where('type',1);
    }

    public function images()
    {
        return $this->hasMany(NftProductImage::class,'product_id','id');
    }

    public function getImageAttribute($value){
        if(file_exists(public_path('uploads/nft-product/'.$value)) && $value){
            return asset('uploads/nft-product/'.$value);     
        }
        return '';
    }
}
