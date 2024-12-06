<?php

namespace App\Filament\Resources\GrantedBeneficiaryResource\Pages;

use App\Filament\Resources\GrantedBeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGrantedBeneficiary extends CreateRecord
{
    protected static string $resource = GrantedBeneficiaryResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
