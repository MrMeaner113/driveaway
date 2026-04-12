<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrivelineSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $drivelines = [
            ['name' => 'Front Wheel Drive',       'code' => 'FWD'],
            ['name' => 'Rear Wheel Drive',         'code' => 'RWD'],
            ['name' => 'All Wheel Drive',          'code' => 'AWD'],
            ['name' => 'Four Wheel Drive',         'code' => '4WD'],
            ['name' => 'Four By Four',             'code' => '4X4'],
            ['name' => 'Front or All Wheel Drive', 'code' => 'FWD/AWD'],
            ['name' => 'Rear or Four Wheel Drive', 'code' => 'RWD/4WD'],
        ];

        foreach ($drivelines as $driveline) {
            DB::table('drivelines')->insert(array_merge($driveline, [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}