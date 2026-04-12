<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('countries')->insert([
            [
                'name'                 => 'Canada',
                'iso_code'             => 'CA',
                'postal_format'        => 'A9A 9A9',
                'requires_jurisdiction'=> true,
                'is_active'            => true,
                'is_default'           => true,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'name'                 => 'United States',
                'iso_code'             => 'US',
                'postal_format'        => '99999',
                'requires_jurisdiction'=> true,
                'is_active'            => true,
                'is_default'           => false,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'name'                 => 'Mexico',
                'iso_code'             => 'MX',
                'postal_format'        => '99999',
                'requires_jurisdiction'=> false,
                'is_active'            => true,
                'is_default'           => false,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
        ]);
    }
}