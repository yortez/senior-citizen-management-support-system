<?php

namespace App\Filament\Resources\SeniorCitizenResource\Pages;

use App\Filament\Resources\SeniorCitizenResource;
use App\Filament\Resources\SeniorCitizenResource\Widgets\SeniorsCountOverview;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;


class ListSeniorCitizens extends ListRecords
{
    protected static string $resource = SeniorCitizenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make(),


        ];
    }
    public function getTabs(): array
    {
        return [
            'Active' => Tab::make()->query(fn($query) => $query->where('is_active', true)),
            'Deceased' => Tab::make()->query(fn($query) => $query->where('is_active', false)),
            null => Tab::make('All'),

        ];
    }
}
