<?php

namespace App\Filament\Widgets;

use App\Models\SeniorCitizen;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GenderTable extends BaseWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SeniorCitizen::query()
                    ->select('gender', DB::raw('COUNT(*) as count'))
                    ->groupBy('gender')
            )
            ->columns([
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
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
        return $record->gender;
    }
}
