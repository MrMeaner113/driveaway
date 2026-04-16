<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VehicleCategorySeeder::class,
            TransportPlateRateSeeder::class,
            InsuranceRateSeeder::class,
            TravelModeSeeder::class,
            DiscountReasonSeeder::class,
        ]);
    }
}
