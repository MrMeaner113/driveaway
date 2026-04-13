<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FuelVendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            '2471506 Ontario Inc',
            'Austin Gas Bar',
            'Belmont Energy',
            'Canadian Tire Gas Bar',
            'Canco',
            'Chevron',
            'Circle K',
            'Co-Op',
            'Costco',
            'Couche-Tard',
            'Domo',
            'Double Eagle',
            'Eagles Nest Gas Bar',
            'Esso',
            'Fas Gas',
            'Fifth Wheel',
            'Flying J',
            'Groupe R Inc',
            'Husky',
            'Irving',
            'Joy',
            'Kanata',
            'Lake Helen',
            'MacEwen',
            "Mac's",
            'Mobil',
            'Mr. Gas',
            'North Atlantic Petroleum',
            'ONroute',
            'Orangestore',
            'Pelletiers',
            'Petro-Canada',
            'Pioneer',
            'Serpent River',
            'Shawanaga First Nation',
            'Shell',
            'Simply',
            'Tags',
            'Trailside Gas',
            'Ultramar',
            'Wolves Den',
            'XTR',
        ];

        foreach ($vendors as $index => $vendor) {
            DB::table('fuel_vendors')->insertOrIgnore([
                'name'       => $vendor,
                'slug'       => Str::slug($vendor),
                'is_active'  => true,
                'sort_order' => ($index + 1) * 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}