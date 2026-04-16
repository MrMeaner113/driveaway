<?php

namespace Database\Seeders;

use App\Models\TransportPlateRate;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class TransportPlateRateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            'Standard'   => 1500,
            'High Value' => 3500,
            'Specialty'  => 7500,
        ];

        foreach ($rates as $categoryName => $dailyRate) {
            $category = VehicleCategory::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            TransportPlateRate::firstOrCreate(
                ['vehicle_category_id' => $category->id],
                [
                    'daily_rate'     => $dailyRate,
                    'effective_date' => now()->toDateString(),
                ],
            );
        }
    }
}
