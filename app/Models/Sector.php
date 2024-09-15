<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function Company(){
        return $this->hasMany(Company::class);
    }
    public function Analyst()
    {
        return $this->belongsToMany(Analyst::class , "analysts_sectors");
    }
}
