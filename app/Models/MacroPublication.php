<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroPublication extends Model
{
    use HasFactory;
    protected $guarded = [] ;
    public function Analyst(){
        return $this->belongsToMany(Analyst::class , "macro_publications_analysts");
    }

    public function Macro(){
        return $this->belongsTo(Macro::class);
    }

    public function User(){
        return $this->belongsToMany(User::class, "macro_publications_users");
    }


}
