<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');
            $table->double('temp_celsius');
            $table->string('status');
            $table->timestamp('last_update');
            $table->string('provider');
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
        Schema::dropIfExists('weather_stats');
    }
}
