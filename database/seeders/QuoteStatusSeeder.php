<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuoteStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'New',         'color' => 'blue',   'description' => 'The quote request has been received but has not yet been reviewed or processed by staff.',             'is_terminal' => false, 'sort_order' => 1],
            ['name' => 'In Progress', 'color' => 'yellow', 'description' => 'Staff is actively calculating the route, trip costs, and preparing the final quote.',                 'is_terminal' => false, 'sort_order' => 2],
            ['name' => 'On Hold',     'color' => 'orange', 'description' => 'Processing is paused due to missing information (e.g., waiting for VIN, dates, or clarification).',  'is_terminal' => false, 'sort_order' => 3],
            ['name' => 'Sent',        'color' => 'purple', 'description' => 'The finalized quote has been delivered to the customer and is awaiting their decision.',               'is_terminal' => false, 'sort_order' => 4],
            ['name' => 'Accepted',    'color' => 'green',  'description' => 'The client has formally agreed to the quote and pricing.',                                             'is_terminal' => false, 'sort_order' => 5],
            ['name' => 'Converted',   'color' => 'teal',   'description' => 'The quote has been successfully converted into an active Work Order.',                                 'is_terminal' => true,  'sort_order' => 6],
            ['name' => 'Expired',     'color' => 'gray',   'description' => 'The quote\'s acceptance deadline has passed without a response from the client.',                      'is_terminal' => true,  'sort_order' => 7],
            ['name' => 'Rejected',    'color' => 'red',    'description' => 'The client has informed the service that they will not be proceeding with the quote.',                 'is_terminal' => true,  'sort_order' => 8],
            ['name' => 'Cancelled',   'color' => 'red',    'description' => 'The quote was active but was cancelled by the client before being accepted or converted.',             'is_terminal' => true,  'sort_order' => 9],
        ];

        foreach ($statuses as $status) {
            DB::table('quote_statuses')->insertOrIgnore([
                'name'        => $status['name'],
                'slug'        => Str::slug($status['name']),
                'color'       => $status['color'],
                'description' => $status['description'],
                'is_terminal' => $status['is_terminal'],
                'is_active'   => true,
                'sort_order'  => $status['sort_order'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}