<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;

class PeersController extends Controller
{
    public static function ConsolePeers( $type = "station") {

        $peers = new AmiActionController();
        $peers = $peers->SIPPeers();

        if ( ! $peers["result"] ) {
            return array(
                "result"    => false,
                "error"     => $peers["error"]
            );
        }

        $stations = array();
        foreach($peers["sippeers"] as $k=>$v) {
            if ( $v["type"] == $type ) {
                $stations[$k] = $v;
            }
        }

        if ( count($stations) < 1 ) {
            return array(
                "result"    => false,
                "error"     => "No station found in the list"
            );
        }

        return array(
            "result"        => true,
            "message"       => "Got fishes for you",
            "stations"      => $stations
        );
    }

    public static function AgentsOnStation($station_id) {

        $station_name = self::getStationNameById($station_id);
        $all = Models\Users::select("id")->where("station",$station_name)->get();

        if ( count($all) < 1 ) {
            return false;
        }
        $agents = array();
        foreach( $all as $v  ) {
            array_push($agents,$v["id"]);
        }

        return $agents;

    }

    public static function getStationNameById($id) {
        $station =  Models\Stations::select("peer")->where("id",$id)->where("enabled",true)->first();
        if ( $station ) {
            if ( isset($station["peer"]) ) {
                return $station["peer"];
            }
        }
        return false;
    }

    public static function getStationIdByName($peer) {

        if ( $peer == "external" ) {
            return "external";
        }

        $id =  Models\Stations::select("id")->where("peer",$peer)->first();

        if ( ! $id ) {
            return false;
        }

        return $id["id"];
    }

    public static function IsStationEnabled($station_id) {
        $station = Models\Stations::where("id",$station_id)->where("enabled",true)->first();
        if ( $station ) {
            return true;
        }
        return false;
    }

    public static function whoAreUsingThisStation($station_name) {
        $whoAreUsingThisStationCount = Models\Users::where("station",$station_name)->count();
        if ( ! $whoAreUsingThisStationCount ) {
            return false;
        }

        $agents = Models\Users::select("id","ext")->where("station",$station_name)->get();
        $who = array();
        foreach($agents as $agent) {
            $who[(int) $agent["id"]] = $agent;
        }
        return $who;
    }
}
