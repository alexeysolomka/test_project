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

class KharkivMetroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IntersectionToStation::truncate();
        DB::table('types')
            ->insert([
                ['name' => 'Metro']
            ]);
        $metroType = Type::where('name', 'Metro')->first();
        //Create metros
        DB::table('metros')
            ->insert([
                [
                    'location' => 'Kharkiv',
                    'type_id' => $metroType->id
                ]
            ]);

        $kharkivMetro = Metro::where('location', 'Kharkiv')->first();

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
        DB::table('intersections')
            ->insert([
                ['name' => 'BlueToGreen'],
                ['name' => 'BlueToRed'],
                ['name' => 'GreenToRed']
            ]);
        $intersections = Intersection::all();
        foreach ($intersections as $intersection) {
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
        }
    }
}
