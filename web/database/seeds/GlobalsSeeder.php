<?php

use Illuminate\Database\Seeder;

class GlobalsSeeder extends Seeder
{

    public function run()
    {
        DB::table("ast_globals")->insert([
            "var"       => "DEVMODE",
            "value"     => "1"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "MULTIPLUG",
            "value"     => "0"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "EXTERNAL",
            "value"     => "0"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "STATEID",
            "value"     => "1"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "STATENAME",
            "value"     => "TEHRAN"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "STATECODE",
            "value"     => "021"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "STNFIRSTLOGGER",
            "value"     => "1"
        ]);

        DB::table("ast_globals")->insert([
            "var"       => "DEFAULTROUTEID",
            "value"     => "1"
        ]);
    }
}
