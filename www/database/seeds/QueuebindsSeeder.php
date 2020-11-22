<?php

use Illuminate\Database\Seeder;

class QueuebindsSeeder extends Seeder
{

    public function run()
    {

        // Admin
       DB::table("queuebinds")->insert([
           "enabled"    => 1,
           "queue_id"   => 1,
           "agent_id"   => 1,
       ]);


        // OP 1
        DB::table("queuebinds")->insert([
            "enabled"    => 1,
            "queue_id"   => 1,
            "agent_id"   => 2,
        ]);


        // OP 2
        DB::table("queuebinds")->insert([
            "enabled"    => 1,
            "queue_id"   => 1,
            "agent_id"   => 3,
        ]);


        // OP 3
        DB::table("queuebinds")->insert([
            "enabled"    => 1,
            "queue_id"   => 1,
            "agent_id"   => 4,
        ]);


        // OP 4
        DB::table("queuebinds")->insert([
            "enabled"    => 1,
            "queue_id"   => 1,
            "agent_id"   => 5,
        ]);

        DB::table("queuebinds")->insert([
            "enabled"    => 1,
            "queue_id"   => 1,
            "agent_id"   => 6,
        ]);


        DB::table("queuebinds")->insert([
            "enabled"    => 1,
            "queue_id"   => 1,
            "agent_id"   => 7,
        ]);

    }
}
