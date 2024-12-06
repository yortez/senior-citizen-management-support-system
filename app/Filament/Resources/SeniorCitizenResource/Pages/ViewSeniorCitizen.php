<?php

namespace App\Filament\Resources\SeniorCitizenResource\Pages;

use App\Filament\Resources\SeniorCitizenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSeniorCitizen extends ViewRecord
{
    protected static string $resource = SeniorCitizenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
