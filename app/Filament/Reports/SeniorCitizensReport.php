<?php

namespace App\Filament\Reports;

use App\Models\SeniorCitizen;
use App\Models\User;
use EightyNine\Reports\Components\Image;
use EightyNine\Reports\Components\Text;
use EightyNine\Reports\Components\VerticalSpace;
use EightyNine\Reports\Report;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use Filament\Forms\Form;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Carbon\Carbon;


class SeniorCitizensReport extends Report
{
    //    public ?string $heading = "Report";

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        $imagePath = asset('img/fr-logo.png');
        return $header
            ->schema([
                Header\Layout\HeaderRow::make()
                    ->schema([
                        Header\Layout\HeaderColumn::make()
                            ->schema([
                                Image::make($imagePath)
                                    ->width9Xl(),
                            ])->alignLeft(),
                        Header\Layout\HeaderColumn::make()
                            ->schema([
                                Text::make("Senior Citizens Report")
                                    ->title()
                                    ->primary(),
                                Text::make("Master list")
                                    ->subtitle(),
                                Text::make("Generated on: " . now()->format("d/m/Y H:i:s"))
                                    ->subtitle(),
                            ])->alignRight()
                    ]),
            ]);
    }

    public function body(Body $body): Body
    {
        return $body
            ->schema([
                Body\Layout\BodyColumn::make()
                    ->schema([

                        VerticalSpace::make(),
                        Text::make("Verified Senior Citizens")
                            ->fontXl()
                            ->fontBold()
                            ->primary(),
                        Text::make("This is a list of verified Senior CItizens in Koronadal City")
                            ->fontSm()
                            ->secondary(),
                        Body\Table::make()
                            ->columns([
                                Body\TextColumn::make("osca_id")
                                    ->label("OSCA id"),
                                Body\TextColumn::make("full_name")
                                    ->label("Name"),
                                Body\TextColumn::make("age")
                                    ->label("Age"),

                            ])
                            ->data(
                                function (?array $filters) {

                                    return SeniorCitizen::query()

                                        ->select(
                                            "osca_id",
                                            "full_name",
                                            "age",
                                            "gender",
                                            "civil_status",
                                            "religion",
                                            "birth_place"
                                        )
                                        ->take(10)
                                        ->get();
                                }
                            ),
                    ]),
            ]);
    }

    public
    function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([]);
    }

    public
    function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                DateRangePicker::make("registration_date")
                    ->label("Registration date")
                    ->placeholder("Select a date range"),
                DateRangePicker::make("verification_date")
                    ->label("Verification date")
                    ->placeholder("Select a date range"),
            ]);
    }
}
