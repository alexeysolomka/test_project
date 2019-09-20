<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntersectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
