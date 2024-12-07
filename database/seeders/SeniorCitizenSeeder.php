<?php

namespace Database\Seeders;

use App\Models\SeniorCitizen;
use Illuminate\Database\Seeder;

class SeniorCitizenSeeder extends Seeder
{
    public function run()
    {
        SeniorCitizen::factory(1)->create();
    }
}
