<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'aml_policy_statement', 'risk_disclosure_statement','user_agreement','poa','user_signature','date_of_registration'
    ];
}
