<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $provinces = [
            // --- Canada (country_id = 1) ---
            ['country_id' => 1, 'name' => 'Alberta',                   'code' => 'AB', 'timezone' => 'America/Edmonton',       'dst_observed' => false],
            ['country_id' => 1, 'name' => 'British Columbia',          'code' => 'BC', 'timezone' => 'America/Vancouver',      'dst_observed' => false],
            ['country_id' => 1, 'name' => 'Manitoba',                  'code' => 'MB', 'timezone' => 'America/Winnipeg',       'dst_observed' => true],
            ['country_id' => 1, 'name' => 'New Brunswick',             'code' => 'NB', 'timezone' => 'America/Moncton',        'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Newfoundland and Labrador', 'code' => 'NL', 'timezone' => 'America/St_Johns',       'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Northwest Territories',     'code' => 'NT', 'timezone' => 'America/Yellowknife',    'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Nova Scotia',               'code' => 'NS', 'timezone' => 'America/Halifax',        'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Nunavut',                   'code' => 'NU', 'timezone' => 'America/Rankin_Inlet',   'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Ontario',                   'code' => 'ON', 'timezone' => 'America/Toronto',        'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Prince Edward Island',      'code' => 'PE', 'timezone' => 'America/Halifax',        'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Quebec',                    'code' => 'QC', 'timezone' => 'America/Toronto',        'dst_observed' => true],
            ['country_id' => 1, 'name' => 'Saskatchewan',              'code' => 'SK', 'timezone' => 'America/Regina',         'dst_observed' => false],
            ['country_id' => 1, 'name' => 'Yukon',                     'code' => 'YT', 'timezone' => 'America/Whitehorse',     'dst_observed' => false],

            // --- United States (country_id = 2) ---
            ['country_id' => 2, 'name' => 'Alabama',        'code' => 'AL', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Alaska',         'code' => 'AK', 'timezone' => 'America/Anchorage',      'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Arizona',        'code' => 'AZ', 'timezone' => 'America/Phoenix',        'dst_observed' => false],
            ['country_id' => 2, 'name' => 'Arkansas',       'code' => 'AR', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'California',     'code' => 'CA', 'timezone' => 'America/Los_Angeles',    'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Colorado',       'code' => 'CO', 'timezone' => 'America/Denver',         'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Connecticut',    'code' => 'CT', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Delaware',       'code' => 'DE', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Florida',        'code' => 'FL', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Georgia',        'code' => 'GA', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Idaho',          'code' => 'ID', 'timezone' => 'America/Denver',         'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Illinois',       'code' => 'IL', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Indiana',        'code' => 'IN', 'timezone' => 'America/Indiana/Indianapolis', 'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Iowa',           'code' => 'IA', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Kansas',         'code' => 'KS', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Kentucky',       'code' => 'KY', 'timezone' => 'America/Kentucky/Louisville', 'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Louisiana',      'code' => 'LA', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Maine',          'code' => 'ME', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Maryland',       'code' => 'MD', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Massachusetts',  'code' => 'MA', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Michigan',       'code' => 'MI', 'timezone' => 'America/Detroit',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Minnesota',      'code' => 'MN', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Mississippi',    'code' => 'MS', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Missouri',       'code' => 'MO', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Montana',        'code' => 'MT', 'timezone' => 'America/Denver',         'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Nebraska',       'code' => 'NE', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Nevada',         'code' => 'NV', 'timezone' => 'America/Los_Angeles',    'dst_observed' => true],
            ['country_id' => 2, 'name' => 'New Hampshire',  'code' => 'NH', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'New Jersey',     'code' => 'NJ', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'New Mexico',     'code' => 'NM', 'timezone' => 'America/Denver',         'dst_observed' => true],
            ['country_id' => 2, 'name' => 'New York',       'code' => 'NY', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'North Carolina', 'code' => 'NC', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'North Dakota',   'code' => 'ND', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Ohio',           'code' => 'OH', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Oklahoma',       'code' => 'OK', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Oregon',         'code' => 'OR', 'timezone' => 'America/Los_Angeles',    'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Pennsylvania',   'code' => 'PA', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Rhode Island',   'code' => 'RI', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'South Carolina', 'code' => 'SC', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'South Dakota',   'code' => 'SD', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Tennessee',      'code' => 'TN', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Texas',          'code' => 'TX', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Utah',           'code' => 'UT', 'timezone' => 'America/Denver',         'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Vermont',        'code' => 'VT', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Virginia',       'code' => 'VA', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Washington',     'code' => 'WA', 'timezone' => 'America/Los_Angeles',    'dst_observed' => true],
            ['country_id' => 2, 'name' => 'West Virginia',  'code' => 'WV', 'timezone' => 'America/New_York',       'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Wisconsin',      'code' => 'WI', 'timezone' => 'America/Chicago',        'dst_observed' => true],
            ['country_id' => 2, 'name' => 'Wyoming',        'code' => 'WY', 'timezone' => 'America/Denver',         'dst_observed' => true],
        ];

        foreach ($provinces as $province) {
            DB::table('provinces')->insert(array_merge($province, [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}