<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'nav'=> 'json' ,
        'hero_section'=> 'json' ,
        'section_about'=> 'json' ,
        'about_repeater'=> 'json' ,
        'navigate_section'=> 'json' ,
        'navigate_steps' => 'json',

        'request_form_header' => 'json',
    ];
}
