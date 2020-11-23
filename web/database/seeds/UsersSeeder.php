<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    public function run()
    {
        DB::table("users")->insert([
            "fullname"          => "Admin",
            "fullname_fa"       => "ادمین اصلی",
            "username"          => "admin",
            "password"          => Hash::make("admin"),
            "access"            => 10,
            "ext"               => "900",
            "email"             => "abtinext@gmail.com",
            "mobile"            => "09120000000",
            "ivradmin"          => 1,

        ]);


        DB::table("users")->insert([
            "fullname"          => "Supervisor",
            "fullname_fa"       => "سوپروایزر",
            "username"          => "sp",
            "password"          => Hash::make("sp"),
            "access"            => 3,
            "ext"               => "100",
            "email"             => "supervisor@alopad.com",
            "mobile"            => "09120000000",
            "ivradmin"          => 1,
            "depid"             => 1,
        ]);


        DB::table("users")->insert([
            "fullname"          => "OPERATOR 1",
            "fullname_fa"       => "اپراتور اول",
            "username"          => "op1",
            "password"          => Hash::make("op1"),
            "access"            => 1,
            "ext"               => "101",
            "email"             => "op1@alopad.com",
            "mobile"            => "09120000000",
            "depid"             => 1,
        ]);

        DB::table("users")->insert([
            "fullname"          => "OPERATOR 2",
            "fullname_fa"       => "اپراتور دوم",
            "username"          => "op2",
            "password"          => Hash::make("op2"),
            "access"            => 1,
            "ext"               => "102",
            "email"             => "op2@alopad.com",
            "mobile"            => "09120000000",
            "depid"             => 1,
        ]);

        DB::table("users")->insert([
            "fullname"          => "OPERATOR 3",
            "fullname_fa"       => "اپراتور سوم",
            "username"          => "op3",
            "password"          => Hash::make("op3"),
            "access"            => 1,
            "ext"               => "103",
            "email"             => "op3@alopad.com",
            "mobile"            => "09120000000",
            "depid"             => 1,
        ]);

        DB::table("users")->insert([
            "fullname"          => "OPERATOR 4",
            "fullname_fa"       => "اپراتور چهارم",
            "username"          => "op4",
            "password"          => Hash::make("op4"),
            "access"            => 1,
            "ext"               => "104",
            "email"             => "op4@alopad.com",
            "mobile"            => "09120000000",
            "depid"             => 1,
        ]);

        DB::table("users")->insert([
            "fullname"          => "OPERATOR 5",
            "fullname_fa"       => "اپراتور پنجم",
            "username"          => "op5",
            "password"          => Hash::make("op5"),
            "access"            => 1,
            "ext"               => "105",
            "email"             => "op5@alopad.com",
            "mobile"            => "09120000000",
            "depid"             => 1,
        ]);

        DB::table("users")->insert([
            "fullname"          => "OPERATOR 6",
            "fullname_fa"       => "اپراتور ششم",
            "username"          => "op6",
            "password"          => Hash::make("op6"),
            "access"            => 1,
            "ext"               => "106",
            "email"             => "op6@alopad.com",
            "mobile"            => "09120000000",
            "depid"             => 1,
        ]);




    }
}
