<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{

    public function run()
    {
       DB::table("departments")->insert([
           "name"       => "OPERATOR",
           "name_fa"    => "اپراتورها"
       ]);
    }
}
