<?php

use Illuminate\Database\Seeder;

class TrunkSeeder extends Seeder
{

    public function run()
    {
        DB::table("ast_trunks")->insert([
            "name"      => "TCI",
            "host"      => "10.98.21.20",
            "type"      => "friend",
            "gsm"       => false,
        ]);
    }
}
