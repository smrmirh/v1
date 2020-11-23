<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FeaturecodesTable extends Migration
{

    public function up()
    {
        Schema::create("featurecodes",function (Blueprint $table){
            $table->id();
            $table->boolean("enabled")->default(true);
            $table->string("code")->unique();
            $table->string("filename")->nullable(true);
            $table->integer("created_by")->nullable(true);
            $table->timestamp("updated_at");
        });
    }


    public function down()
    {
        Schema::dropIfExists("featurecodes");

    }
}
