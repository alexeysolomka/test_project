<?php

use App\Type;
use App\Metro;
use App\Branch;
use App\Station;
use App\Intersection;
use App\IntersectionToStation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return true;
        IntersectionToStation::truncate();
        DB::table('types')
            ->insert([
                ['name' => 'Metro'],
                ['name' => 'Train'],
                ['name' => 'Bus']
            ]);
        $metroType = Type::where('name', 'Metro')->first();
        $trainType = Type::where('name', 'Train')->first();
        $busType = Type::where('name', 'Bus')->first();
        //Create metros
        DB::table('metros')
            ->insert([
                [
                    'location' => 'Kharkiv',
                    'type_id' => $metroType->id
                ],
                [
                    'location' => 'KharkivBus',
                    'type_id' => $busType->id,
                ],
                [
                    'location' => 'Kiev',
                    'type_id' => $metroType->id
                ]
            ]);

        $kharkivMetro = Metro::where('location', 'Kharkiv')->first();
        $kharkivBus = Metro::where('location', 'KharkivBus')->first();
        $kievMetro = Metro::where('location', 'Kiev')->first();

        DB::table('branches')
            ->insert([
                //Kharkiv metro
                [
                    'name' => 'Kholodnogorskya',
                    'metro_id' => $kharkivMetro->id
                ],
                [
                    'name' => 'Saltivska',
                    'metro_id' => $kharkivMetro->id
                ],
                [
                    'name' => 'Oleksiivska',
                    'metro_id' => $kharkivMetro->id
                ],
                [
                    'name' => 'Circle',
                    'metro_id' => $kharkivMetro->id
                ],
                // Kharkiv Bus
                [
                    'name' => 'Bus',
                    'metro_id' => $kharkivBus->id
                ],
                // Kiev Metro
                [
                    'name' => 'M1',
                    'metro_id' => $kievMetro->id
                ],
                [
                    'name' => 'M2',
                    'metro_id' => $kievMetro->id
                ],
                [
                    'name' => 'M3',
                    'metro_id' => $kievMetro->id
                ],
            ]);
        $branches = Branch::all();
        foreach ($branches as $branch) {
            if ($branch->name == 'Kholodnogorskya') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Kholodna Gora',
                            'point' => DB::raw("ST_MakePoint(49.98, 36.18)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pivdenyi Vokzal',
                            'point' => DB::raw("ST_MakePoint(49.99, 36.20)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Central Rynok',
                            'point' => DB::raw("ST_MakePoint(49.99, 36.22)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Radyanska',
                            'point' => DB::raw("ST_MakePoint(49.99, 36.23)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pr. Gagarina',
                            'point' => DB::raw("ST_MakePoint(49.98, 36.25)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Sportyvna',
                            'point' => DB::raw("ST_MakePoint(49.98, 36.26)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Zavod Malysheva',
                            'point' => DB::raw("ST_MakePoint(49.98, 36.28)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Moscow Prospect',
                            'point' => DB::raw("ST_MakePoint(49.97, 36.31)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Marshala Jukova',
                            'point' => DB::raw("ST_MakePoint(49.97, 36.32)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Radyanskoy Armiy',
                            'point' => DB::raw("ST_MakePoint(49.80, 36.35)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Maselskogo',
                            'point' => DB::raw("ST_MakePoint(49.96, 36.36)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Traktoriv',
                            'point' => DB::raw("ST_MakePoint(49.97, 36.38)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Prolet',
                            'point' => DB::raw("ST_MakePoint(49.95, 36.40)")
                        ],
                    ]);
            }
            if ($branch->name == 'Saltivska') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Istorical Myzei',
                            'point' => DB::raw("ST_MakePoint(49.99, 36.23)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Universitet',
                            'point' => DB::raw("ST_MakePoint(50.00, 36.24)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pushkinska',
                            'point' => DB::raw("ST_MakePoint(50.00, 36.25)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Kyivska',
                            'point' => DB::raw("ST_MakePoint(50.00, 36.27)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Academic Barabashova',
                            'point' => DB::raw("ST_MakePoint(50.00, 36.30)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Academic Pavlova',
                            'point' => DB::raw("ST_MakePoint(50.01, 36.32)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Studentska',
                            'point' => DB::raw("ST_MakePoint(50.02, 36.33)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Heroes Pratsi',
                            'point' => DB::raw("ST_MakePoint(50.02, 36.34)")
                        ],
                    ]);
            }
            if ($branch->name == 'Oleksiivska') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Metrobydivnukiv',
                            'point' => DB::raw("ST_MakePoint(49.98, 36.2625)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Plosha Povstania',
                            'point' => DB::raw("ST_MakePoint(49.98861, 36.26472)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Architector Beketova',
                            'point' => DB::raw("ST_MakePoint(49.99861, 36.24056)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Derzprom',
                            'point' => DB::raw("ST_MakePoint(50.00583, 36.23111)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'naukova',
                            'point' => DB::raw("ST_MakePoint(50.01278, 36.22667)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Botanical Sad',
                            'point' => DB::raw("ST_MakePoint(50.02722, 36.22306)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => '23 August',
                            'point' => DB::raw("ST_MakePoint(50.03444, 36.22056)")
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Oleksiivska',
                            'point' => DB::raw("ST_MakePoint(50.05, 36.20667)")
                        ],
                    ]);
            }
            if ($branch->name == 'Circle') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pesochyn'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'New Houses'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Vorobiev Moutions'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Bezlydovka'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Saratov'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'West Cost'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'East Cost'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Getto'
                        ],
                    ]);
            }
            if ($branch->name == 'Bus') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Jutomirsker'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Oleksandorvske'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Kuyivkse'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Love park'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Moskalevksa'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Slobodskya'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Vasilivska'
                        ]
                    ]);
            }
            // Kiev metro
            if ($branch->name == 'M1') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Akadem'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Jytomyr'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Nuvku'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Vokzalna'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Universitat'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Theathre'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Kreshyatuk'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Arsenalna'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Dnipro'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Lisova'
                        ],
                    ]);
            }
            if ($branch->name == 'M2') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Heroes Dnipra'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Tarasa Shevchenka'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Poshtova'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Maidan Nezalejnosti'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Platz Lva Tolstogo'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Olimpiska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Palatz Ukraine'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Lubidska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Vasilivska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Ipodrom'
                        ],
                    ]);
            }
            if ($branch->name == 'M3') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Surets'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Dorogozhuchi'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Golden Vorota'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Palatz Sporty'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Klovska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pecherska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Druzhbu Narodiv'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Vudybichi'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Slavytuch'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Osokorku'
                        ],
                    ]);
            }
        }
        // Kharkiv metro
        $kharkivMetroBranches = $kharkivMetro->branches->pluck('id');
        $stations = Station::whereIn('branch_id', $kharkivMetroBranches)->get();
        $station_end_id = Station::where('name', 'Prolet')->first()->id;
        foreach ($stations as $station) {
            if ($station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        $station_start = Station::where('name', 'Istorical Myzei')->first()->id;
        $station_end_id = Station::where('name', 'Heroes Pratsi')->first()->id;
        foreach ($stations as $station) {
            if ($station->id >= $station_start && $station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        $station_start = Station::where('name', 'Metrobydivnukiv')->first()->id;
        $station_end_id = Station::where('name', 'Oleksiivska')->first()->id;
        foreach ($stations as $station) {
            if ($station->id >= $station_start && $station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        $station_start = Station::where('name', 'Pesochyn')->first()->id;
        $station_end_id = Station::where('name', 'Getto')->first()->id;
        foreach ($stations as $station) {
            if ($station->id >= $station_start && $station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        $kharkivBusBranches = $kharkivBus->branches->pluck('id');
        $stations = Station::whereIn('branch_id', $kharkivBusBranches)->get();
        $station_end_id = Station::where('name', 'Vasilivska')->first();
        foreach ($stations as $station) {
            if ($station->id < $station_end_id->id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        DB::table('intersections')
            ->insert([
                ['name' => 'BlueToGreen'],
                ['name' => 'BlueToRed'],
                ['name' => 'BlueToYellow'],
                ['name' => 'GreenToRed'],
                ['name' => 'GreenToYellow'],
                ['name' => 'RedToYellow'],
                ['name' => 'RedToBus'],
                ['name' => 'GreenToBus'],
                ['name' => 'BlueToBus']
            ]);
        $intersections = Intersection::all();
        foreach ($intersections as $intersection) {
            if ($intersection->name == 'RedToBus') {
                $stationMetro = Station::where('name', 'Radyanska')->first();
                $stationBus = Station::where('name', 'Oleksandorvske')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $stationMetro->id
                    ]);
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $stationBus->id
                    ]);
            }
            if ($intersection->name == 'GreenToBus') {
                $stationMetro = Station::where('name', 'Plosha Povstania')->first();
                $stationBus = Station::where('name', 'Love park')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $stationMetro->id
                    ]);
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $stationBus->id
                    ]);
            }
            if ($intersection->name == 'BlueToBus') {
                $stationMetro = Station::where('name', 'Academic Pavlova')->first();
                $stationBus = Station::where('name', 'Vasilivska')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $stationMetro->id
                    ]);
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $stationBus->id
                    ]);
            }
            if ($intersection->name == 'BlueToGreen') {
                $station = Station::where('name', 'Universitet')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Derzprom')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'BlueToRed') {
                $station = Station::where('name', 'Radyanska')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Istorical Myzei')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'BlueToYellow') {
                $station = Station::where('name', 'Heroes Pratsi')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Bezlydovka')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'GreenToRed') {
                $station = Station::where('name', 'Sportyvna')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Metrobydivnukiv')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'GreenToYellow') {
                $station = Station::where('name', 'Oleksiivska')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'East Cost')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'RedToYellow') {
                $station = Station::where('name', 'Kholodna Gora')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Pesochyn')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
        }
        //Kiev metro
        $kievMetroBranches = $kievMetro->branches->pluck('id');
        $stations = Station::whereIn('branch_id', $kievMetroBranches)->get();;
        $station_end_id = Station::where('name', 'Lisova')->first()->id;
        foreach ($stations as $station) {
            if ($station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        $station_start = Station::where('name', 'Heroes Dnipra')->first()->id;
        $station_end_id = Station::where('name', 'Ipodrom')->first()->id;
        foreach ($stations as $station) {
            if ($station->id >= $station_start && $station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }
        $station_start = Station::where('name', 'Surets')->first()->id;
        $station_end_id = Station::where('name', 'Osokorku')->first()->id;
        foreach ($stations as $station) {
            if ($station->id >= $station_start && $station->id < $station_end_id) {
                $station->next = $station->id + 1;
                $station->travel_time = rand(130, 310);
                $station->save();
            }
        }

        DB::table('intersections')
            ->insert([
                ['name' => 'M1-M3'],
                ['name' => 'M1-M2'],
                ['name' => 'M2-M3'],
            ]);
        $intersections = Intersection::all();
        foreach ($intersections as $intersection) {
            if ($intersection->name == 'M1-M3') {
                $station = Station::where('name', 'Theathre')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Golden Vorota')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'M1-M2') {
                $station = Station::where('name', 'Kreshyatuk')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Maidan Nezalejnosti')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if ($intersection->name == 'M2-M3') {
                $station = Station::where('name', 'Platz Lva Tolstogo')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Palatz Sporty')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
        }

        // $faker = Faker::create();
        // $allStations = Station::all();
        // foreach($allStations as $station)
        // {
        //     $latitude = $faker->latitude();
        //     $longitude = $faker->longitude();
        //     $station->point = DB::raw("ST_MakePoint($latitude, $longitude)");
        //     $station->save();
        // }
    }
}
