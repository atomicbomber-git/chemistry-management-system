<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert(array([
        	'nama_lab' => 'Biologi',
        	'alamat' => 'Jl. Hadari Nawawi Pontianak',
        	'telepon' => '089670711580',
        	'logo' => 'logo.png'
        	]
        	));
    }
}
