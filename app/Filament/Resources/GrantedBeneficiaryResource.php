<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrantedBeneficiaryResource\Pages;
use App\Filament\Resources\GrantedBeneficiaryResource\RelationManagers;
use App\Models\GrantedBeneficiary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PayrollResource\RelationManagers\SeniorsRelationManager;

class GrantedBeneficiaryResource extends Resource
{
    protected static ?string $model = GrantedBeneficiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 4;
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'ongoing')->count();
        return $count > 0 ? (string)$count : null;
    }
    protected static ?string $navigationBadgeTooltip = 'On going distribution';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payroll_id')
                    ->options(function () {
                        return \App\Models\Payroll::where('status', 'approved')
                            ->pluck('note', 'id'); // 'note' is displayed, 'id' is the value
                    })
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $payroll = \App\Models\Payroll::find($state);
                        $set('note', $payroll?->note ?? null);  // Set 'note' field based on selected payroll_id
                    })
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255)
                    ->default(null)
                    ->disabledOn('edit'),  // Optionally disable the field if you want it to be read-only
                Forms\Components\Select::make('status')
                    ->options([
                        'Ongoing' => 'On going',
                        'Completed' => 'Completed',
                    ])
                    ->required(),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('note')
                    ->label('Payroll')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('F j, Y')
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Ongoing' => 'primary',
                        'Completed' => 'success',
                    })
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

   

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrantedBeneficiaries::route('/'),
            'create' => Pages\CreateGrantedBeneficiary::route('/create'),
            // 'edit' => Pages\EditGrantedBeneficiary::route('/{record}/edit'),
        ];
    }
}
