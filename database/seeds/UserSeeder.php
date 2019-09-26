<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'First User',
            'email' => 'first-user@gmail.com',
            'phone_number' => '8190341122',
            'is_active' => true,
            'role_id' => 1,
            'password' => bcrypt('first-user1')
        ]);
    }
}
