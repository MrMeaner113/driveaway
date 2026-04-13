<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddressTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Client Residence',            'description' => 'Home address for individual clients',                          'is_active' => true,  'sort_order' => 1],
            ['name' => 'Pickup Location',             'description' => 'Where your driver collects the vehicle',                       'is_active' => true,  'sort_order' => 2],
            ['name' => 'Drop-off Location',           'description' => 'Where the vehicle is delivered',                               'is_active' => true,  'sort_order' => 3],
            ['name' => 'Emergency Contact Address',   'description' => 'Backup contact location',                                      'is_active' => true,  'sort_order' => 4],
            ['name' => 'Temporary Address',           'description' => 'Seasonal or short-term addresses',                             'is_active' => true,  'sort_order' => 5],
            ['name' => 'Storage Yard',                'description' => 'Temporary holding facility for vehicles',                      'is_active' => true,  'sort_order' => 6],
            ['name' => 'Business Headquarters',       'description' => 'Main registered office of a client company',                   'is_active' => true,  'sort_order' => 7],
            ['name' => 'Branch Office',               'description' => 'Regional or satellite office locations',                       'is_active' => true,  'sort_order' => 8],
            ['name' => 'Billing Address',             'description' => 'Where invoices and statements are sent',                       'is_active' => true,  'sort_order' => 9],
            ['name' => 'Staff Residence',             'description' => 'Home address for team members',                                'is_active' => true,  'sort_order' => 10],
            ['name' => 'Insurance Address',           'description' => 'Address tied to insurance documentation',                      'is_active' => true,  'sort_order' => 11],
            ['name' => 'Legal Service Address',       'description' => 'For contracts or legal notices',                               'is_active' => true,  'sort_order' => 12],
            ['name' => 'Cross-border Customs Address','description' => 'For vehicles crossing into the U.S. or other jurisdictions',   'is_active' => true,  'sort_order' => 13],
            ['name' => 'Mailing Address',             'description' => 'General correspondence address',                               'is_active' => false, 'sort_order' => 15],
            ['name' => 'Jurisdictional Address',      'description' => 'Province/state address for tax logic',                         'is_active' => false, 'sort_order' => 14],
        ];

        foreach ($types as $type) {
            DB::table('address_types')->insertOrIgnore([
                'name'        => $type['name'],
                'slug'        => Str::slug($type['name']),
                'description' => $type['description'],
                'is_active'   => $type['is_active'],
                'sort_order'  => $type['sort_order'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}