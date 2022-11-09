<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsdtAddress extends Model
{
    use HasFactory;

    Protected $fillable = ['name','value','image'];

    public function getImageAttribute($value)
    {
        if($value!='' && file_exists(public_path('uploads/qr_image/'.$value))){
            return asset('uploads/qr_image/'.$value);
        }
    }
}
