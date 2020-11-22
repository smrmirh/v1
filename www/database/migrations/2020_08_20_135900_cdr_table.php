<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CdrTable extends Migration
{

    public function up()
    {
        /*
        Schema::create("ast_cdr",function(Blueprint $table){
            $table->string("ctype")->nullable(true);
            $table->timestamp("calldate");
            $table->string("number")->nullable(true);
            $table->string("agent")->nullable(true);
            $table->string("src")->nullable(true);
            $table->string("dst")->nullable(true);
            $table->string("station")->nullable(true);
            $table->integer("aid")->nullable(true);
            $table->integer("depid")->nullable(true);
            $table->integer("qid")->nullable(true);
            $table->integer("xferby")->nullable(true);
            $table->integer("xferto")->nullable(true);
            $table->integer("fwdby")->nullable(true);
            $table->integer("fwdto")->nullable(true);
            $table->string("dcontext",100)->nullable(true);
            $table->string("channel",80)->nullable(true);
            $table->string("dstchannel",80)->nullable(true);
            $table->string("disposition",30)->nullable(true);
            $table->integer("duration")->nullable(true);
            $table->integer("billsec")->nullable(true);
            $table->integer("score")->nullable(true);
            $table->integer("outgoing")->default(0);
            $table->string("recordingfile")->nullable(true);
            $table->string("uniqueid",40)->nullable(true);
            $table->string("linkedid",40)->nullable(true);
            $table->string("lastdata",200)->nullable(true);
            $table->string("lastapp",100)->nullable(true);
            $table->string("did",20)->nullable(true);
            $table->string("numtype",10)->nullable(true);
            $table->integer("sequence")->default(0);
            $table->string("accountcode",20)->nullable(true);
            $table->integer("amaflags")->default(0);
            $table->string("userfield",255)->nullable(true);
            $table->string("clid",30)->nullable(true);
            $table->string("cnum",80)->nullable(true);
            $table->string("cnam",80)->nullable(true);
            $table->string("outbound_cnum",30)->nullable(true);
            $table->string("outbound_cnam",100)->nullable(true);
            $table->string("dst_cnam",80)->nullable(true);
            $table->string("peeraccount",80)->nullable(true);
            $table->string("external_id")->nullable(true);
        });
        */

    }


    public function down()
    {

       //Schema::dropIfExists("ast_cdr");
    }
}
