<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatesTable extends Migration
{

    public function up()
    {
        Schema::create("states",function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->string("name_fa");
            $table->string("code")->unique();
            $table->timestamp("updated_at");
        });

    }

    public function down()
    {
        Schema::dropIfExists("states");
    }
}
