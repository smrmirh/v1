<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DoutTable extends Migration
{

    public function up()
    {
        Schema::create("ast_dout",function(Blueprint $table){
            $table->id();
            $table->string("name",50);
            $table->boolean("internal")->default(true);
            $table->boolean("tollfree")->default(true);
            $table->boolean("instate")->default(false);
            $table->boolean("outstate")->default(false);
            $table->boolean("mobile")->default(false);
            $table->boolean("international")->default(false);
            $table->string("note",200)->nullable(true);
            $table->integer("updated_by")->nullable(true);
            $table->timestamp("updated_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("ast_dout");
    }
}
