<?php

namespace App\Filament\Resources\SeniorCitizenResource\Pages;

use App\Filament\Resources\SeniorCitizenResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Filament\Notifications\Notification;

class CreateSeniorCitizen extends CreateRecord
{
    protected static string $resource = SeniorCitizenResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
{
    return [
        $this->getCreateFormAction()
            ->formId('form'),
            $this->getCancelFormAction()
            ->formId('form'),
    ];
}

}
