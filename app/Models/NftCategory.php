<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NftCategory extends Model
{
    use HasFactory;
    protected $table = "nft_categories";
    protected $fillable = ['is_deleted'];

    public function getImageAttribute($value){
        if(file_exists(public_path('uploads/nft-category/'.$value)) && $value){
            return asset('uploads/nft-category/'.$value);     
        }
        return '';
    }
    public function product(){
        $instance =$this->hasMany(NftProduct::class,'category_id');
        $instance->getQuery()->where(['status' => 'active', 'is_deleted' => '0']);
        // return $this->hasMany(NftProduct::class,'category_id');
        return $instance;
    }
}
