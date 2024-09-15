<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroData extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function Macro(){
       return $this->belongsTo(Macro::class);
    }

}