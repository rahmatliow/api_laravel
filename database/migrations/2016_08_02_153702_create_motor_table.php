<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::Create('motor', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nama', 255);
            $table->string('foto', 255);
            $table->integer('id_merek');
            $table->string('id_warna',255);
            $table->text('features');
            $table->text('spec');
            $table->text('service');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motor', function (Blueprint $table) {
            //
        });
    }
}
