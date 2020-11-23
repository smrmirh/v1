<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogwatchTable extends Migration
{

    public function up()
    {
        Schema::create("logwatch",function(Blueprint $table){
            $table->id();
            $table->integer("agent_id");
            $table->integer("station_id");
            $table->integer("queue_id");
            $table->dateTime("logged_in");
            $table->string("logged_in_by")->nullable(true);
            $table->datetime("logged_out")->nullable(true);
            $table->string("logged_out_by")->nullable(true);
            $table->integer("duration")->default(0);
            $table->boolean("closed")->default(false);
            $table->string("note")->default(null);
            $table->integer("updated_by")->nullable(true);
            $table->timestamp("updated_at");


        });
    }


    public function down()
    {
       Schema::dropIfExists("logwatch");
    }
}
