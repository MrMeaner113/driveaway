<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CraT2125LineSeeder extends Seeder
{
    public function run(): void
    {
        $lines = [
            ['line_number' => 8521, 'description' => 'Advertising'],
            ['line_number' => 8523, 'description' => 'Meals and entertainment'],
            ['line_number' => 8590, 'description' => 'Bad debts'],
            ['line_number' => 8690, 'description' => 'Insurance'],
            ['line_number' => 8710, 'description' => 'Interest and bank charges'],
            ['line_number' => 8760, 'description' => 'Business taxes, licences, and memberships'],
            ['line_number' => 8810, 'description' => 'Office expenses'],
            ['line_number' => 8811, 'description' => 'Office stationery and supplies'],
            ['line_number' => 8860, 'description' => 'Professional fees'],
            ['line_number' => 8871, 'description' => 'Management and administration fees'],
            ['line_number' => 8960, 'description' => 'Repairs and maintenance'],
            ['line_number' => 9060, 'description' => 'Salaries, wages, and benefits'],
            ['line_number' => 9180, 'description' => 'Property taxes'],
            ['line_number' => 9200, 'description' => 'Travel expenses'],
            ['line_number' => 9220, 'description' => 'Utilities'],
            ['line_number' => 9275, 'description' => 'Delivery, freight and express'],
            ['line_number' => 9280, 'description' => 'Other expenses'],
            ['line_number' => 9281, 'description' => 'Motor vehicle expenses'],
            ['line_number' => 9945, 'description' => 'Business-use-of-home expenses'],
        ];

        foreach ($lines as $line) {
            DB::table('cra_t2125_lines')->insertOrIgnore([
                'line_number'  => $line['line_number'],
                'description'  => $line['description'],
                'is_active'    => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}