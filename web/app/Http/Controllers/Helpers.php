<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Helpers extends Controller
{

    public static function homeAgent($member) {
        if ( preg_match("/@/",$member) ) {
            if ( preg_match("/\//",$member) ) {
                $agent = explode("@",$member);
                if ( isset($agent[0]) ) {
                    $agent = explode("/",$agent[0]);
                    if ( isset($agent[1]) ) {
                        return $agent[1];
                    }
                }
            }
        }
        return null;
    }


}
