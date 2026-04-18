<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Available',      'color_code' => 'green'],
            ['name' => 'On Assignment',  'color_code' => 'blue'],
            ['name' => 'Off Duty',       'color_code' => 'grey'],
            ['name' => 'Pending Docs',   'color_code' => 'orange'],
            ['name' => 'On Hold',        'color_code' => 'red'],
        ];

        foreach ($statuses as $status) {
            DB::table('driver_statuses')->insert([
                ...$status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
