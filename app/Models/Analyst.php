<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analyst extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function LikedByUser(){
        return $this->belongsToMany(User::class , "analysts_user");
    }


    public function Publication(){
          return $this->belongsToMany(Publication::class , "publications_analysts") ;
    }

     public function MacroPublication(){
        return $this->belongsToMany(MacroPublication::class , "macro_publications_analysts") ;
    }
     public function Company(){
        return $this->belongsToMany(Company::class , "companies_analysts") ;
    }

    public function Macro()
    {
        return $this->belongsToMany(Macro::class , "analysts_macros") ;
    }
    public function Sector()
    {
        return $this->belongsToMany(Sector::class , "analysts_sectors");
    }
}
