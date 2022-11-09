<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StackingPool extends Model
{
    use HasFactory;
    protected $table = "stacking_pools";

    protected $fillable = [
        'user_id',
        'stacking_pool_package_id',
        'amount',
        'percent',
        'stacking_period',
        'range',
        'commission',
        'start_date',
        'end_date',
        'signature',
        'created_at',
        'updated_at'
    ];
    protected $appends = ['start_date_week','end_date_week'];

    public function user_detail(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function staking_pool_package(){
        return $this->hasOne('App\Models\StackingPoolPackage','id','stacking_pool_package_id');
    }

    public function getEndDateWeekAttribute(){
        if($this->start_date){
            if($this->stacking_period == '24'){
                $weekday = Carbon::createFromFormat('Y-m-d',$this->start_date)->setTimeFromTimeString('00:00:00')->addDays(738);
            }else{
                $weekday = Carbon::createFromFormat('Y-m-d',$this->start_date)->setTimeFromTimeString('00:00:00')->addDays(373);
            }
            return $weekday;
        }
        return Carbon::now();
    }

    public function getStartDateWeekAttribute(){
        if($this->start_date){
            if($this->stacking_period == '24'){
                $weekday = Carbon::createFromFormat('Y-m-d',$this->start_date)->setTimeFromTimeString('00:00:00')->addDays(730);
            }else{
                $weekday = Carbon::createFromFormat('Y-m-d',$this->start_date)->setTimeFromTimeString('00:00:00')->addDays(365);
            }
            return $weekday;
        }
        return Carbon::now();
        
    }
}
