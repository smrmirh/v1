<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StationsTable extends Migration
{

    public function up()
    {
        Schema::create("stations",function(Blueprint $table){
            $table->id();
            $table->boolean("enabled")->default(true);
            $table->string("peer")->nullable(true);
            $table->string("peer_fa")->nullable(true);
            $table->string("secret")->nullable(true);
            $table->string("type")->default("friend");
            $table->string("context")->nullable(true);
            $table->string("host")->default("dynamic");
            $table->string("qualify")->default("yes");
            $table->boolean("registered")->default(false);
            $table->string("ip")->nullable(true);
            $table->dateTime("lastregister")->nullable(true);
            $table->dateTime("lastunregister")->nullable(true);
            $table->integer("max")->default(1);
            $table->integer("loggers")->nullable(true);
            $table->string("lastlogger")->nullable(true);
            $table->boolean("dout")->default(false);
            $table->integer("dout_policy")->nullable(true);
            $table->integer("dout_routeid")->nullable(true);
            $table->integer("updated_by")->nullable(true);
            $table->timestamp("updated_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("stations");
    }
}
