<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralCommission extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount', 'description','description_cn','status','user_id','from_user_id','stacking_pool_id','percent','actual_percent','percent','actual_commission_amount'];

    public function user_detail(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function from_user_detail(){
        return $this->hasOne('App\Models\User','id','from_user_id');
    }

    public function staking_pool(){
        return $this->hasOne('App\Models\StackingPool','id','stacking_pool_id');
    }

    public function getDescriptionAttribute($value){
        if(app()->getLocale() == "cn"){
            return $this->description_cn;
        }
        return $value;
    }
}
