<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QueuesTable extends Migration
{

    public function up()
    {
       Schema::create("ast_queues",function(Blueprint $table){
           $table->id();
           $table->boolean("enabled")->default(true);
           $table->integer("depid")->default(1);
           $table->string("name")->default("QUEUE");
           $table->string("name_fa")->default("صف");
           $table->boolean("by247")->default(true);
           $table->boolean("recalert")->default(true);
           $table->string("preplay")->nullable(true);
           $table->string("postplay")->nullable(true);
           $table->boolean("recording")->default(true);
           $table->boolean("voting")->default(true);
           $table->string("intro")->default("ext");
           $table->time("start")->nullable(true);
           $table->time("end")->nullable(true);
           $table->integer("dout_policy")->default(1);
           $table->integer("dout_routeid")->default(1);

           /* we may need queue params as column name */

           $table->string("_Strategyln")->nullable(true);
           $table->string("Musicclass")->default("default");
           /* --00 */

           $table->integer("updated_by")->nullable(true);
           $table->timestamp("updated_at");

       });
    }


    public function down()
    {
        Schema::dropIfExists("ast_queues");
    }
}
