<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SeniorCitizen;
use App\Models\Payroll;
use App\Models\GrantedBeneficiary;

class TotalSenior extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Senior Citizens in Koronadal City', SeniorCitizen::query()->count()),
            Stat::make('Payroll for Approval', Payroll::query()->where('status', 'Pending')->count()),
            Stat::make('On going distribution of Payroll', GrantedBeneficiary::query()->where('status', 'ongoing')->count()),
            
        ];
    }
}
