<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaxTypeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $taxTypes = [
            [
                'name'        => 'Goods and Services Tax',
                'code'        => 'GST',
                'description' => 'Federal tax applied in provinces without HST',
            ],
            [
                'name'        => 'Harmonized Sales Tax',
                'code'        => 'HST',
                'description' => 'Combined federal and provincial tax — ON, NB, NS, NL, PE',
            ],
            [
                'name'        => 'Provincial Sales Tax',
                'code'        => 'PST',
                'description' => 'Provincial tax applied separately from GST — BC, MB, SK',
            ],
            [
                'name'        => 'Quebec Sales Tax',
                'code'        => 'QST',
                'description' => 'Provincial tax applied separately from GST in Quebec',
            ],
            [
                'name'        => 'State Sales Tax',
                'code'        => 'SST',
                'description' => 'US state level sales tax',
            ],
        ];

        foreach ($taxTypes as $type) {
            DB::table('tax_types')->insert(array_merge($type, [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}