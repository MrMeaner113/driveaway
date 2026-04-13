<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Debit',          'is_active' => true,  'sort_order' => 1],
            ['name' => 'Cash',           'is_active' => true,  'sort_order' => 2],
            ['name' => 'Visa',           'is_active' => true,  'sort_order' => 3],
            ['name' => 'Mastercard',     'is_active' => true,  'sort_order' => 4],
            ['name' => 'Amex',           'is_active' => true,  'sort_order' => 5],
            ['name' => 'E-Transfer',     'is_active' => true,  'sort_order' => 6],
            ['name' => 'Wire Transfer',  'is_active' => true,  'sort_order' => 7],
            ['name' => 'Bank Draft',     'is_active' => true,  'sort_order' => 8],
            ['name' => 'Square Payment', 'is_active' => true,  'sort_order' => 9],
            ['name' => 'Business Check', 'is_active' => false, 'sort_order' => 10],
            ['name' => 'PayPal',         'is_active' => false, 'sort_order' => 11],
            ['name' => 'Crypto',         'is_active' => false, 'sort_order' => 12],
        ];

        foreach ($methods as $method) {
            DB::table('payment_methods')->insertOrIgnore([
                'name'       => $method['name'],
                'slug'       => Str::slug($method['name']),
                'is_active'  => $method['is_active'],
                'sort_order' => $method['sort_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}