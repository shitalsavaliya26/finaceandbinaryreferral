<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];
    protected $casts = [
        'user_id' => 'int',
        'upline_ids' => 'array',
        'direct_downline_ids' => 'array',
        'downline_ids' => 'array',
    ];

    protected $appends = ['referral'];
    protected function castAttribute($key, $value)
    {
        if (! is_null($value)) {
            return parent::castAttribute($key, $value);
        }
        switch ($this->getCastType($key)) {
            case 'int':
            case 'integer':
            return (int) 0;
            case 'real':
            case 'float':
            case 'double':
            return (float) 0;
            case 'string':
            return '';
            case 'bool':
            case 'boolean':
            return false;
            case 'object':
            case 'array':
            case 'json':
            return [];
            case 'collection':
            return new BaseCollection();
            case 'date':
            return $this->asDate('0000-00-00');
            case 'datetime':
            return $this->asDateTime('0000-00-00');
            case 'timestamp':
            return $this->asTimestamp('0000-00-00');
            default:
            return $value;
        }
    }

    public function getReferralAttribute(){
        return \App\Models\User::whereIn('id',$this->downline_ids)->where(['is_deleted'=>'0','status'=>'active'])->pluck('username')->toArray();
    }

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
