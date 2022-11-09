<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StackingPoolCoin extends Model
{
    use HasFactory;

    protected $table = "stacking_pools_coins";

    public function stacking_pool_package(){
        return $this->hasOne('App\Models\StackingPoolPackage','id','stacking_pool_package_id');
    }

    public function getIconAttribute($value){
        if(file_exists(public_path('uploads/package_coin/'.$value)) && $value){
            return asset('uploads/package_coin/'.$value);     
        }
        return '';
    }

}
