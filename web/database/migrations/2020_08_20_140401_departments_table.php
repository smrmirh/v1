<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DepartmentsTable extends Migration
{

    public function up()
    {
        Schema::create("departments",function(Blueprint $table){
            $table->id();
            $table->boolean("enabled")->default(true);
            $table->string("name");
            $table->string("name_fa");
            $table->integer("updated_by")->nullable(true);
            $table->timestamp("updated_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("departments");

    }
}
