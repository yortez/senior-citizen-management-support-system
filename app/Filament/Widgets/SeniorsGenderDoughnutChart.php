<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SeniorCitizen;
class SeniorsGenderDoughnutChart extends ChartWidget
{
    protected static ?string $heading = 'Gender';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [
                        SeniorCitizen::query()->where('gender', 'F')->count(),
                        SeniorCitizen::query()->where('gender', 'M')->count()
                        ],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                      ],
                    'borderColor' => '#9BD0F5',
                    
                ],
            ],
            'labels' => ['Female', 'Male'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
