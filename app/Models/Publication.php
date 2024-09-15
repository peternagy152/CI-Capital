<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function Company(){
        return $this->belongsToMany(Company::class , "company_publication");
    }

    public function Analyst(){
        return $this->belongsToMany(Analyst::class , "publications_analysts");
    }

    public function User(){
        return $this->belongsToMany(User::class, "publications_users");
    }
}
