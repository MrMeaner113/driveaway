<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleMakeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $makes = [
            'Chevrolet', 'Ford', 'GMC', 'Honda', 'Hyundai',
            'Jeep', 'Kia', 'Lexus', 'Mazda', 'Nissan',
            'Ram', 'Subaru', 'Tesla', 'Toyota', 'Volkswagen',
        ];

        foreach ($makes as $make) {
            DB::table('vehicle_makes')->insert([
                'name'       => $make,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}