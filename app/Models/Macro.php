<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Macro extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Company(){
        return $this->hasMany(Company::class);
    }
    public function MacroData(){
        return $this->hasMany(MacroData::class);
    }

    public function MacroDaily(){
        return $this->hasMany(MacroDaily::class);
    }

     public function MacroPublication(){
        return $this->hasMany(MacroPublication::class);
    }
    public function Analyst(){
        return $this->belongsToMany(Analyst::class , 'analysts_macros');
    }

}
