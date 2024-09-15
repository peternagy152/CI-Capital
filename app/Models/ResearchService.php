<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchService extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'header' => 'json',
        'repeated_section' => 'json',
        'thanks_page' => 'json',

    ];
}