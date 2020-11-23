<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScoresTables extends Migration
{

    public function up()
    {
        Schema::create("ast_scores",function(Blueprint $table){
            $table->id();
            $table->string("agent")->nullable(true);
            $table->string("number")->nullable(true);
            $table->string('score');
            $table->string("uniqueid")->nullable(true);
            $table->string("linkedid")->nullable(true);
            $table->string("location")->nullable(true);
            $table->timestamp("updated_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("ast_scores");
    }
}
