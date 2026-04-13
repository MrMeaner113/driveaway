<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddOnServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Trailer Hauling',      'description' => 'Towing a trailer as part of the vehicle relocation.',          'sort_order' => 1],
            ['name' => 'Pet Transfer',         'description' => 'Transporting a pet along with the vehicle.',                   'sort_order' => 2],
            ['name' => 'Personal Belongings',  'description' => 'Transporting personal items inside the vehicle.',              'sort_order' => 3],
            ['name' => 'Transfer Plate',       'description' => 'Handling and transferring a vehicle licence plate.',           'sort_order' => 4],
            ['name' => 'Temp Insurance',       'description' => 'Arranging temporary insurance coverage for the vehicle.',      'sort_order' => 5],
        ];

        foreach ($services as $service) {
            DB::table('add_on_services')->insertOrIgnore([
                'name'        => $service['name'],
                'slug'        => Str::slug($service['name']),
                'description' => $service['description'],
                'is_active'   => true,
                'sort_order'  => $service['sort_order'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}