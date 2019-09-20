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
            if($station->id < 13)
            {
                $station->next = $station->id + 1;
            }
            if($station->id >13 && $station->id < 21)
            {
                $station->next = $station->id + 1;
            }
            if($station->id > 21 && $station->id < 29)
            {
                $station->next = $station->id + 1;
            }
            if($station->id > 29 && $station->id < 37)
            {
                $station->next = $station->id + 1;
            }
            $station->save();
        }
    }
}
