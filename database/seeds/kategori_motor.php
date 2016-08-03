<?php

use Illuminate\Database\Seeder;

class kategori_motor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('kategori_motor')->insert(['nama' => 'Motor Klasik']);
        DB::table('kategori_motor')->insert(['nama' => 'Motor Sport']);
        DB::table('kategori_motor')->insert(['nama' => 'Motor Sport']);
    }
}
