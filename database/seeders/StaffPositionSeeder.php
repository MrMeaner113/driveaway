<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Accounting',
            'Driver',
            'Scheduling',
            'Office Manager',
            'Driver Manager',
        ];

        foreach ($positions as $name) {
            DB::table('staff_positions')->insert([
                'name'       => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
