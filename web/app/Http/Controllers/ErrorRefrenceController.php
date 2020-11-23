<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorRefrenceController extends Controller
{
    public static function errors($code) {

        $errors = [
            0   => [
                "fa"        => "خطای پردازش",
                "en"        => "Internal error"
            ],

            1   => [
                "fa"        => "شما مجاز به انجام این عملیات نیستید",
                "en"        => "You are not allowed to do perform this action"

            ],
        ];


        if( isset( $errors[$code]) ) {
            return $errors[$code][config("alopad.language")];
        } else {
            $errors[0][config("alopad.language")];
        }
    }
}
