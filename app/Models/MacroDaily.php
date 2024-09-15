<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroDaily extends Model
{
    use HasFactory;
    protected $guarded = [] ;

     public function Source(){
         return $this->belongsToMany(Source::class, 'macro_daily_source');
    }

    public function Macro(){
        return $this->belongsTo(Macro::class);
    }

}
