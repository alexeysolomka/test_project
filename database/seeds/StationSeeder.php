<?php

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
        foreach(range(1, 33) as $item)
        {
            DB::table('stations')
                ->insert([
                    'branch_id' => 1,
                    'name' => 'Station' . $item,
                ]);
        }
        foreach(range(34, 66) as $item)
        {
            DB::table('stations')
                ->insert([
                    'branch_id' => 2,
                    'name' => 'Station' . $item,
                ]);
        }
        foreach(range(67, 98) as $item)
        {
            DB::table('stations')
                ->insert([
                    'branch_id' => 3,
                    'name' => 'Station' . $item,
                ]);
        }
    }
}
