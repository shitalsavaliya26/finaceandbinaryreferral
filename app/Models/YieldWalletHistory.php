<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YieldWalletHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount','actual_commission_amount', 'description','description_cn','type','user_id','final_amount','created_at','updated_at','stacking_pool_id','unique_no','percent'];

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    protected $appends = ['createdDate'];

    public function getCreatedDateAttribute(){
        return date('d-M-Y H:i:s',strtotime($this->created_at));
    }

    public function stacking_pool(){
        return $this->hasOne(StackingPool::class,'id','stacking_pool_id');
    }


    public function getDescriptionAttribute($value){
        if(app()->getLocale() == "cn"){
            return $this->description_cn;
        }
        return $value;
    }
}
