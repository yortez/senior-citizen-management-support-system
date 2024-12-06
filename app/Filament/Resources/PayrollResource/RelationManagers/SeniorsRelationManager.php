<?php

namespace App\Filament\Resources\PayrollResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
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
                Tables\Columns\TextColumn::make('extension'),
                Tables\Columns\TextColumn::make('age'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('birthday'),
                Tables\Columns\TextColumn::make('barangay.name'),
                Tables\Columns\IconColumn::make('claim_status')
                    ->label('Incentive Status')
                    ->boolean()
                    ->action(function($record, $column){
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

                ]),
            ]);
    }
  
   
}
