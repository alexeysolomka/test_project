<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntersectionToStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 5) as $item)
        {
            DB::table('intersection_to_stations')
                ->insert([
                    'intersection_id' => rand(1, 5),
                    'station_id' => rand(1, 100)
                ]);
        }
    }
}
