<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionWalletHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount', 'description','description_cn','type','user_id','final_amount','from_user_id','commission_type','created_at','updated_at'];

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    protected $appends = ['createdDate'];

    public function getCreatedDateAttribute(){
        return date('d-M-Y H:i:s',strtotime($this->created_at));
    }

    public function getDescriptionAttribute($value){
        if(app()->getLocale() == "cn"){
            return $this->description_cn;
        }
        return $value;
    }
}
