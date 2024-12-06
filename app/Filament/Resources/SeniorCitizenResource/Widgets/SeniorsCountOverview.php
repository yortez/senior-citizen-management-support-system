<?php

namespace App\Filament\Resources\SeniorCitizenResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SeniorCitizen;

class SeniorsCountOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Seniors', SeniorCitizen::query()->count()),
            Stat::make('Male', SeniorCitizen::query()->where('gender', 'M')->count()),
            Stat::make('Female', SeniorCitizen::query()->where('gender', 'F')->count()),
        ];
    }
}
