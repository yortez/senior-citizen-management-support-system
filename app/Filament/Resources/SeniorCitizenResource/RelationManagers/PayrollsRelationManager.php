<?php

namespace App\Filament\Resources\SeniorCitizenResource\RelationManagers;


use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollsRelationManager extends RelationManager
{
    protected static string $relationship = 'payrolls';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payroll_id')
            ->heading('Payrolls History')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->date('F j, Y'),
                Tables\Columns\TextColumn::make('benefit.name')
                    ->label('Benefit Type'),
                Tables\Columns\TextColumn::make('benefit.amount')
                    ->label('Amount')
                    ->money('Php'),

            ])
            ->filters([
                //
            ]);
    }
}
