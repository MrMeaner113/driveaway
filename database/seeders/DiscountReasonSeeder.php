<?php

namespace Database\Seeders;

use App\Models\DiscountReason;
use Illuminate\Database\Seeder;

class DiscountReasonSeeder extends Seeder
{
    public function run(): void
    {
        $reasons = [
            'Repeat Client',
            'Referral',
            'Seasonal Promotion',
            'Loyalty',
            'Staff Discount',
            'Other',
        ];

        foreach ($reasons as $name) {
            DiscountReason::firstOrCreate(['name' => $name]);
        }
    }
}
