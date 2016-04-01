<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casinos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('longitude', 10, 6);
            $table->decimal('latitude', 10, 6);
            $table->string('opening_times')->nullable();
            $table->string('web_address')->nullable();
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
        Schema::drop('casinos');
    }
}
