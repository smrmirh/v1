<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlugwatchTable extends Migration
{

    public function up()
    {
       Schema::create("plugwatch",function(Blueprint $table){
           $table->id();
           $table->integer("agent_id");
           $table->boolean("plugged")->default(1);
           $table->integer("station_id");
           $table->dateTime("plugtime");
           $table->integer("plugged_by")->nullable(true);
       });
    }


    public function down()
    {
        Schema::dropIfExists("plugwatch");

    }
}
