<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimezoneSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $timezones = [
            // Canada
            ['name' => 'Newfoundland Time',     'timezone' => 'America/St_Johns'],
            ['name' => 'Atlantic Time',          'timezone' => 'America/Halifax'],
            ['name' => 'Eastern Time',           'timezone' => 'America/Toronto'],
            ['name' => 'Central Time',           'timezone' => 'America/Winnipeg'],
            ['name' => 'Mountain Time',          'timezone' => 'America/Edmonton'],
            ['name' => 'Mountain Time (no DST)', 'timezone' => 'America/Regina'],
            ['name' => 'Pacific Time',           'timezone' => 'America/Vancouver'],
            ['name' => 'Yukon Time',             'timezone' => 'America/Whitehorse'],
            ['name' => 'Mountain Time (NT)',     'timezone' => 'America/Yellowknife'],
            ['name' => 'Central Time (NU)',      'timezone' => 'America/Rankin_Inlet'],
            ['name' => 'Atlantic Time (NB)',     'timezone' => 'America/Moncton'],

            // United States
            ['name' => 'Alaska Time',            'timezone' => 'America/Anchorage'],
            ['name' => 'Pacific Time (US)',      'timezone' => 'America/Los_Angeles'],
            ['name' => 'Mountain Time (US)',     'timezone' => 'America/Denver'],
            ['name' => 'Mountain Time (AZ)',     'timezone' => 'America/Phoenix'],
            ['name' => 'Central Time (US)',      'timezone' => 'America/Chicago'],
            ['name' => 'Eastern Time (US)',      'timezone' => 'America/New_York'],
            ['name' => 'Eastern Time (IN)',      'timezone' => 'America/Indiana/Indianapolis'],
            ['name' => 'Eastern Time (KY)',      'timezone' => 'America/Kentucky/Louisville'],
            ['name' => 'Eastern Time (MI)',      'timezone' => 'America/Detroit'],
        ];

        foreach ($timezones as $tz) {
            DB::table('timezones')->insert(array_merge($tz, [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}