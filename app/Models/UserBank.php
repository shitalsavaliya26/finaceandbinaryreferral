<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'branch','account_holder','account_number','swift_code','bank_country_id'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'bank_country_id', 'id');
    }
}
