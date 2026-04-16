<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Standard',   'description' => 'Standard passenger vehicles'],
            ['name' => 'High Value', 'description' => 'Luxury, exotic, or high-value vehicles'],
            ['name' => 'Specialty',  'description' => 'Oversized, classic, or specialty vehicles'],
        ];

        foreach ($categories as $category) {
            VehicleCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']],
            );
        }
    }
}
