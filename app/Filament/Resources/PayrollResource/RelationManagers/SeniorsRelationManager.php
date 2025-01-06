<?php

namespace App\Filament\Resources\PayrollResource\RelationManagers;

use App\Models\Benefit;
use App\Models\SeniorCitizen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Carbon\Carbon;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Barangay;


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
                Tables\Columns\SelectColumn::make('status')
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
                SelectFilter::make('barangay')
                    ->label('Barangay')
                    ->options(Barangay::pluck('name', 'id'))
                    ->attribute('barangay_id')
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()->multiple(),
                ExportAction::make()->exports([
                    ExcelExport::make()->fromTable()
                ]),
                Tables\Actions\Action::make('attachEligibleSeniors')
                    ->label('Attach Eligible Seniors')
                    ->icon('heroicon-o-user-group')
                    ->action(function () {
                        $payroll = $this->getOwnerRecord();
                        $existingSeniorIds = $payroll->seniors()->pluck('senior_citizens.id');

                        $benefit = Benefit::find($payroll->benefit_id);
                        if (!$benefit) {
                            Notification::make()
                                ->danger()
                                ->title('Error')
                                ->body('No benefit found for this payroll.')
                                ->send();
                            return;
                        }

                        $minAge = $benefit->min_age;
                        $maxAge = $benefit->max_age;

                        $minDate = Carbon::now()->subYears($maxAge);
                        $maxDate = Carbon::now()->subYears($minAge);

                        $newSeniors = SeniorCitizen::whereNotIn('id', $existingSeniorIds)
                            ->where('birthday', '<=', $maxDate)
                            ->where('birthday', '>=', $minDate)
                            ->get();

                        $attachedCount = $newSeniors->count();

                        $payroll->seniors()->attach($newSeniors->pluck('id')->toArray(), ['status' => 'Unclaimed']);

                        Notification::make()
                            ->success()
                            ->title('Eligible Seniors Attached')
                            ->body("{$attachedCount} eligible senior citizens have been attached to this payroll.")
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Attach Eligible Seniors')
                    ->modalDescription('Are you sure you want to attach all eligible senior citizens to this payroll?')
                    ->modalSubmitActionLabel('Yes, Attach Eligible Seniors'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->action(function (Collection $records) {
                            $payroll = $this->getOwnerRecord();
                            $detachedCount = $records->count();

                            $payroll->seniors()->detach($records->pluck('id'));

                            Notification::make()
                                ->success()
                                ->title('Seniors Detached')
                                ->body("{$detachedCount} senior citizens have been detached from this payroll.")
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('updateClaimStatus')
                        ->label('Update Claim Status')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Claim Status')
                                ->options([
                                    'Unclaimed' => 'Unclaimed',
                                    'Claimed' => 'Claimed',
                                ])
                                ->default('Unclaimed')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $payrollId = $this->getOwnerRecord()->id;

                            DB::table('payroll_senior_citizen')
                                ->where('payroll_id', $payrollId)
                                ->whereIn('senior_citizen_id', $records->pluck('id'))
                                ->update(['status' => $data['status']]);
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
