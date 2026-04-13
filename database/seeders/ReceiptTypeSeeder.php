<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReceiptTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Paper',          'sort_order' => 1],
            ['name' => 'Email',          'sort_order' => 2],
            ['name' => 'Text',           'sort_order' => 3],
            ['name' => 'Screen Capture', 'sort_order' => 4],
        ];

        foreach ($types as $type) {
            DB::table('receipt_types')->insertOrIgnore([
                'name'       => $type['name'],
                'slug'       => Str::slug($type['name']),
                'is_active'  => true,
                'sort_order' => $type['sort_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}