<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntersectionToStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intersection_to_stations', function (Blueprint $table) {
            $table->unsignedInteger('intersection_id');
            $table
                ->foreign('intersection_id')
                ->references('id')
                ->on('intersections')
                ->onDelete('cascade');
            $table->unsignedInteger('station_id');
            $table
                ->foreign('station_id')
                ->references('id')
                ->on('stations')
                ->onDelete('cascade');
            $table->primary(['intersection_id', 'station_id']);
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
        Schema::dropIfExists('intersection_to_stations');
    }
}
