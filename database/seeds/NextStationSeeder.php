<?php

use App\Station;
use Illuminate\Database\Seeder;

class NextStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stations = Station::all();

        foreach($stations as $station)
        {
            if(!$station->next && $station->id < 100)
            {
                $station->next = $station->id + 1;
                $station->save();
            }
        }
    }
}
