<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RateTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Per KM',    'unit_label' => 'per km',   'description' => 'Rate applied per kilometre driven.',              'sort_order' => 1],
            ['name' => 'Per Mile',  'unit_label' => 'per mi',   'description' => 'Rate applied per mile driven.',                   'sort_order' => 2],
            ['name' => 'Flat Fee',  'unit_label' => 'flat',     'description' => 'Single fixed charge for the entire job.',         'sort_order' => 3],
            ['name' => 'Hourly',    'unit_label' => 'per hr',   'description' => 'Rate applied per hour of service.',               'sort_order' => 4],
            ['name' => 'Per Day',   'unit_label' => 'per day',  'description' => 'Rate applied per calendar day.',                  'sort_order' => 5],
            ['name' => 'Surcharge', 'unit_label' => 'fixed',    'description' => 'Additional charge added on top of the base rate.','sort_order' => 6],
        ];

        foreach ($types as $type) {
            DB::table('rate_types')->insertOrIgnore([
                'name'        => $type['name'],
                'slug'        => Str::slug($type['name']),
                'unit_label'  => $type['unit_label'],
                'description' => $type['description'],
                'is_active'   => true,
                'sort_order'  => $type['sort_order'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}