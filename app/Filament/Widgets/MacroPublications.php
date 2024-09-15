<?php

namespace App\Filament\Widgets;

use App\Models\MacroPublication;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
class MacroPublications extends ChartWidget
{
    protected static ?string $heading = 'Macro Reports';


    protected function getData(): array
    {
        $data = Trend::model(MacroPublication::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Macro Reports',
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
