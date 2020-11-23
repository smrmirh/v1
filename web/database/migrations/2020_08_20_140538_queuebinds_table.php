<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QueuebindsTable extends Migration
{

    public function up()
    {
       Schema::create("queuebinds",function(Blueprint $table){
           $table->id();
           $table->boolean("enabled")->default(true);
           $table->integer("queue_id");
           $table->integer("agent_id");
           $table->integer("station_id")->nullable(true);
           $table->boolean("binded")->default(false);
           $table->datetime("binded_at")->nullable(true);
           $table->integer("updated_by")->nullable(true);
           $table->timestamp("updated_at");
       });
    }


    public function down()
    {
        Schema::dropIfExists("queuebinds");
    }
}
