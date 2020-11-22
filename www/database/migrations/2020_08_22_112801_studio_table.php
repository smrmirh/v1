<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudioTable extends Migration
{

    public function up()
    {
        Schema::create("studio",function(Blueprint $table){
            $table->id();
            $table->string("filename");
            $table->string("created_by")->nullable(true);
            $table->timestamp("created_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("studio");
    }
}
