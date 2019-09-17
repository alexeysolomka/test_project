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
        DB::table('stations')
            ->insert([
               [
                   'branch_id' => 1,
                   'name' => 'Kholodna Gora'
               ],
                [
                    'branch_id' => 1,
                    'name' => 'Pivdenyi Vokzal'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Central Rynok'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Radyanska'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Pr. Gagarina'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Sportyvna'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Zavod Malysheva'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Moscow Prospect'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Marshala Jukova'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Radyanskoy Armiy'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Maselskogo'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Traktoriv'
                ],
                [
                    'branch_id' => 1,
                    'name' => 'Prolet'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Istorical Myzei'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Universitet'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Pushkinska'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Kyivska'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Academic Barabashova'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Academic Pavlova'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Studentska'
                ],
                [
                    'branch_id' => 2,
                    'name' => 'Heroes Pratsi'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'Metrobydivnukiv'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'Plosha Povstania'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'Architector Beketova'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'Derzprom'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'naukova'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'Botanical Sad'
                ],
                [
                    'branch_id' => 3,
                    'name' => '23 August'
                ],
                [
                    'branch_id' => 3,
                    'name' => 'Oleksiivska'
                ],
            ]);
    }
}
