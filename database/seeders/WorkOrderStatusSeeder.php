<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkOrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Waiting Dispatch', 'color' => 'gray',   'description' => 'Not yet dispatched.',              'visible_to_client' => true,  'is_terminal' => false, 'sort_order' => 1],
            ['name' => 'Assigned',         'color' => 'blue',   'description' => 'Driver assigned.',                 'visible_to_client' => true,  'is_terminal' => false, 'sort_order' => 2],
            ['name' => 'In Progress',      'color' => 'yellow', 'description' => 'On the road.',                     'visible_to_client' => true,  'is_terminal' => false, 'sort_order' => 3],
            ['name' => 'Completed',        'color' => 'green',  'description' => 'Delivery done.',                   'visible_to_client' => true,  'is_terminal' => false, 'sort_order' => 4],
            ['name' => 'Invoiced',         'color' => 'purple', 'description' => 'Invoice sent to client.',          'visible_to_client' => false, 'is_terminal' => false, 'sort_order' => 5],
            ['name' => 'Paid',             'color' => 'teal',   'description' => 'Payment received, job closed.',    'visible_to_client' => false, 'is_terminal' => true,  'sort_order' => 6],
            ['name' => 'Cancelled',        'color' => 'red',    'description' => 'Cancelled before completion.',     'visible_to_client' => true,  'is_terminal' => true,  'sort_order' => 7],
        ];

        foreach ($statuses as $status) {
            DB::table('work_order_statuses')->insertOrIgnore([
                'name'              => $status['name'],
                'slug'              => Str::slug($status['name']),
                'color'             => $status['color'],
                'description'       => $status['description'],
                'visible_to_client' => $status['visible_to_client'],
                'is_terminal'       => $status['is_terminal'],
                'is_active'         => true,
                'sort_order'        => $status['sort_order'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}