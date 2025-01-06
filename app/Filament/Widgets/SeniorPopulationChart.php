<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SeniorCitizen;
use Illuminate\Support\Facades\DB;

class SeniorPopulationChart extends ChartWidget
{
    protected static ?string $heading = 'Registered Senior Citizens';


    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = SeniorCitizen::select(
            DB::raw('strftime("%Y", created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $years = $data->pluck('year');
        $counts = $data->pluck('count');

        return [
            'datasets' => [
                [
                    'label' => 'Registered Seniors',
                    'data' => $counts,
                    'fill' => 'start',
                ],
            ],
            'labels' => $years,
        ];
    }
}
