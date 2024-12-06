<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeniorCitizenResource\Pages;
use App\Filament\Resources\SeniorCitizenResource\RelationManagers;
use App\Models\SeniorCitizen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Infolists;
use Filament\Infolists\Infolist;


class SeniorCitizenResource extends Resource
{
    protected static ?string $model = SeniorCitizen::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 0;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static ?string $navigationBadgeTooltip = 'The number of seniors';
    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Personal Information')
                        ->description('')
                        ->schema([
                            Forms\Components\TextInput::make('osca_id')
                                ->unique(ignoreRecord: true)
                                ->numeric(),
                            Forms\Components\TextInput::make('last_name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('first_name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('middle_name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('extension')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('birthday')
                                ->required()
                                ->native(false)
                                ->reactive() // To listen for changes
                                ->afterStateUpdated(function ($set, $state) {
                                    // Automatically compute the age based on the selected birthday
                                    $age = Carbon::parse($state)->age;  // Compute the age using Carbon
                                    $set('age', $age);  // Set the computed age in the 'age' field
                                }),
                            Forms\Components\TextInput::make('age')

                                ->required(),
                            Forms\Components\Select::make('gender')
                                ->options([
                                    'M' => 'Male',
                                    'F' => 'Female'
                                ])
                                ->required(),
                            Forms\Components\Select::make('civil_status')
                                ->options([
                                    'single' => 'Single',
                                    'married' => 'Married',
                                    'devorced' => 'Devorced',
                                    'legally separated' => 'Legally Separated',
                                    'widowed' => 'Widowed'
                                ])
                                ->required(),
                            Forms\Components\Select::make('religion')
                                ->options([
                                    'roman catholic' => 'Roman Catholic',
                                    'islam' => 'Islam',
                                    'christian' => 'Christian',
                                    'others' => 'Other',
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('birth_place')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),
                        ])->columns(2),
                    Forms\Components\Section::make('Other Information')
                        ->description('')
                        ->schema([
                            Forms\Components\Select::make('educational_attainment')
                                ->options([
                                    'elementary graduate' => 'Elementary Graduate',
                                    'high school graduate' => 'High School Graduate',
                                    'bachelor degree' => 'Bachelor Degree',
                                    'master degree' => 'Master Degree',
                                    'doctorate degree' => 'Doctorate Degree',
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('gsis_id')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('philhealth_id')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('illness')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('disability')
                                ->required()
                                ->maxLength(255),


                        ])->columns(3),
                ])->columnSpan(2),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Address')
                        ->description('')
                        ->schema([
                            Forms\Components\Select::make('city_id')
                                ->relationship('city', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                ])

                                ->required(),
                            Forms\Components\Select::make('barangay_id')
                                ->relationship('barangay', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                ])


                                ->required(),
                            Forms\Components\Select::make('purok_id')
                                ->relationship('purok', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                ])

                                ->required(),
                        ]),
                    Forms\Components\Section::make('Status')
                        ->description('')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('registry_number_hidden', $state); // Hide registry_number when active
                                }),
                            Forms\Components\TextInput::make('registry_number')
                                ->hidden(fn($get) => $get('registry_number_hidden') ?? true) // Hide based on Toggle state
                                ->required(fn($get) => !($get('registry_number_hidden') ?? true)), // Only required when visible
                        ]),

                ])->columnSpan(1),

            ])->columns(3);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Fieldset::make('Personal Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('osca_id'),
                        Infolists\Components\TextEntry::make('full_name'),
                        Infolists\Components\TextEntry::make('age'),
                        Infolists\Components\TextEntry::make('birthday'),
                        Infolists\Components\TextEntry::make('gender'),
                        Infolists\Components\TextEntry::make('civil_status'),
                        Infolists\Components\TextEntry::make('religion'),
                        Infolists\Components\TextEntry::make('birth_place'),
                    ]),
                Infolists\Components\Fieldset::make('Address')
                    ->schema([
                        Infolists\Components\TextEntry::make('purok.name'),
                        Infolists\Components\TextEntry::make('barangay.name'),
                        Infolists\Components\TextEntry::make('city.name'),
                    ]),

                Infolists\Components\Fieldset::make('Other Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('gsis_id'),
                        Infolists\Components\TextEntry::make('philhealth_id'),
                        Infolists\Components\TextEntry::make('illness'),
                        Infolists\Components\TextEntry::make('disability'),
                        Infolists\Components\TextEntry::make('educational_attainment'),
                        Infolists\Components\TextEntry::make('status'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('first_name')
                    ->hidden()
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->hidden()
                    ->searchable(),
                Tables\Columns\TextColumn::make('extension')
                    ->hidden()
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('civil_status')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('religion')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_place')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('purok.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barangay.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->toggleable(isToggledHiddenByDefault: true)

                    ->numeric()
                    ->sortable(),


                Tables\Columns\TextColumn::make('gsis_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('philhealth_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('illness')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('disability')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('educational_attainment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'primary',
                        '0' => 'danger'
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => 'Active',
                        '0' => 'Deceased',
                    }),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make('view'),
                    Tables\Actions\EditAction::make('edit')->slideOver(),
                    Tables\Actions\DeleteAction::make('delete'),
                ])
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
            'index' => Pages\ListSeniorCitizens::route('/'),
            'create' => Pages\CreateSeniorCitizen::route('/create'),
            // 'view' => Pages\ViewSeniorCitizen::route('/{record}'),
            // 'edit' => Pages\EditSeniorCitizen::route('/{record}/edit'),
        ];
    }
}