<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Make IDs match the order seeded in VehicleMakeSeeder
        // 1=Chevrolet, 2=Ford, 3=GMC, 4=Honda, 5=Hyundai
        // 6=Jeep, 7=Kia, 8=Lexus, 9=Mazda, 10=Nissan
        // 11=Ram, 12=Subaru, 13=Tesla, 14=Toyota, 15=Volkswagen

        $models = [
            // Chevrolet (1)
            ['Silverado', 1], ['Colorado', 1], ['Equinox', 1], ['Traverse', 1],
            ['Tahoe', 1], ['Suburban', 1], ['Trailblazer', 1], ['Blazer', 1],
            ['Malibu', 1], ['Corvette', 1], ['Bolt EV', 1], ['Bolt EUV', 1],
            ['Express', 1],

            // Ford (2)
            ['F-150', 2], ['Super Duty', 2], ['Ranger', 2], ['Maverick', 2],
            ['Escape', 2], ['Edge', 2], ['Explorer', 2], ['Expedition', 2],
            ['Bronco', 2], ['Bronco Sport', 2], ['Mustang', 2], ['Mach-E', 2],
            ['Transit', 2], ['Transit Connect', 2],

            // GMC (3)
            ['Sierra 1500', 3], ['Sierra HD', 3], ['Canyon', 3], ['Terrain', 3],
            ['Acadia', 3], ['Yukon', 3], ['Yukon XL', 3],
            ['Hummer EV Pickup', 3], ['Hummer EV SUV', 3],

            // Honda (4)
            ['Civic', 4], ['Accord', 4], ['CR-V', 4], ['HR-V', 4],
            ['Pilot', 4], ['Passport', 4], ['Odyssey', 4], ['Ridgeline', 4],
            ['Prologue', 4],

            // Hyundai (5)
            ['Elantra', 5], ['Sonata', 5], ['Venue', 5], ['Kona', 5],
            ['Tucson', 5], ['Santa Fe', 5], ['Palisade', 5], ['Ioniq 5', 5],
            ['Ioniq 6', 5], ['Santa Cruz', 5],

            // Jeep (6)
            ['Wrangler', 6], ['Gladiator', 6], ['Compass', 6], ['Cherokee', 6],
            ['Grand Cherokee', 6],

            // Kia (7)
            ['Forte', 7], ['K5', 7], ['Rio', 7], ['Soul', 7],
            ['Seltos', 7], ['Sportage', 7], ['Sorento', 7], ['Telluride', 7],
            ['Carnival', 7], ['Niro', 7],

            // Lexus (8)
            ['IS', 8], ['ES', 8], ['LS', 8], ['UX', 8],
            ['NX', 8], ['RX', 8], ['GX', 8], ['LX', 8],
            ['RC', 8], ['LC', 8], ['RZ', 8],

            // Mazda (9)
            ['Mazda3', 9], ['Mazda6', 9], ['CX-30', 9], ['CX-5', 9],
            ['CX-50', 9], ['CX-70', 9], ['CX-90', 9], ['MX-5', 9],
            ['MX-30', 9],

            // Nissan (10)
            ['Sentra', 10], ['Altima', 10], ['Versa', 10], ['Kicks', 10],
            ['Rogue', 10], ['Murano', 10], ['Pathfinder', 10], ['Armada', 10],
            ['Frontier', 10], ['Titan', 10], ['Leaf', 10], ['Ariya', 10],

            // Ram (11)
            ['1500', 11], ['2500', 11], ['3500', 11],
            ['ProMaster', 11], ['ProMaster City', 11],

            // Subaru (12)
            ['Impreza', 12], ['Legacy', 12], ['Crosstrek', 12], ['Forester', 12],
            ['Outback', 12], ['Ascent', 12], ['BRZ', 12], ['Solterra', 12],

            // Tesla (13)
            ['Model 3', 13], ['Model Y', 13], ['Model S', 13],
            ['Model X', 13], ['Cybertruck', 13],

            // Toyota (14)
            ['Corolla', 14], ['Camry', 14], ['RAV4', 14], ['Highlander', 14],
            ['Grand Highlander', 14], ['Tacoma', 14], ['Tundra', 14],
            ['4Runner', 14], ['Sequoia', 14], ['Prius', 14],
            ['Corolla Cross', 14], ['bZ4X', 14], ['Crown', 14], ['Venza', 14],

            // Volkswagen (15)
            ['Jetta', 15], ['GTI', 15], ['Golf R', 15], ['Taos', 15],
            ['Tiguan', 15], ['Atlas', 15], ['Atlas Cross Sport', 15],
            ['ID.4', 15], ['ID.Buzz', 15],
        ];

        foreach ($models as [$name, $makeId]) {
            DB::table('vehicle_models')->insert([
                'vehicle_make_id' => $makeId,
                'name'            => $name,
                'is_active'       => true,
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);
        }
    }
}