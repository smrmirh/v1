<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(DoutSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(GlobalsSeeder::class);
        $this->call(StationSeeder::class);
        $this->call(TrunkSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(QueueSeeder::class);
        $this->call(QueuebindsSeeder::class);
        $this->call(StatesSeeder::class);
    }
}
