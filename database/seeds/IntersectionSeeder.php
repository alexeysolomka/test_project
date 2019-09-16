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
        foreach(range(1, 5) as $item)
        {
            DB::table('intersections')
                ->insert([
                    'name' => 'Intersection' . $item
                ]);
        }
    }
}
