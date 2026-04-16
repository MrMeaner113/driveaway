<?php

namespace Database\Seeders;

use App\Models\TravelMode;
use Illuminate\Database\Seeder;

class TravelModeSeeder extends Seeder
{
    public function run(): void
    {
        $modes = [
            ['name' => 'Flight',          'icon' => 'heroicon-o-paper-airplane'],
            ['name' => 'Train',           'icon' => null],
            ['name' => 'Bus',             'icon' => null],
            ['name' => 'Rideshare',       'icon' => 'heroicon-o-user-group'],
            ['name' => 'Rental Car',      'icon' => 'heroicon-o-key'],
            ['name' => 'Personal Vehicle','icon' => 'heroicon-o-truck'],
        ];

        foreach ($modes as $mode) {
            TravelMode::firstOrCreate(
                ['name' => $mode['name']],
                ['icon' => $mode['icon']],
            );
        }
    }
}
