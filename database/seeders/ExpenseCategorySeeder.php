<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        // cra_t2125_lines IDs by line_number for readability
        // 1=8521 Advertising         2=8523 Meals & entertainment  3=9281 Motor vehicle
        // 4=8521 Advertising         5=8710 Interest & bank        6=9275 Delivery/freight
        // 7=8690 Insurance            8=8811 Office stationery      9=9220 Utilities
        // 10=9945 Home expenses      11=8760 Bus taxes/licences    12=8860 Professional fees
        // 13=9060 Salaries           14=9280 Other expenses        15=8590 Bad debts
        // 16=8810 Office expenses    17=8871 Mgmt & admin fees     18=9180 Property taxes
        // 19=8960 Repairs & maint

        $categories = [
            // Advertising — line 8521 (id 1)
            ['cra_t2125_id' => 1,  'name' => 'Advertising',              'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 10],

            // Bad Debts — line 8590 (id 15... but seeded in order so id=3 in DB)
            // We'll reference by line_number lookup below for safety

            // Meals & Entertainment — line 8523 (id 2)
            ['cra_t2125_id' => 2,  'name' => 'Beverage',                 'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 110],
            ['cra_t2125_id' => 2,  'name' => 'Breakfast',                'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 120],
            ['cra_t2125_id' => 2,  'name' => 'Dinner',                   'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 130],
            ['cra_t2125_id' => 2,  'name' => 'Entertainment',            'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 140],
            ['cra_t2125_id' => 2,  'name' => 'Lunch',                    'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 150],
            ['cra_t2125_id' => 2,  'name' => 'Snack',                    'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 160],

            // Bad Debts — line 8590 (id 3)
            ['cra_t2125_id' => 3,  'name' => 'Client Failed to Pay',     'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 20],

            // Insurance — line 8690 (id 4)
            ['cra_t2125_id' => 4,  'name' => 'Insurance',                'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 210],

            // Interest & Bank Charges — line 8710 (id 5)
            ['cra_t2125_id' => 5,  'name' => 'Bank Fee',                 'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 220],
            ['cra_t2125_id' => 5,  'name' => 'Payment Processing',       'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 230],

            // Business Taxes, Licences & Memberships — line 8760 (id 6)
            ['cra_t2125_id' => 6,  'name' => 'Annual Registration Fees', 'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 30],
            ['cra_t2125_id' => 6,  'name' => 'Business Licenses',        'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 40],
            ['cra_t2125_id' => 6,  'name' => 'Professional Memberships', 'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 50],

            // Office Expenses — line 8810 (id 7)
            ['cra_t2125_id' => 7,  'name' => 'Software Subscriptions',   'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 310],

            // Office Stationery & Supplies — line 8811 (id 8)
            ['cra_t2125_id' => 8,  'name' => 'Office Supplies',          'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 320],
            ['cra_t2125_id' => 8,  'name' => 'Stationery',               'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 330],
            ['cra_t2125_id' => 8,  'name' => 'Freight',                  'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 200],

            // Professional Fees — line 8860 (id 9)
            ['cra_t2125_id' => 9,  'name' => 'Legal & Accounting Fees',  'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 240],

            // Management & Admin Fees — line 8871 (id 10)
            ['cra_t2125_id' => 10, 'name' => 'Management Fees',          'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 250],

            // Repairs & Maintenance — line 8960 (id 11)
            ['cra_t2125_id' => 11, 'name' => 'Building Repairs',         'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 60],

            // Salaries, Wages & Benefits — line 9060 (id 12)
            ['cra_t2125_id' => 12, 'name' => 'Employee',                 'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 170],

            // Property Taxes — line 9180 (id 13)
            ['cra_t2125_id' => 13, 'name' => 'Mortgage Interest',        'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 260],

            // Travel Expenses — line 9200 (id 14)
            ['cra_t2125_id' => 14, 'name' => 'Air Fare',                 'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 340],
            ['cra_t2125_id' => 14, 'name' => 'Bed and Breakfast',        'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 350],
            ['cra_t2125_id' => 14, 'name' => 'Bus Fare',                 'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 360],
            ['cra_t2125_id' => 14, 'name' => 'Campground',               'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 370],
            ['cra_t2125_id' => 14, 'name' => 'Ferry',                    'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 380],
            ['cra_t2125_id' => 14, 'name' => 'Hostel',                   'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 390],
            ['cra_t2125_id' => 14, 'name' => 'Hotel/Motel',              'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 400],
            ['cra_t2125_id' => 14, 'name' => 'Luggage Fee',              'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 410],
            ['cra_t2125_id' => 14, 'name' => 'Public Transit',           'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 420],
            ['cra_t2125_id' => 14, 'name' => 'Rideshare',                'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 430],
            ['cra_t2125_id' => 14, 'name' => 'Taxi',                     'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 440],
            ['cra_t2125_id' => 14, 'name' => 'Train Fare',               'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 450],

            // Utilities — line 9220 (id 15)
            ['cra_t2125_id' => 15, 'name' => 'Phone',                    'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 460],
            ['cra_t2125_id' => 15, 'name' => 'Utilities',                'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 470],
            ['cra_t2125_id' => 15, 'name' => 'Rent',                     'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 70],

            // Delivery, Freight & Express — line 9275 (id 16)
            ['cra_t2125_id' => 16, 'name' => 'Courier',                  'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 80],

            // Other Expenses — line 9280 (id 17)
            ['cra_t2125_id' => 17, 'name' => 'Other Expenses',           'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 480],

            // Motor Vehicle Expenses — line 9281 (id 18)
            ['cra_t2125_id' => 18, 'name' => 'Boost',                    'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 490],
            ['cra_t2125_id' => 18, 'name' => 'Charging - E-Vehicles',    'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 500],
            ['cra_t2125_id' => 18, 'name' => 'Detail',                   'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 510],
            ['cra_t2125_id' => 18, 'name' => 'Driver Supplies',          'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 520],
            ['cra_t2125_id' => 18, 'name' => 'Fuel',                     'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 530],
            ['cra_t2125_id' => 18, 'name' => 'Lockout',                  'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 540],
            ['cra_t2125_id' => 18, 'name' => 'Maintenance',              'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 550],
            ['cra_t2125_id' => 18, 'name' => 'Repair',                   'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 560],
            ['cra_t2125_id' => 18, 'name' => 'Toll',                     'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 570],
            ['cra_t2125_id' => 18, 'name' => 'Tow',                      'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 580],
            ['cra_t2125_id' => 18, 'name' => 'Vehicle Supplies',         'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 590],
            ['cra_t2125_id' => 18, 'name' => 'Wash & Vacuum',            'driver_claimable' => true,  'reimbursable' => true,  'sort_order' => 600],

            // Business-use-of-home — line 9945 (id 19)
            ['cra_t2125_id' => 19, 'name' => 'Home Office',              'driver_claimable' => false, 'reimbursable' => false, 'sort_order' => 90],
        ];

        foreach ($categories as $cat) {
            DB::table('expense_categories')->insertOrIgnore([
                'cra_t2125_id'    => $cat['cra_t2125_id'],
                'name'            => $cat['name'],
                'slug'            => Str::slug($cat['name']),
                'driver_claimable'=> $cat['driver_claimable'],
                'reimbursable'    => $cat['reimbursable'],
                'is_active'       => true,
                'sort_order'      => $cat['sort_order'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}