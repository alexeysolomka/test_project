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
        DB::table('intersection_to_stations')
            ->insert([
                [
                    'intersection_id' => 1,
                    'station_id' => 4
                ],
                [
                    'intersection_id' => 1,
                    'station_id' => 25
                ],
                [
                    'intersection_id' => 2,
                    'station_id' => 6
                ],
                [
                    'intersection_id' => 2,
                    'station_id' => 15
                ],
                [
                    'intersection_id' => 3,
                    'station_id' => 14
                ],
                [
                    'intersection_id' => 3,
                    'station_id' => 22
                ],
            ]);
    }
}
