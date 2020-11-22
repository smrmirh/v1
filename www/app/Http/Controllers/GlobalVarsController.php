<?php

namespace App\Http\Controllers;

use App\Models\GlobalVars;
use Illuminate\Http\Request;

class GlobalVarsController extends Controller
{
    public static function get($var) {
        $value = GlobalVars::select("value")->where("var",$var)->first();

        if ( ! $value ) {
            return null;
        }

        if ( ! isset($value["value"]) ) {
            return false;
        }

        if ( $value["value"] == "true" ) {
            return true;
        }

        if ( $value["value"] == 'false' ) {
            return false;
        }

        if ( is_numeric($value["value"]) ) {
            return (int) $value["value"];
        }

        return $value["value"];
    }

    public static function all() {
        $datas = GlobalVars::select("id","var","value")->get();

        $val = false;
        $globals = array();
        foreach($datas as $data) {
            if ( $data["value"] == "true" ) {
                $val = true;
            } elseif ( $data["value"] == "false" ) {
                $val = false;
            } elseif ($data["value"] == "1" ) {
                $val = true;
            } else if ( $data["value"] == "0" ) {
                $val = false;
            } else {
                $val = $data["value"];
            }
            $globals[$data["var"]] = array(
                "id"    => $data["id"],
                "val"   => $val
            );
        }

        return $globals;

    }
}
