<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $table = "withdrawal_requests";

    protected $dates = ['created_at', 'updated_at', 'action_date'];
    
    public function getCreatedDateAttribute(){
        return date('d-M-Y H:i:s',strtotime($this->created_at));
    }

    public function getActionDateAttribute($value){
        return date('d-M-Y H:i:s',strtotime($value));
    }
    
    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
