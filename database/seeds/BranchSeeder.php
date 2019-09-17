<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
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
                ['name' => 'Oleksiivska']
            ]);
    }
}
