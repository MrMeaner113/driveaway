<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $fuelTypes = [
            ['name' => 'Regular Unleaded',  'code' => 'REG'],
            ['name' => 'Midgrade Unleaded', 'code' => 'MID'],
            ['name' => 'Premium Unleaded',  'code' => 'PREM'],
            ['name' => 'Diesel',            'code' => 'DSL'],
            ['name' => 'Electric',          'code' => 'EV'],
            ['name' => 'Hybrid',            'code' => 'HYB'],
            ['name' => 'Plug-in Hybrid',    'code' => 'PHEV'],
            ['name' => 'Hydrogen',          'code' => 'H2'],
        ];

        foreach ($fuelTypes as $type) {
            DB::table('fuel_types')->insert(array_merge($type, [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}