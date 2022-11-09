<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = "sliders";
    public function getImageAttribute($value){
        if(file_exists(public_path('uploads/slider/'.$value)) && $value){
            return asset('uploads/slider/'.$value);     
        }
        return '';
    }

    public function getMobileImageAttribute($value){
        if(file_exists(public_path('uploads/slider/'.$value)) && $value){
            return asset('uploads/slider/'.$value);     
        }
        return '';
    }
}

