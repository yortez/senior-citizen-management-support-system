<?php

namespace App\Filament\Reports;

use EightyNine\Reports\Report;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Text;
use Filament\Forms\Form;

class PayrollReport extends Report
{
    public ?string $heading = "Report";

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                Header\Layout\HeaderRow::make()
            ->schema([
                Header\Layout\HeaderColumn::make()
                    ->schema([
                        Text::make("Payroll report")
                            ->title()
                            ->primary(),
                        Text::make("Payrolls")
                            ->subtitle(),
                    ]),
                Header\Layout\HeaderColumn::make()
                    ->schema([
                        // Image::make($imagePath),
                    ])
                    ->alignRight(),
            ]),
            ]);
    }


    public function body(Body $body): Body
    {
        return $body
            ->schema([
                // ...
            ]);
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                // ...
            ]);
    }

    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                // ...
            ]);
    }
}
