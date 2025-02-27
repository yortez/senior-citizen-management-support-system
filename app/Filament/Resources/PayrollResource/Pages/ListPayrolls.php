<?php

namespace App\Filament\Resources\PayrollResource\Pages;

use App\Filament\Resources\PayrollResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use Filament\Tables\Columns\Column;

class ListPayrolls extends ListRecords
{
    protected static string $resource = PayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()->exports([
                ExcelExport::make()->fromTable()
            ]),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Pending' => Tab::make()->query(fn($query) => $query->where('status', 'Pending')),
            'Completed' => Tab::make()->query(fn($query) => $query->where('status', 'completed')),
            null => Tab::make('All'),

        ];
    }
}
