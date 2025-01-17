<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barangay;
use App\Models\Benefit;
use App\Models\Purok;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $barangays = [
            'Assumption (Bulol)',
            'Avanceña (Barrio 3)',
            'Cacub',
            'Caloocan',
            'Carpenter Hill',
            'Concepcion (Barrio 6)',
            'Esperanza',
            'Mabini',
            'Magsaysay',
            'Mambucal',
            'Morales',
            'Namnama',
            'Paraiso',
            'Rotonda',
            'San Isidro',
            'San Jose (Barrio 5)',
            'New Pangasinan (Barrio 4)',
            'San Roque',
            'Santa Cruz',
            'Santo Niño (Barrio 2)',
            'Saravia (Barrio 8)',
            'Topland (Barrio 7)',
            'Zone 1 (Poblacion)',
            'Zone 2 (Poblacion)',
            'Zone 3 (Poblacion)',
            'Zone 4 (Poblacion)',
            'General Paulino Santos (Barrio 1)',
        ];

        // foreach ($barangays as $barangay) {
        //     $createdBarangay = Barangay::create(['name' => $barangay]);

        //     // Create Purok 1 for each barangay
        //     Purok::create([
        //         'name' => 'Purok 1',
        //         'barangay_id' => $createdBarangay->id
        //     ]);
        // }

        $benefits = [
            'Social Pension' => [
                'description' => '-60 above
                -Quarterly payout
                -Data base sa system ni region
                -Indigent senior citizen without SSS, GSIS PVAO or any benefits from government',
                'min_age' => 60,
                'max_age' => 100,
                'amount' => 500
            ],
            'Cash Incentive A' => [
                'description' => '- Once lang maka recieved every bracket
                85-90 (10k)',
                'min_age' => 85,
                'max_age' => 90,
                'amount' => 10000
            ],
            'Cash Incentive B' => [
                'description' => '- Once lang maka recieved every bracket
                91-95 (15k)',
                'min_age' => 91,
                'max_age' => 95,
                'amount' => 15000
            ],
            'Cash Incentive C' => [
                'description' => '- Once lang maka recieved every bracket
                96-99 (20k)',
                'min_age' => 96,
                'max_age' => 99,
                'amount' => 20000
            ],
            'Birthday Cash Gift' => [
                'description' => '-once a year depende sa budget
-60 to 84 years old
- priority age is 84 pababa hanggang maka abot ng 60',
                'min_age' => 0,
                'max_age' => 0,
                'amount' => 5000
            ],
            'Centenarian' => [
                'description' => '- 100 years old
Incentive they will recieve is
20k from City government
20k from Provincial government
100k from DSWD XII',
                'min_age' => 100,
                'max_age' => 0,
                'amount' => 140000
            ],
        ];

        foreach ($benefits as $name => $data) {
            Benefit::create([
                'name' => $name,
                'description' => $data['description'],
                'min_age' => $data['min_age'],
                'max_age' => $data['max_age'],
                'amount' => $data['amount']
            ]);
        }
    }
}
