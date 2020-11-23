<?php

use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{

    public function run()
    {
        DB::table("stations")->insert([
            "peer"          => "S0001",
            "peer_fa"       => "ایستگاه یک",
            "secret"        => "S0001",
            "context"       => "ava-internal",
            "host"          => "dynamic",
            "qualify"       => "yes",
        ]);

        DB::table("stations")->insert([
            "peer"          => "S0002",
            "peer_fa"       => "ایستگاه دو",
            "secret"        => "S0002",
            "context"       => "ava-internal",
            "host"          => "dynamic",
            "qualify"       => "yes",
        ]);

        DB::table("stations")->insert([
            "peer"          => "S0003",
            "peer_fa"       => "ایستگاه سه",
            "secret"        => "S0003",
            "context"       => "ava-internal",
            "host"          => "dynamic",
            "qualify"       => "yes",
        ]);

        DB::table("stations")->insert([
            "peer"          => "S0004",
            "peer_fa"       => "ایستگاه چهار",
            "secret"        => "S0004",
            "context"       => "ava-internal",
            "host"          => "dynamic",
            "qualify"       => "yes",
        ]);

        DB::table("stations")->insert([
            "peer"          => "S0005",
            "peer_fa"       => "ایستگاه پنج",
            "secret"        => "S0005",
            "context"       => "ava-internal",
            "host"          => "dynamic",
            "qualify"       => "yes",
        ]);

        DB::table("stations")->insert([
            "peer"          => "S0006",
            "peer_fa"       => "ایستگاه شش",
            "secret"        => "S0006",
            "context"       => "ava-internal",
            "host"          => "dynamic",
            "qualify"       => "yes",
        ]);
    }
}
