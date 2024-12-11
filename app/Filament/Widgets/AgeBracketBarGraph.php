<?php

namespace App\Filament\Widgets;

use App\Models\SeniorCitizen;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AgeBracketBarGraph extends ChartWidget
{
    protected static ?string $heading = 'Senior Citizens by Age Bracket';

    protected function getData(): array
    {
        $data = SeniorCitizen::select(
            DB::raw('CASE
                WHEN age >= 60 AND age < 70 THEN "60-69"
                WHEN age >= 70 AND age < 80 THEN "70-79"
                WHEN age >= 80 AND age < 90 THEN "80-89"
                ELSE "90+"
            END AS age_group'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Senior Citizens',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => ['#36A2EB', '#FF6384', '#4BC0C0', '#FF9F40'],
                ],
            ],
            'labels' => $data->pluck('age_group')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
