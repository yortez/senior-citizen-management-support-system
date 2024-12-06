<?php

namespace App\Filament\Resources\GrantedBeneficiaryResource\Pages;

use App\Filament\Resources\GrantedBeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGrantedBeneficiary extends ViewRecord
{
    protected static string $resource = GrantedBeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
