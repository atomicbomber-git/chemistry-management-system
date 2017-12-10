<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
        	[
        	'name' => 'Liza Dahlia',
        	'email' => 'liza.dahlia@yahoo.com',
        	'password' => bcrypt('123456'),
        	'foto' => 'user.png',
        	'level' => 1
        	],
        	[
        	'name' => 'aminah',
        	'email' => 'aminah@yahoo.com',
        	'password' => bcrypt('123456'),
        	'foto' => 'user.png',
        	'level' => 2
        	]
        	));

    }
}
