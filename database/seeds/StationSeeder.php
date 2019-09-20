<?php

use App\Branch;
use App\Intersection;
use App\Station;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')
            ->insert([
                ['name' => 'Kholodnogorskya'],
                ['name' => 'Saltivska'],
                ['name' => 'Oleksiivska'],
                ['name' => 'Circle']
            ]);
        $branches = Branch::all();
        foreach ($branches as $branch) {
            if ($branch->name == 'Kholodnogorskya') {
                DB::table('stations')
                    ->insert([
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Kholodna Gora'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pivdenyi Vokzal'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Central Rynok'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Radyanska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pr. Gagarina'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Sportyvna'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Zavod Malysheva'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Moscow Prospect'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Marshala Jukova'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Radyanskoy Armiy'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Maselskogo'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Traktoriv'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Prolet'
                        ],
                    ]);
            }
            if ($branch->name == 'Saltivska') {
                DB::table('stations')
                    ->insert([
                        ['branch_id' => $branch->id,
                            'name' => 'Istorical Myzei'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Universitet'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Pushkinska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Kyivska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Academic Barabashova'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Academic Pavlova'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Studentska'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Heroes Pratsi'
                        ],
                    ]);
            }
            if ($branch->name == 'Oleksiivska') {
                DB::table('stations')
                    ->insert([
                        ['branch_id' => $branch->id,
                            'name' => 'Metrobydivnukiv'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Plosha Povstania'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Architector Beketova'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Derzprom'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'naukova'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Botanical Sad'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => '23 August'
                        ],
                        [
                            'branch_id' => $branch->id,
                            'name' => 'Oleksiivska'
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
        }

        $stations = Station::all();

        $station_end_id = Station::where('name', 'Prolet')->first()->id;
        foreach($stations as $station)
        {
            if($station->id < $station_end_id)
            {
                $station->next = $station->id + 1;
                $station->save();
            }
        }

        $station_start = Station::where('name', 'Istorical Myzei')->first()->id;
        $station_end_id = Station::where('name', 'Heroes Pratsi')->first()->id;
        foreach($stations as $station)
        {
            if($station->id >= $station_start && $station->id < $station_end_id)
            {
                $station->next = $station->id + 1;
                $station->save();
            }
        }

        $station_start = Station::where('name', 'Metrobydivnukiv')->first()->id;
        $station_end_id = Station::where('name', 'Oleksiivska')->first()->id;
        foreach($stations as $station)
        {
            if($station->id >= $station_start && $station->id < $station_end_id)
            {
                $station->next = $station->id + 1;
                $station->save();
            }
        }

        $station_start = Station::where('name', 'Pesochyn')->first()->id;
        $station_end_id = Station::where('name', 'Getto')->first()->id;
        foreach($stations as $station)
        {
            if($station->id >= $station_start && $station->id < $station_end_id)
            {
                $station->next = $station->id + 1;
                $station->save();
            }
        }

        DB::table('intersections')
            ->insert([
                [ 'name' => 'BlueToGreen' ],
                [ 'name' => 'BlueToRed' ],
                [ 'name' => 'BlueToYellow' ],
                [ 'name' => 'GreenToBlue' ],
                [ 'name' => 'GreenToRed' ],
                [ 'name' => 'GreenToYellow' ],
                [ 'name' => 'RedToBlue' ],
                [ 'name' => 'RedToGreen' ],
                [ 'name' => 'RedToYellow' ],
                [ 'name' => 'YellowToBlue' ],
                [ 'name' => 'YellowToGreen' ],
                [ 'name' => 'YellowToRed' ]
            ]);
        $intersections = Intersection::all();
        foreach($intersections as $intersection)
        {
            if($intersection->name == 'BlueToGreen')
            {
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
            if($intersection->name == 'BlueToRed')
            {
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
            if($intersection->name == 'BlueToYellow')
            {
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
            if($intersection->name == 'GreenToBlue')
            {
                $station = Station::where('name', 'Derzprom')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Universitet')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if($intersection->name == 'GreenToRed')
            {
                $station = Station::where('name', 'Metrobydivnukiv')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
                $station = Station::where('name', 'Sportyvna')->first();
                DB::table('intersection_to_stations')
                    ->insert([
                        'intersection_id' => $intersection->id,
                        'station_id' => $station->id
                    ]);
            }
            if($intersection->name == 'GreenToYellow')
            {
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
            if($intersection->name == 'RedToBlue')
            {
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
            if($intersection->name == 'RedToGreen')
            {
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
            if($intersection->name == 'RedToYellow')
            {
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
            if($intersection->name == 'YellowToBlue')
            {
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
            if($intersection->name == 'YellowToGreen')
            {
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
            if($intersection->name == 'YellowToRed')
            {
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
    }
}
