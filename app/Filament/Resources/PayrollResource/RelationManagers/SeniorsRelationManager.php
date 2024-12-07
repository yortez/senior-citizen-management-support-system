<?php

namespace App\Filament\Resources\PayrollResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;


class SeniorsRelationManager extends RelationManager
{
    protected static string $relationship = 'seniors';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'Unclaimed' => 'Unclaimed',
                        'Claimed' => 'Claimed',
                    ])
                    ->default('Unclaimed')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')

            ->columns([
                Tables\Columns\TextColumn::make('osca_id'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('middle_name'),
                Tables\Columns\TextColumn::make('age'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('birthday'),
                Tables\Columns\TextColumn::make('barangay.name'),
                Tables\Columns\SelectColumn::make('claim_status')
                    ->label('Incentive Status')
                    ->options([
                        'Unclaimed' => 'Unclaimed',
                        'Claimed' => 'Claimed',
                    ])
                    ->default('Unclaimed')
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    }),
                // Tables\Columns\TextColumn::make('payrolls.note')->label('Benefit Type'),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()->multiple(),
                ExportAction::make()->exports([
                    ExcelExport::make()->fromTable()
                ]),


            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('updateClaimStatus')
                        ->label('Update Claim Status')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('claim_status')
                                ->label('Claim Status')
                                ->options([
                                    'Unclaimed' => 'Unclaimed',
                                    'Claimed' => 'Claimed',
                                ])
                                ->default('Unclaimed')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['claim_status' => $data['claim_status']]);
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Claim Status Updated')
                                ->body('The claim status has been updated for the selected seniors.')
                        ),
                ]),
            ]);
    }
}
