<?php

namespace App\Filament\Widgets;

use App\Models\Macro;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Company;
use App\Models\Source;
use App\Models\Daily;

class AStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(" Macros" , Macro::count())
                ->description("Total Number Of Macros")
                ->descriptionIcon("heroicon-o-globe-europe-africa" , IconPosition::Before)
                ->color("danger")
                ->chart([15,23,48,2,91,76,34,27,64]) ,

            Stat::make("Companies" , Company::count())
            ->description("Total Number Of Companies ")
            ->descriptionIcon("heroicon-o-building-office" , IconPosition::Before)
            ->chart([32,58,14,87,45,99,11,50,78])
               ->color("success") ,

             Stat::make("Users " , User::count())
                 ->description("Total Number Of Users ")
                 ->descriptionIcon("heroicon-o-user-group" , IconPosition::Before)
                 ->color("info")
            ->chart([9,41,60,13,35,70,22,88,94]) ,

              Stat::make("Sources " , Source::count())
            ->description("Total Number Of Sources")
            ->descriptionIcon("heroicon-o-megaphone" , IconPosition::Before )
                  ->color("warning")
            ->chart([1,3,45,6,3,4,60,6,8,84,58,21,43,44]) ,


        ];
    }
}
