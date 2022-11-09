<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StackingPoolPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_deleted','name','price','icon','symbol','chain','address'
    ];

    public function stackingpoolcoins(){
        return $this->hasMany('App\Models\StackingPoolCoin','stacking_pool_package_id');
    }

    public function getImageAttribute($value){
        if(file_exists(public_path('uploads/pool-package/'.$value)) && $value){
            return asset('uploads/pool-package/'.$value);     
        }
        return '';
    }

    public function getSymbolAttribute($value){
        if(file_exists(public_path('uploads/pool-package-symbol/'.$value)) && $value){
            return asset('uploads/pool-package-symbol/'.$value);     
        }
        return '';
    }
}
