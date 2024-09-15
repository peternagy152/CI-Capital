<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'header' => 'json',
        'primary_header' => 'json',
        'contact_info' => 'json',
        'faqs_header' => 'json',
        'faqs' => 'json',
        'theme_settings_1' => 'json',
        'theme_settings_2' => 'json',
        'theme_settings_3' => 'json',
    ];
}
