<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $cities = [
            // Alberta (province_id = 1)
            ['Airdrie', 1], ['Banff', 1], ['Brooks', 1], ['Calgary', 1],
            ['Camrose', 1], ['Canmore', 1], ['Chestermere', 1], ['Cochrane', 1],
            ['Edmonton', 1], ['Fort Saskatchewan', 1], ['Grande Prairie', 1],
            ['Jasper', 1], ['Leduc', 1], ['Lethbridge', 1], ['Lloydminster', 1],
            ['Medicine Hat', 1], ['Okotoks', 1], ['Red Deer', 1],
            ['Spruce Grove', 1], ['St. Albert', 1],

            // British Columbia (province_id = 2)
            ['Abbotsford', 2], ['Burnaby', 2], ['Campbell River', 2],
            ['Chilliwack', 2], ['Coquitlam', 2], ['Courtenay', 2], ['Delta', 2],
            ['Kamloops', 2], ['Kelowna', 2], ['Langley', 2], ['Maple Ridge', 2],
            ['Nanaimo', 2], ['New Westminster', 2], ['North Vancouver', 2],
            ['Penticton', 2], ['Prince George', 2], ['Richmond', 2],
            ['Saanich', 2], ['Surrey', 2], ['Vancouver', 2], ['Vernon', 2],
            ['Victoria', 2], ['West Vancouver', 2],

            // Manitoba (province_id = 3)
            ['Brandon', 3], ['Dauphin', 3], ['Morden', 3],
            ['Portage la Prairie', 3], ['Selkirk', 3], ['Steinbach', 3],
            ['The Pas', 3], ['Thompson', 3], ['Winkler', 3], ['Winnipeg', 3],

            // New Brunswick (province_id = 4)
            ['Bathurst', 4], ['Campbellton', 4], ['Dieppe', 4],
            ['Edmundston', 4], ['Fredericton', 4], ['Miramichi', 4],
            ['Moncton', 4], ['Saint John', 4],

            // Newfoundland and Labrador (province_id = 5)
            ['Corner Brook', 5], ['Gander', 5], ['Grand Falls-Windsor', 5],
            ['Happy Valley-Goose Bay', 5], ['Labrador City', 5],
            ['Mount Pearl', 5], ["St. John's", 5],

            // Northwest Territories (province_id = 6)
            ['Fort Smith', 6], ['Hay River', 6], ['Inuvik', 6],
            ['Yellowknife', 6],

            // Nova Scotia (province_id = 7)
            ['Bridgewater', 7], ['Dartmouth', 7], ['Halifax', 7],
            ['Kentville', 7], ['New Glasgow', 7], ['Sydney', 7],
            ['Truro', 7], ['Yarmouth', 7],

            // Nunavut (province_id = 8)
            ['Arviat', 8], ['Cambridge Bay', 8], ['Iqaluit', 8],
            ['Rankin Inlet', 8],

            // Ontario (province_id = 9)
            ['Barrie', 9], ['Belleville', 9], ['Brampton', 9],
            ['Brantford', 9], ['Burlington', 9], ['Cambridge', 9],
            ['Cornwall', 9], ['Guelph', 9], ['Hamilton', 9], ['Kingston', 9],
            ['Kitchener', 9], ['London', 9], ['Markham', 9], ['Milton', 9],
            ['Mississauga', 9], ['Newmarket', 9], ['Niagara Falls', 9],
            ['North Bay', 9], ['Oakville', 9], ['Oshawa', 9], ['Ottawa', 9],
            ['Peterborough', 9], ['Pickering', 9], ['Richmond Hill', 9],
            ['Sarnia', 9], ['Sault Ste. Marie', 9], ['Scarborough', 9],
            ['St. Catharines', 9], ['St. Thomas', 9], ['Stratford', 9],
            ['Sudbury', 9], ['Thunder Bay', 9], ['Timmins', 9], ['Toronto', 9],
            ['Vaughan', 9], ['Waterloo', 9], ['Whitby', 9], ['Windsor', 9],
            ['Woodstock', 9],

            // Prince Edward Island (province_id = 10)
            ['Charlottetown', 10], ['Cornwall', 10], ['Stratford', 10],
            ['Summerside', 10],

            // Quebec (province_id = 11)
            ['Blainville', 11], ['Boucherville', 11], ['Drummondville', 11],
            ['Gatineau', 11], ['Granby', 11], ['Laval', 11], ['Levis', 11],
            ['Longueuil', 11], ['Montreal', 11], ['Quebec City', 11],
            ['Repentigny', 11], ['Rimouski', 11], ['Rouyn-Noranda', 11],
            ['Saguenay', 11], ['Saint-Jean-sur-Richelieu', 11],
            ['Saint-Jérôme', 11], ['Shawinigan', 11], ['Sherbrooke', 11],
            ['Terrebonne', 11], ['Trois-Rivières', 11], ["Val-d'Or", 11],

            // Saskatchewan (province_id = 12)
            ['Estevan', 12], ['Moose Jaw', 12], ['North Battleford', 12],
            ['Prince Albert', 12], ['Regina', 12], ['Saskatoon', 12],
            ['Swift Current', 12], ['Weyburn', 12], ['Yorkton', 12],

            // Yukon (province_id = 13)
            ['Dawson City', 13], ['Watson Lake', 13], ['Whitehorse', 13],

            // Alabama (province_id = 14)
            ['Auburn', 14], ['Birmingham', 14], ['Decatur', 14], ['Dothan', 14],
            ['Hoover', 14], ['Huntsville', 14], ['Mobile', 14],
            ['Montgomery', 14], ['Tuscaloosa', 14],

            // Alaska (province_id = 15)
            ['Anchorage', 15], ['Fairbanks', 15], ['Juneau', 15],
            ['Ketchikan', 15], ['Sitka', 15],

            // Arizona (province_id = 16)
            ['Chandler', 16], ['Flagstaff', 16], ['Gilbert', 16],
            ['Glendale', 16], ['Mesa', 16], ['Peoria', 16], ['Phoenix', 16],
            ['Scottsdale', 16], ['Tempe', 16], ['Tucson', 16], ['Yuma', 16],

            // Arkansas (province_id = 17)
            ['Conway', 17], ['Fayetteville', 17], ['Fort Smith', 17],
            ['Jonesboro', 17], ['Little Rock', 17], ['North Little Rock', 17],
            ['Rogers', 17], ['Springdale', 17],

            // California (province_id = 18)
            ['Anaheim', 18], ['Bakersfield', 18], ['Berkeley', 18],
            ['Chula Vista', 18], ['Fremont', 18], ['Fresno', 18],
            ['Glendale', 18], ['Irvine', 18], ['Long Beach', 18],
            ['Los Angeles', 18], ['Modesto', 18], ['Oakland', 18],
            ['Oceanside', 18], ['Ontario', 18], ['Orange', 18], ['Oxnard', 18],
            ['Rancho Cucamonga', 18], ['Riverside', 18], ['Sacramento', 18],
            ['San Bernardino', 18], ['San Diego', 18], ['San Francisco', 18],
            ['San Jose', 18], ['Santa Ana', 18], ['Santa Clara', 18],
            ['Santa Clarita', 18], ['Santa Rosa', 18], ['Stockton', 18],

            // Colorado (province_id = 19)
            ['Arvada', 19], ['Aurora', 19], ['Boulder', 19],
            ['Colorado Springs', 19], ['Denver', 19], ['Fort Collins', 19],
            ['Greeley', 19], ['Lakewood', 19], ['Pueblo', 19],
            ['Thornton', 19], ['Westminster', 19],

            // Connecticut (province_id = 20)
            ['Bridgeport', 20], ['Danbury', 20], ['Hartford', 20],
            ['New Britain', 20], ['New Haven', 20], ['Norwalk', 20],
            ['Stamford', 20], ['Waterbury', 20],

            // Delaware (province_id = 21)
            ['Dover', 21], ['Middletown', 21], ['Newark', 21],
            ['Smyrna', 21], ['Wilmington', 21],

            // Florida (province_id = 22)
            ['Cape Coral', 22], ['Clearwater', 22], ['Coral Springs', 22],
            ['Fort Lauderdale', 22], ['Gainesville', 22], ['Hialeah', 22],
            ['Hollywood', 22], ['Jacksonville', 22], ['Lakeland', 22],
            ['Miami', 22], ['Miramar', 22], ['Orlando', 22], ['Palm Bay', 22],
            ['Pembroke Pines', 22], ['Pompano Beach', 22],
            ['Port St. Lucie', 22], ['St. Petersburg', 22],
            ['Tallahassee', 22], ['Tampa', 22], ['West Palm Beach', 22],

            // Georgia (province_id = 23)
            ['Albany', 23], ['Athens', 23], ['Atlanta', 23], ['Augusta', 23],
            ['Columbus', 23], ['Macon', 23], ['Roswell', 23],
            ['Sandy Springs', 23], ['Savannah', 23],

            // Idaho (province_id = 24)
            ['Boise', 24], ['Caldwell', 24], ['Idaho Falls', 24],
            ['Meridian', 24], ['Nampa', 24], ['Pocatello', 24],
            ['Twin Falls', 24],

            // Illinois (province_id = 25)
            ['Aurora', 25], ['Chicago', 25], ['Elgin', 25], ['Joliet', 25],

            // Indiana (province_id = 26)
            ['Bloomington', 26], ['Carmel', 26], ['Evansville', 26],
            ['Fishers', 26], ['Fort Wayne', 26], ['Gary', 26],
            ['Hammond', 26], ['Indianapolis', 26], ['South Bend', 26],

            // Iowa (province_id = 27)
            ['Ames', 27], ['Cedar Rapids', 27], ['Davenport', 27],
            ['Des Moines', 27], ['Iowa City', 27], ['Sioux City', 27],
            ['Waterloo', 27], ['West Des Moines', 27],

            // Kansas (province_id = 28)
            ['Kansas City', 28], ['Lawrence', 28], ['Olathe', 28],
            ['Overland Park', 28], ['Shawnee', 28], ['Topeka', 28],
            ['Wichita', 28],

            // Kentucky (province_id = 29)
            ['Bowling Green', 29], ['Covington', 29], ['Lexington', 29],
            ['Louisville', 29], ['Owensboro', 29],

            // Louisiana (province_id = 30)
            ['Baton Rouge', 30], ['Bossier City', 30], ['Kenner', 30],
            ['Lafayette', 30], ['Lake Charles', 30], ['New Orleans', 30],
            ['Shreveport', 30],

            // Maine (province_id = 31)
            ['Auburn', 31], ['Bangor', 31], ['Lewiston', 31],
            ['Portland', 31], ['South Portland', 31],

            // Maryland (province_id = 32)
            ['Annapolis', 32], ['Baltimore', 32], ['Bowie', 32],
            ['Frederick', 32], ['Gaithersburg', 32], ['Hagerstown', 32],
            ['Rockville', 32],

            // Massachusetts (province_id = 33)
            ['Boston', 33], ['Brockton', 33], ['Cambridge', 33],
            ['Lowell', 33], ['Lynn', 33], ['New Bedford', 33], ['Quincy', 33],
            ['Springfield', 33], ['Worcester', 33],

            // Michigan (province_id = 34)
            ['Ann Arbor', 34], ['Dearborn', 34], ['Detroit', 34],
            ['Flint', 34], ['Grand Rapids', 34], ['Lansing', 34],
            ['Livonia', 34], ['Sterling Heights', 34], ['Troy', 34],
            ['Warren', 34],

            // Minnesota (province_id = 35)
            ['Bloomington', 35], ['Brooklyn Park', 35], ['Duluth', 35],
            ['Maple Grove', 35], ['Minneapolis', 35], ['Plymouth', 35],
            ['Rochester', 35], ['Saint Paul', 35],

            // Mississippi (province_id = 36)
            ['Biloxi', 36], ['Gulfport', 36], ['Hattiesburg', 36],
            ['Jackson', 36], ['Southaven', 36],

            // Missouri (province_id = 37)
            ['Columbia', 37], ['Independence', 37], ['Kansas City', 37],
            ["Lee's Summit", 37], ["O'Fallon", 37], ['Springfield', 37],
            ['St. Louis', 37],

            // Montana (province_id = 38)
            ['Billings', 38], ['Bozeman', 38], ['Butte', 38],
            ['Great Falls', 38], ['Helena', 38], ['Missoula', 38],

            // Nebraska (province_id = 39)
            ['Bellevue', 39], ['Grand Island', 39], ['Kearney', 39],
            ['Lincoln', 39], ['Omaha', 39],

            // Nevada (province_id = 40)
            ['Carson City', 40], ['Henderson', 40], ['Las Vegas', 40],
            ['North Las Vegas', 40], ['Reno', 40], ['Sparks', 40],

            // New Hampshire (province_id = 41)
            ['Concord', 41], ['Derry', 41], ['Manchester', 41],
            ['Nashua', 41], ['Rochester', 41],

            // New Jersey (province_id = 42)
            ['Edison', 42], ['Elizabeth', 42], ['Jersey City', 42],
            ['Lakewood', 42], ['Newark', 42], ['Paterson', 42],
            ['Woodbridge', 42],

            // New Mexico (province_id = 43)
            ['Albuquerque', 43], ['Las Cruces', 43], ['Rio Rancho', 43],
            ['Roswell', 43], ['Santa Fe', 43],

            // New York (province_id = 44)
            ['Albany', 44], ['Buffalo', 44], ['Mount Vernon', 44],
            ['New Rochelle', 44], ['New York', 44], ['Rochester', 44],
            ['Syracuse', 44], ['Yonkers', 44],

            // North Carolina (province_id = 45)
            ['Cary', 45], ['Charlotte', 45], ['Durham', 45],
            ['Fayetteville', 45], ['Greensboro', 45], ['Raleigh', 45],
            ['Wilmington', 45], ['Winston-Salem', 45],

            // North Dakota (province_id = 46)
            ['Bismarck', 46], ['Fargo', 46], ['Grand Forks', 46],
            ['Minot', 46], ['West Fargo', 46],

            // Ohio (province_id = 47)
            ['Akron', 47], ['Canton', 47], ['Cincinnati', 47],
            ['Cleveland', 47], ['Columbus', 47], ['Dayton', 47],
            ['Parma', 47], ['Toledo', 47],

            // Oklahoma (province_id = 48)
            ['Broken Arrow', 48], ['Edmond', 48], ['Lawton', 48],
            ['Norman', 48], ['Oklahoma City', 48], ['Tulsa', 48],

            // Oregon (province_id = 49)
            ['Beaverton', 49], ['Bend', 49], ['Eugene', 49], ['Gresham', 49],
            ['Hillsboro', 49], ['Medford', 49], ['Portland', 49], ['Salem', 49],

            // Pennsylvania (province_id = 50)
            ['Allentown', 50], ['Bethlehem', 50], ['Erie', 50],
            ['Lancaster', 50], ['Philadelphia', 50], ['Pittsburgh', 50],
            ['Reading', 50], ['Scranton', 50],

            // Rhode Island (province_id = 51)
            ['Cranston', 51], ['East Providence', 51], ['Pawtucket', 51],
            ['Providence', 51], ['Warwick', 51],

            // South Carolina (province_id = 52)
            ['Charleston', 52], ['Columbia', 52], ['Greenville', 52],
            ['Mount Pleasant', 52], ['North Charleston', 52], ['Rock Hill', 52],

            // South Dakota (province_id = 53)
            ['Aberdeen', 53], ['Brookings', 53], ['Rapid City', 53],
            ['Sioux Falls', 53], ['Watertown', 53],

            // Tennessee (province_id = 54)
            ['Chattanooga', 54], ['Clarksville', 54], ['Franklin', 54],
            ['Knoxville', 54], ['Memphis', 54], ['Murfreesboro', 54],
            ['Nashville', 54],

            // Texas (province_id = 55)
            ['Amarillo', 55], ['Arlington', 55], ['Austin', 55],
            ['Brownsville', 55], ['Corpus Christi', 55], ['Dallas', 55],
            ['El Paso', 55], ['Fort Worth', 55], ['Garland', 55],
            ['Houston', 55], ['Irving', 55], ['Laredo', 55], ['Lubbock', 55],
            ['Plano', 55], ['San Antonio', 55],

            // Utah (province_id = 56)
            ['Ogden', 56], ['Orem', 56], ['Provo', 56], ['Salt Lake City', 56],
            ['Sandy', 56], ['St. George', 56], ['West Jordan', 56],
            ['West Valley City', 56],

            // Vermont (province_id = 57)
            ['Barre', 57], ['Burlington', 57], ['Montpelier', 57],
            ['Rutland', 57], ['South Burlington', 57],

            // Virginia (province_id = 58)
            ['Alexandria', 58], ['Chesapeake', 58], ['Hampton', 58],
            ['Newport News', 58], ['Norfolk', 58], ['Richmond', 58],
            ['Roanoke', 58], ['Virginia Beach', 58],

            // Washington (province_id = 59)
            ['Bellevue', 59], ['Everett', 59], ['Kent', 59], ['Renton', 59],
            ['Seattle', 59], ['Spokane', 59], ['Tacoma', 59], ['Vancouver', 59],

            // West Virginia (province_id = 60)
            ['Charleston', 60], ['Huntington', 60], ['Morgantown', 60],
            ['Parkersburg', 60], ['Wheeling', 60],

            // Wisconsin (province_id = 61)
            ['Appleton', 61], ['Eau Claire', 61], ['Green Bay', 61],
            ['Janesville', 61], ['Kenosha', 61], ['La Crosse', 61],
            ['Madison', 61], ['Milwaukee', 61], ['Oshkosh', 61],
            ['Racine', 61], ['Waukesha', 61],

            // Wyoming (province_id = 62)
            ['Casper', 62], ['Cheyenne', 62], ['Gillette', 62],
            ['Laramie', 62], ['Rock Springs', 62], ['Sheridan', 62],
        ];

        foreach ($cities as [$name, $provinceId]) {
            DB::table('cities')->insert([
                'province_id' => $provinceId,
                'name'        => $name,
                'is_active'   => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}