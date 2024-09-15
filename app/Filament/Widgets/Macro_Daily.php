<?php

namespace App\Filament\Widgets;

use App\Models\MacroDaily;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class Macro_Daily extends ChartWidget
{
    protected static ?string $heading = 'Macro Daily';

    protected function getData(): array
    {
        $data = Trend::model(MacroDaily::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Macro Daily',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
