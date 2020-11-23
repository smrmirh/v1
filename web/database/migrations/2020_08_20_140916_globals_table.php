<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GlobalsTable extends Migration
{

    public function up()
    {
        Schema::create("ast_globals",function(Blueprint $table){
            $table->id();
            $table->string("var",100);
            $table->string("value",500);
            $table->string("note",100)->nullable(true);
            $table->integer("updated_by")->nullable(true);
            $table->timestamp("updated_at");
        });
    }

    public function down()
    {
        Schema::dropIfExists("ast_globals");
    }
}
