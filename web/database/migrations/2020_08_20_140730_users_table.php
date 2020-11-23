<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{

    public function up()
    {

        Schema::create('users',function(Blueprint $table){
            $table->id();
            $table->boolean("enabled")->default(1);
            $table->boolean("plugged")->default(0);
            $table->string("username")->unique();
            $table->string("password","200")->nullable(true);
            $table->string("fullname")->default("OPERATOR");
            $table->string("fullname_fa")->default("اپراتور");
            $table->integer("access")->default(1);
            $table->string("ext");
            $table->string("external")->nullable(true);
            $table->string("station")->nullable(true);
            $table->string("mobile")->nullable(true);
            $table->string("email","200")->unique();
            $table->string("pin")->nullable(true);
            $table->boolean("agent")->default(false);
            $table->boolean("ivradmin")->default(false);
            $table->boolean("divert")->default(false);
            $table->boolean("dnd")->default(false);
            $table->boolean("vm")->default(false);
            $table->boolean("fax")->default(false);
            $table->string("did")->nullable(true);
            $table->boolean("record_in")->default(true);
            $table->boolean("record_out")->default(true);
            $table->boolean("vote_in")->default(true);
            $table->boolean("vote_out")->default(false);
            $table->boolean("callwaiting")->default(false);
            $table->boolean("campon")->default(false);
            $table->integer("depid")->nullable(true);
            $table->integer("secid")->nullable(true);
            $table->integer("ringtime")->default(40);
            $table->integer("dout_policy")->default(1);
            $table->integer("dout_routeid")->default(1);
            $table->integer("dout_timer")->default(40);
            $table->boolean("notify_missmail")->default(false);
            $table->boolean("notify_vmmail")->default(false);
            $table->boolean("notify_faxmail")->default(false);
            $table->boolean("allowexternal")->default(true);
            $table->dateTime("birthday")->nullable(true);
            $table->datetime("lsl")->nullable(true);
            $table->string("sessid")->nullable(true);
            $table->integer("updated_by")->nullable(true);
            $table->timestamp("updated_at");
            $table->rememberToken();
        });


    }

    public function down()
    {
        Schema::dropIfExists("users");
    }
}
