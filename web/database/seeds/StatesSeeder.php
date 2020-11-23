<?php

use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{

    public function run()
    {
        DB::table("states")->insert([
            "name"      => "Tehran",
            "name_fa"      => "تهران",
            "code"      => "021",
        ]);

        DB::table("states")->insert([
            "name"      => "Alborz",
            "name_fa"   => "البرز",
            "code"      => "026"
        ]);

        DB::table("states")->insert([
            "name"      => "Qom",
            "name_fa"   => "قم",
            "code"      => "025"
        ]);

        DB::table("states")->insert([
            "name"      => "Markazi",
            "name_fa"   => "مرکزی",
            "code"      => "086"
        ]);

        DB::table("states")->insert([
            "name"      => "Zanjan",
            "name_fa"   => "زنجان",
            "code"      => "024"
        ]);

        DB::table("states")->insert([
            "name"      => "Semnan",
            "name_fa"   => "سمنان",
            "code"      => "023"
        ]);

        DB::table("states")->insert([
            "name"      => "Hamedan",
            "name_fa"   => "همدان",
            "code"      => "081"
        ]);

        DB::table("states")->insert([
            "name"      => "Qazvin",
            "name_fa"   => "قزوین",
            "code"      => "028"
        ]);

        DB::table("states")->insert([
            "name"      => "Isfahan",
            "name_fa"   => "اصفهان",
            "code"      => "031"
        ]);

        DB::table("states")->insert([
            "name"      => "Azerbayejan-West",
            "name_fa"   => "آذربایجان غربی",
            "code"      => "044"
        ]);

        DB::table("states")->insert([
            "name"      => "Mazandaran",
            "name_fa"   => "مازندران",
            "code"      => "011"
        ]);

        DB::table("states")->insert([
            "name"      => "K&B",
            "name_fa"   => "کهکیلویه و بویراحمد",
            "code"      => "074"
        ]);

        DB::table("states")->insert([
            "name"      => "Kermanshah",
            "name_fa"   => "کرمانشاه",
            "code"      => "083"
        ]);

        DB::table("states")->insert([
            "name"      => "Khorasan Razavi",
            "name_fa"   => "خراسان رضوی",
            "code"      => "051"
        ]);

        DB::table("states")->insert([
            "name"      => "Ardebil",
            "name_fa"   => "اردبیل",
            "code"      => "045"
        ]);

        DB::table("states")->insert([
            "name"      => "Golestan",
            "name_fa"   => "گلستان",
            "code"      => "017"
        ]);

        DB::table("states")->insert([
            "name"      => "Azerbayejan-East",
            "name_fa"   => "آذربایجان شرقی",
            "code"      => "041"
        ]);

        DB::table("states")->insert([
            "name"      => "S&B",
            "name_fa"   => "سیستان و بلوچستان",
            "code"      => "054"
        ]);

        DB::table("states")->insert([
            "name"      => "Kordestan",
            "name_fa"   => "کردستان",
            "code"      => "087"
        ]);

        DB::table("states")->insert([
            "name"      => "Fars",
            "name_fa"   => "فارس",
            "code"      => "071"
        ]);

        DB::table("states")->insert([
            "name"      => "Lorestan",
            "name_fa"   => "لرستان",
            "code"      => "066"
        ]);

        DB::table("states")->insert([
            "name"      => "Kerman",
            "name_fa"   => "کرمان",
            "code"      => "034"
        ]);

        DB::table("states")->insert([
            "name"      => "Khorasan South",
            "name_fa"   => "خراسان جنوبی",
            "code"      => "056"
        ]);

        DB::table("states")->insert([
            "name"      => "Guilan",
            "name_fa"   => "گیلان",
            "code"      => "013"
        ]);

        DB::table("states")->insert([
            "name"      => "Booshehr‌",
            "name_fa"   => "بوشهر",
            "code"      => "077"
        ]);

        DB::table("states")->insert([
            "name"      => "Hormozgan",
            "name_fa"   => "هرمزگان",
            "code"      => "076"
        ]);

        DB::table("states")->insert([
            "name"      => "Khozestan",
            "name_fa"   => "خوزستان",
            "code"      => "061"
        ]);

        DB::table("states")->insert([
            "name"      => "C&B",
            "name_fa"   => "چهارمحال و بختیاری",
            "code"      => "038"
        ]);

        DB::table("states")->insert([
            "name"      => "Khorasan North",
            "name_fa"   => "خراسان شمالی",
            "code"      => "058"
        ]);

        DB::table("states")->insert([
            "name"      => "Yazd",
            "name_fa"   => "یزد",
            "code"      => "035"
        ]);

        DB::table("states")->insert([
            "name"      => "Ilam",
            "name_fa"   => "ایلام",
            "code"      => "084"
        ]);


    }
}
