<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $guarded = [] ;

     public function Daily(){
         return $this->belongsToMany(Daily::class, 'daily_source');
    }
}
