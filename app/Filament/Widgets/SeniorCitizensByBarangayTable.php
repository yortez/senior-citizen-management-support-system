<?php

namespace App\Filament\Widgets;

use App\Models\SeniorCitizen;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SeniorCitizensByBarangayTable extends BaseWidget
{

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SeniorCitizen::query()
                    ->select('barangay_id', DB::raw('COUNT(*) as count'))
                    ->groupBy('barangay_id')
            )
            ->columns([
                Tables\Columns\TextColumn::make('barangay.name')
                    ->label('Barangay')
                    ->sortable(),
                Tables\Columns\TextColumn::make('count')
                    ->label('Number of Senior Citizens')
                    ->sortable(),
            ])
            ->defaultSort('count', 'desc')
            ->recordUrl(null)
            ->paginated(false);
    }

    public function getTableRecordKey(Model $record): string
    {
        return $record->barangay;
    }
}
