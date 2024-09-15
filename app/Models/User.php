<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles ;
use Laravel\Passport\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;


class User extends Authenticatable  implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'title',
        'company_name',
        'user_role' ,
        'is_activated' ,
        "profile_pic"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_activated' => 'boolean',
    ];

    public function Analyst()
    {
        return $this->hasOne(Analyst::class, 'user_id');
    }

    public function LikeAnalyst(){
        return $this->belongsToMany(Analyst::class , "analysts_users");
    }

    public function Company(){
        return $this->belongsToMany(Company::class , "companies_users");
    }

    public function Publication()
    {
        return $this->belongsToMany(Publication::class , "publications_users");
    }
    public function MacroPublication()
    {
        return $this->belongsToMany(MacroPublication::class , "macro_publications_users");
    }

    public function ServiceInquiry(){
        return $this->hasMany(ServiceInquiry::class) ;
    }




    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }
}
