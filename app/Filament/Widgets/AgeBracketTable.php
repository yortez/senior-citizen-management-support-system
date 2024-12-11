<?php

namespace App\Filament\Widgets;

use App\Models\SeniorCitizen;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AgeBracketTable extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                SeniorCitizen::query()
                    ->select(
                        DB::raw('CASE
                            WHEN age >= 60 AND age < 70 THEN "60-69"
                            WHEN age >= 70 AND age < 80 THEN "70-79"
                            WHEN age >= 80 AND age < 90 THEN "80-89"
                            ELSE "90+"
                        END AS age_group'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy('age_group')
            )
            ->columns([
                Tables\Columns\TextColumn::make('age_group')
                    ->label('Age Bracket'),
                Tables\Columns\TextColumn::make('count')
                    ->label('Number of Senior Citizens')
                    ->sortable(),
            ])
            ->defaultSort('age_group')
            ->recordUrl(null)
            ->paginated(false);
    }

    public function getTableRecordKey(Model $record): string
    {
        return $record->age_group;
    }
}
