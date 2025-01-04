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

class GrantedBeneficiaryResource extends Resource
{
    protected static ?string $model = GrantedBeneficiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrantedBeneficiaries::route('/'),
            'create' => Pages\CreateGrantedBeneficiary::route('/create'),
            'edit' => Pages\EditGrantedBeneficiary::route('/{record}/edit'),
        ];
    }
}
