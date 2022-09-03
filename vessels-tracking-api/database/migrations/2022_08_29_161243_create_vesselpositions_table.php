<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessel_positions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('mmsi');
            $table->integer('status');
            $table->integer('station');
            $table->integer('speed');
            $table->float('lon');
            $table->float('lat');
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot');
            $table->timestamp('timestamp');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vesselpositions');
    }
};
