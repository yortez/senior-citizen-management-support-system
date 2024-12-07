<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers\SeniorsRelationManager;
use App\Models\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;



class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 3;
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'Pending')->count();
        return $count > 0 ? (string)$count : null;
    }
    protected static ?string $navigationBadgeTooltip = 'The number pending for approval';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('benefit_id')
                            ->relationship('benefit', 'name')
                            ->required()
                            ->reactive() // Make it reactive to listen for changes
                            ->afterStateUpdated(function (callable $set, $state) {
                                // Fetch the benefit name and set it to the 'note' field
                                $benefit = \App\Models\Benefit::find($state);
                                $set('note', $benefit ? $benefit->name : null);
                            }),
                        Forms\Components\TextInput::make('note')
                            ->disabled()
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Approved' => 'Approved',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Pending')
                            ->required(),
                    ])->columns(3),

            ]);
    }


    public static function getRelations(): array
    {
        return [
            SeniorsRelationManager::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('F j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('benefit.name')
                    ->label('Benefit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('benefit.amount')
                    ->label('Amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'Pending' => 'warning',
                        'Approved' => 'success',
                        'Rejected' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('seniors.full_name')
                    ->label('Senior Citizens')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Date Approved')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('edit'),
                ])
            ])
            ->bulkActions([]);
    }




    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
            'view' => Pages\ViewPayroll::route('/{record}'),

        ];
    }
}
