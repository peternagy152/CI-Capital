<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMiner extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Company(){
        return $this->belongsTo(Company::class);
    }

}
