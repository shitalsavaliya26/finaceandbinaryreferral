<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "ranks";

    protected $dates = [ 'deleted_at' ];

    public function detail() {
        return $this->belongsTo(Rank::class,'rank_name', 'id');
    }
}
