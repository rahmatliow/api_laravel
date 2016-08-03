<?php

use Illuminate\Database\Seeder;

class warna_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warna')->insert(['nama' => 'Merah']);
        DB::table('warna')->insert(['nama' => 'Hitam']);
        DB::table('warna')->insert(['nama' => 'Silver']);
    }
}
