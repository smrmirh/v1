<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrunksTable extends Migration
{

    public function up()
    {
        Schema::create("ast_trunks",function(Blueprint $table){
            $table->id();
            $table->boolean("enabled")->default(true);
            $table->string("name")->nullable(true);
            $table->string("host")->nullable(true);
            $table->string("type")->nullable(true);
            $table->boolean("gsm")->default(false);
            $table->string("prepend")->nullable(true);
            $table->integer("defaultroute")->nullable(true);
            $table->integer("created_by")->nullable(true);
            $table->timestamp("updated_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("ast_trunks");
    }
}
