<?php

namespace App\Filament\Widgets;

use App\Models\SeniorCitizen;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SeniorCitizenByBarangayChart extends ChartWidget
{
    protected static ?string $heading = 'Senior Citizens by Barangay';

    protected function getData(): array
    {
        $data = SeniorCitizen::select('barangay_id', DB::raw('COUNT(*) as count'))
            ->groupBy('barangay_id')
            ->orderBy('count', 'desc')
            ->limit(10)  // Limit to top 10 barangays for better readability
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Senior Citizens',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => $this->getRandomColors(count($data)),
                ],
            ],
            'labels' => $data->pluck('barangay.name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getRandomColors(int $count): array
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $colors[] = '#' . substr(md5(mt_rand()), 0, 6);
        }
        return $colors;
    }
}
