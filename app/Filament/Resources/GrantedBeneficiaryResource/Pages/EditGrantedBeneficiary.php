<?php

namespace App\Filament\Resources\GrantedBeneficiaryResource\Pages;

use App\Filament\Resources\GrantedBeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrantedBeneficiary extends EditRecord
{
    protected static string $resource = GrantedBeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
