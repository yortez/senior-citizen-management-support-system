<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barangay;
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

        foreach ($barangays as $barangay) {
            Barangay::create(['name' => $barangay]);
        }
    }
}
