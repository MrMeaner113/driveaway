<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PreferredContactMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Email',        'sort_order' => 1],
            ['name' => 'Phone',        'sort_order' => 2],
            ['name' => 'Text - SMS/MMS', 'sort_order' => 3],
        ];

        foreach ($methods as $method) {
            DB::table('preferred_contact_methods')->insertOrIgnore([
                'name'       => $method['name'],
                'slug'       => Str::slug($method['name']),
                'is_active'  => true,
                'sort_order' => $method['sort_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}