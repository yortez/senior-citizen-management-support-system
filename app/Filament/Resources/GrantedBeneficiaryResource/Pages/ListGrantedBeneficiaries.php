<?php

namespace App\Filament\Resources\GrantedBeneficiaryResource\Pages;

use App\Filament\Resources\GrantedBeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrantedBeneficiaries extends ListRecords
{
    protected static string $resource = GrantedBeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
