<?php

namespace App\Filament\Resources\SeniorCitizenResource\Pages;

use App\Filament\Resources\SeniorCitizenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeniorCitizen extends EditRecord
{
    protected static string $resource = SeniorCitizenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
