<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SeniorsByBarangay extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Number of Seniors',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89,0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89, 55, 89, 77],
                ],
            ],
            'labels' => ['Assumption', 'Avanceña', 'Cacub', 'Caloocan', 'Carpenter Hill', 'Conception', 'Esperanza',
             'Mabini', 'Magsaysay', 'Mambucal', 'Morales', 'Namnama','Paraiso', 'Rotonda', 'San Isidro', 'San Jose',
             'New Pangasinan', 'San Roque', 'Santa Cruz', 'Santo Niño', 'Saravia', 'Topland', 'Zone 1', 'Zone 2', 
             'Zone 3', 'Zone 4', 'General Paulino Santos'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
