<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "news";
    protected $dates = [ 'deleted_at' ];

    public function getImageAttribute($value){
        if(file_exists(public_path('uploads/news/'.$value)) && $value){
            return asset('uploads/news/'.$value);     
        }
        return '';
    }
}
