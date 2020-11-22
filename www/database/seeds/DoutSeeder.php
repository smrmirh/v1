<?php

use Illuminate\Database\Seeder;


class DoutSeeder extends Seeder
{

    public function run()
    {
        DB::table("ast_dout")->insert([
            "name"      => "FULL",
            "internal"  => 1,
            "tollfree"  => 1,
            "instate"   => 1,
            "outstate"  => 1,
            "mobile"    => 1,
            "international" => 1,
            "note"  => "Full access route",
            "updated_at"    => date("Y-m-d H:i:s")
        ]);

        DB::table("ast_dout")->insert([
            "name"      => "RESTRICTED",
            "internal"  => 0,
            "tollfree"  => 0,
            "instate"   => 0,
            "outstate"  => 0,
            "mobile"    => 0,
            "international" => 0,
            "note"  => "No access route",
            "updated_at"    => date("Y-m-d H:i:s")
        ]);

        DB::table("ast_dout")->insert([
            "name"      => "INTERNAL",
            "internal"  => 1,
            "tollfree"  => 0,
            "instate"   => 0,
            "outstate"  => 0,
            "mobile"    => 0,
            "international" => 0,
            "note"  => "Local access route",
            "updated_at"    => date("Y-m-d H:i:s")
        ]);

        DB::table("ast_dout")->insert([
            "name"      => "STATE",
            "internal"  => 1,
            "tollfree"  => 1,
            "instate"   => 1,
            "outstate"  => 0,
            "mobile"    => 0,
            "international" => 0,
            "note"  => "State access route",
            "updated_at"    => date("Y-m-d H:i:s")
        ]);

        DB::table("ast_dout")->insert([
            "name"      => "NATIONAL",
            "internal"  => 1,
            "tollfree"  => 1,
            "instate"   => 1,
            "outstate"  => 1,
            "mobile"    => 1,
            "international" => 0,
            "note"  => "National access route",
            "updated_at"    => date("Y-m-d H:i:s")
        ]);

        DB::table("ast_dout")->insert([
            "name"      => "INTERNATIONAL",
            "internal"  => 1,
            "tollfree"  => 1,
            "instate"   => 1,
            "outstate"  => 1,
            "mobile"    => 1,
            "international" => 1,
            "note"  => "Full access route",
            "updated_at"    => date("Y-m-d H:i:s")
        ]);
    }
}
