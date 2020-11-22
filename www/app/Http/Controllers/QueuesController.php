<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queues as QueuesDB;

class QueuesController extends Controller
{
    public static function getAllQueuesFromDB() {

        $response = QueuesDB::select("id","name","depid","recalert","voting")->where("enabled",true)->get();
        //return $response;
        if ( ! $response ) {
            return false;
        }

        $queues = array();
        foreach( $response as $res) {
            $queues[$res["id"]] =  $res;
        }

        return $queues;
    }

    public static function getQueueNameById($queue_id) {
        $queue =  QueuesDB::select("name")->where("id",$queue_id)->where("enabled",true)->first();
        if ( ! $queue ) {
            return false;
        }
        return $queue["name"];
    }

    public static function getQueueIdByName($queue_name) {
        $queue =  QueuesDB::select("id")->where("name",$queue_name)->first();
        if ( ! $queue ) {
            return false;
        }
        return $queue["id"];
    }

    public static function getQueueFromDB($queue_id) {
        return QueuesDB::select("id","name","depid")->where("enabled",true)->where("id",$queue_id)->first();
    }

    public static function queueStatus($queue_name = false , $agent_ext = false) {
        $ami = new AmiActionController();
        return $ami->QueueStatus($queue_name,$agent_ext);
    }

    public static function RemoveQueueMemberByExt($queue_name,$agent_ext) {
        $ami = new AmiActionController();
        return  $ami->QueueRemove($queue_name,"Local/$agent_ext@home-agents");
    }

    public static function AddQueueMemberByExt($queue_name,$agent_ext) {
        $ami = new AmiActionController();
        $add =  $ami->QueueAdd($queue_name,"Local/$agent_ext@home-agents");

        if ( $add["result"] ) {
            $pause = new AmiActionController();
            $pauser = $pause->QueuePause("Local/$agent_ext@home-agents",$queue_name,"-");
            return array(
                "result"    => true,
                "message"   => $add["message"]
            );
        }

        return $add;
    }


}
