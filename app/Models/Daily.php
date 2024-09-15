<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    public function Source(){
        return $this->belongsToMany(Source::class, 'daily_source');
    }

    public function Company(){
        return $this->belongsTo(Company::class);
    }
}
