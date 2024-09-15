<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Analyst;
use App\Models\Company;
use App\Models\Daily;
use App\Models\Event;
use App\Models\Macro;
use App\Models\MacroDaily;
use App\Models\MacroPublication;
use App\Models\Publication;
use App\Models\Sector;
use App\Models\Source;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//
//        //Roles
//        Role::create(['name' => 'client']);
//        Role::create(['name' => 'analyst']);
//        Role::create(['name' => 'admin']);
//
//        //Users
//        $user = User::create([
//            'name' => "Superadmin" ,
//            'email' => "peter.nagy@mitchdesigns.com",
//            'password' => Hash::make("ci_capital") ,
//            'mobile'     => "01227165958" ,
//            'title'     => "Web Development",
//            'company_name'     => "MD" ,
//        ]);
//        $user->assignRole('admin');
//
//        //Types
//        Type::create(["name" => "Bank"]);
//        Type::create(["name" => "Company"]);

        //Daily
//        Daily::factory(50)->create() ;
//        MacroDaily::factory(50)->create() ;
//        Event::factory(80)->create() ;
//        //Publications
//        Publication::factory(20)->has(Analyst::factory())->create() ;
//        MacroPublication::factory(20)->has(Analyst::factory())->create() ;

    }
}
