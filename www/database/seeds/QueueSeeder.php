<?php

use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{

    public function run()
    {
       DB::table("ast_queues")->insert([
           "name"       => "Q1",
           "name_fa"    => "امور مشترکین",
           "depid"      => 1,
           "intro"      => "ext",
           "recalert"   => 1

       ]);



    }
}
