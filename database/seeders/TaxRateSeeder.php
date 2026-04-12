<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaxRateSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Tax type IDs from tax_types table
        // 1 = GST, 2 = HST, 3 = PST, 4 = QST, 5 = SST

        $rates = [
            // --- Canada ---
            // Alberta — GST only
            ['province_id' => 1,  'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2008-01-01', 'expiry_date' => null],

            // British Columbia — GST + PST
            ['province_id' => 2,  'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2013-04-01', 'expiry_date' => null],
            ['province_id' => 2,  'tax_type_id' => 3, 'rate_pct' => 700,  'effective_date' => '2013-04-01', 'expiry_date' => null],

            // Manitoba — GST + PST
            ['province_id' => 3,  'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2019-07-01', 'expiry_date' => null],
            ['province_id' => 3,  'tax_type_id' => 3, 'rate_pct' => 700,  'effective_date' => '2019-07-01', 'expiry_date' => null],

            // New Brunswick — HST
            ['province_id' => 4,  'tax_type_id' => 2, 'rate_pct' => 1500, 'effective_date' => '2016-07-01', 'expiry_date' => null],

            // Newfoundland and Labrador — HST
            ['province_id' => 5,  'tax_type_id' => 2, 'rate_pct' => 1500, 'effective_date' => '2016-07-01', 'expiry_date' => null],

            // Northwest Territories — GST only
            ['province_id' => 6,  'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2008-01-01', 'expiry_date' => null],

            // Nova Scotia — HST
            ['province_id' => 7,  'tax_type_id' => 2, 'rate_pct' => 1400, 'effective_date' => '2025-04-01', 'expiry_date' => null],

            // Nunavut — GST only
            ['province_id' => 8,  'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2008-01-01', 'expiry_date' => null],

            // Ontario — HST
            ['province_id' => 9,  'tax_type_id' => 2, 'rate_pct' => 1300, 'effective_date' => '2010-07-01', 'expiry_date' => null],

            // Prince Edward Island — HST
            ['province_id' => 10, 'tax_type_id' => 2, 'rate_pct' => 1500, 'effective_date' => '2016-10-01', 'expiry_date' => null],

            // Quebec — GST + QST
            ['province_id' => 11, 'tax_type_id' => 1, 'rate_pct' => 500,   'effective_date' => '2013-01-01', 'expiry_date' => null],
            ['province_id' => 11, 'tax_type_id' => 4, 'rate_pct' => 998,   'effective_date' => '2013-01-01', 'expiry_date' => null],

            // Saskatchewan — GST + PST
            ['province_id' => 12, 'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2017-03-23', 'expiry_date' => null],
            ['province_id' => 12, 'tax_type_id' => 3, 'rate_pct' => 600,  'effective_date' => '2017-03-23', 'expiry_date' => null],

            // Yukon — GST only
            ['province_id' => 13, 'tax_type_id' => 1, 'rate_pct' => 500,  'effective_date' => '2008-01-01', 'expiry_date' => null],

            // --- United States — SST ---
            ['province_id' => 14, 'tax_type_id' => 5, 'rate_pct' => 400,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Alabama
            ['province_id' => 15, 'tax_type_id' => 5, 'rate_pct' => 0,    'effective_date' => '2023-01-01', 'expiry_date' => null], // Alaska
            ['province_id' => 16, 'tax_type_id' => 5, 'rate_pct' => 560,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Arizona
            ['province_id' => 17, 'tax_type_id' => 5, 'rate_pct' => 650,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Arkansas
            ['province_id' => 18, 'tax_type_id' => 5, 'rate_pct' => 725,  'effective_date' => '2023-01-01', 'expiry_date' => null], // California
            ['province_id' => 19, 'tax_type_id' => 5, 'rate_pct' => 290,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Colorado
            ['province_id' => 20, 'tax_type_id' => 5, 'rate_pct' => 635,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Connecticut
            ['province_id' => 21, 'tax_type_id' => 5, 'rate_pct' => 0,    'effective_date' => '2023-01-01', 'expiry_date' => null], // Delaware
            ['province_id' => 22, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Florida
            ['province_id' => 23, 'tax_type_id' => 5, 'rate_pct' => 400,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Georgia
            ['province_id' => 24, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Idaho
            ['province_id' => 25, 'tax_type_id' => 5, 'rate_pct' => 625,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Illinois
            ['province_id' => 26, 'tax_type_id' => 5, 'rate_pct' => 700,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Indiana
            ['province_id' => 27, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Iowa
            ['province_id' => 28, 'tax_type_id' => 5, 'rate_pct' => 650,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Kansas
            ['province_id' => 29, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Kentucky
            ['province_id' => 30, 'tax_type_id' => 5, 'rate_pct' => 445,  'effective_date' => '2025-07-01', 'expiry_date' => null], // Louisiana
            ['province_id' => 31, 'tax_type_id' => 5, 'rate_pct' => 550,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Maine
            ['province_id' => 32, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Maryland
            ['province_id' => 33, 'tax_type_id' => 5, 'rate_pct' => 625,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Massachusetts
            ['province_id' => 34, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Michigan
            ['province_id' => 35, 'tax_type_id' => 5, 'rate_pct' => 688,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Minnesota
            ['province_id' => 36, 'tax_type_id' => 5, 'rate_pct' => 700,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Mississippi
            ['province_id' => 37, 'tax_type_id' => 5, 'rate_pct' => 423,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Missouri
            ['province_id' => 38, 'tax_type_id' => 5, 'rate_pct' => 0,    'effective_date' => '2023-01-01', 'expiry_date' => null], // Montana
            ['province_id' => 39, 'tax_type_id' => 5, 'rate_pct' => 550,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Nebraska
            ['province_id' => 40, 'tax_type_id' => 5, 'rate_pct' => 460,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Nevada
            ['province_id' => 41, 'tax_type_id' => 5, 'rate_pct' => 0,    'effective_date' => '2023-01-01', 'expiry_date' => null], // New Hampshire
            ['province_id' => 42, 'tax_type_id' => 5, 'rate_pct' => 663,  'effective_date' => '2023-01-01', 'expiry_date' => null], // New Jersey
            ['province_id' => 43, 'tax_type_id' => 5, 'rate_pct' => 513,  'effective_date' => '2023-01-01', 'expiry_date' => null], // New Mexico
            ['province_id' => 44, 'tax_type_id' => 5, 'rate_pct' => 400,  'effective_date' => '2023-01-01', 'expiry_date' => null], // New York
            ['province_id' => 45, 'tax_type_id' => 5, 'rate_pct' => 475,  'effective_date' => '2023-01-01', 'expiry_date' => null], // North Carolina
            ['province_id' => 46, 'tax_type_id' => 5, 'rate_pct' => 500,  'effective_date' => '2023-01-01', 'expiry_date' => null], // North Dakota
            ['province_id' => 47, 'tax_type_id' => 5, 'rate_pct' => 575,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Ohio
            ['province_id' => 48, 'tax_type_id' => 5, 'rate_pct' => 450,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Oklahoma
            ['province_id' => 49, 'tax_type_id' => 5, 'rate_pct' => 0,    'effective_date' => '2023-01-01', 'expiry_date' => null], // Oregon
            ['province_id' => 50, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Pennsylvania
            ['province_id' => 51, 'tax_type_id' => 5, 'rate_pct' => 700,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Rhode Island
            ['province_id' => 52, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // South Carolina
            ['province_id' => 53, 'tax_type_id' => 5, 'rate_pct' => 450,  'effective_date' => '2023-01-01', 'expiry_date' => null], // South Dakota
            ['province_id' => 54, 'tax_type_id' => 5, 'rate_pct' => 700,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Tennessee
            ['province_id' => 55, 'tax_type_id' => 5, 'rate_pct' => 625,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Texas
            ['province_id' => 56, 'tax_type_id' => 5, 'rate_pct' => 470,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Utah
            ['province_id' => 57, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Vermont
            ['province_id' => 58, 'tax_type_id' => 5, 'rate_pct' => 430,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Virginia
            ['province_id' => 59, 'tax_type_id' => 5, 'rate_pct' => 650,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Washington
            ['province_id' => 60, 'tax_type_id' => 5, 'rate_pct' => 600,  'effective_date' => '2023-01-01', 'expiry_date' => null], // West Virginia
            ['province_id' => 61, 'tax_type_id' => 5, 'rate_pct' => 500,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Wisconsin
            ['province_id' => 62, 'tax_type_id' => 5, 'rate_pct' => 400,  'effective_date' => '2023-01-01', 'expiry_date' => null], // Wyoming
        ];

        foreach ($rates as $rate) {
            DB::table('tax_rates')->insert(array_merge($rate, [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}