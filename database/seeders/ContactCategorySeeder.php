<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContactCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Internal',  'sort_order' => 1],
            ['name' => 'Revenue',   'sort_order' => 2],
            ['name' => 'Expense',   'sort_order' => 3],
            ['name' => 'Marketing', 'sort_order' => 4],
            ['name' => 'Legal',     'sort_order' => 5],
        ];

        foreach ($categories as $cat) {
            DB::table('contact_categories')->insertOrIgnore([
                'name'       => $cat['name'],
                'slug'       => Str::slug($cat['name']),
                'is_active'  => true,
                'sort_order' => $cat['sort_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}