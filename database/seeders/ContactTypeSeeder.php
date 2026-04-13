<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContactTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Category IDs seeded in order: 1=Internal, 2=Revenue, 3=Expense, 4=Marketing, 5=Legal
        $types = [
            ['contact_category_id' => 2, 'name' => 'Client',                 'description' => 'Person or company the job will be for.',                                                    'sort_order' => 1],
            ['contact_category_id' => 2, 'name' => 'Shipper',                'description' => 'The specific person at the origin.',                                                        'sort_order' => 2],
            ['contact_category_id' => 2, 'name' => 'Receiver',               'description' => 'The person receiving the keys at the destination.',                                         'sort_order' => 3],
            ['contact_category_id' => 1, 'name' => 'Team Member',            'description' => 'Internal employee or staff involved in the job.',                                           'sort_order' => 4],
            ['contact_category_id' => 5, 'name' => 'Vehicle Registered Owner','description' => 'Legal owner of the vehicle/s being moved.',                                               'sort_order' => 5],
            ['contact_category_id' => 3, 'name' => 'Referral Source',        'description' => 'Person or company who referred the client.',                                               'sort_order' => 6],
            ['contact_category_id' => 3, 'name' => 'Storage Facility',       'description' => 'Location where vehicle is to be stored.',                                                  'sort_order' => 7],
            ['contact_category_id' => 5, 'name' => 'Insurance Agent',        'description' => 'Contact for policy updates.',                                                              'sort_order' => 8],
            ['contact_category_id' => 2, 'name' => 'Fleet Manager',          'description' => 'The primary contact for corporate accounts with multiple vehicles.',                        'sort_order' => 9],
            ['contact_category_id' => 2, 'name' => 'Dealer/Rental',          'description' => 'Business-to-business moves where a dealership is the requester.',                          'sort_order' => 10],
            ['contact_category_id' => 2, 'name' => 'Auction House',          'description' => 'Primary contact for auction house account with multiple vehicles.',                         'sort_order' => 11],
            ['contact_category_id' => 2, 'name' => 'Broker',                 'description' => 'Work from larger logistics firms or load boards.',                                          'sort_order' => 12],
        ];

        foreach ($types as $type) {
            DB::table('contact_types')->insertOrIgnore([
                'contact_category_id' => $type['contact_category_id'],
                'name'                => $type['name'],
                'slug'                => Str::slug($type['name']),
                'description'         => $type['description'],
                'is_active'           => true,
                'sort_order'          => $type['sort_order'],
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}