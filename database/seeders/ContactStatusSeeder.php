<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Active',          'slug' => 'active',          'sort_order' => 10],
            ['name' => 'Prospect',        'slug' => 'prospect',        'sort_order' => 20],
            ['name' => 'Inactive',        'slug' => 'inactive',        'sort_order' => 30],
            ['name' => 'Do Not Contact',  'slug' => 'do-not-contact',  'sort_order' => 40],
            ['name' => 'Archived',        'slug' => 'archived',        'sort_order' => 50],
        ];

        foreach ($statuses as $status) {
            DB::table('contact_statuses')->insert([
                ...$status,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
