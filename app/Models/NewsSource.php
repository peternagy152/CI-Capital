<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsSource extends Model
{
    use HasFactory;
    protected $guarded = [] ;

     public function Daily(){
        return $this->hasMany(Daily::class);
    }
    public function MacroDaily(){
        return $this->hasMany(MacroDaily::class);
    }


}
