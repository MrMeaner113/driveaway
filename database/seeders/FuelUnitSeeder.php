<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FuelUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Litres',  'abbreviation' => 'L',   'sort_order' => 1],
            ['name' => 'Gallons', 'abbreviation' => 'gal', 'sort_order' => 2],
        ];

        foreach ($units as $unit) {
            DB::table('fuel_units')->insertOrIgnore([
                'name'         => $unit['name'],
                'slug'         => Str::slug($unit['name']),
                'abbreviation' => $unit['abbreviation'],
                'is_active'    => true,
                'sort_order'   => $unit['sort_order'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}