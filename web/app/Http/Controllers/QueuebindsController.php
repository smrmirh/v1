<?php

namespace App\Http\Controllers;

use App\Models\Logwatch;
use Illuminate\Http\Request;
use App\Models\QueueBinds;
use App\Models\Queues;
//use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\DB;

class QueuebindsController extends Controller
{
    public static function getAgentBinds($agent_id, $ifEnabled = true , $ifBinded = false) {
        $binds = QueueBinds::where("agent_id",$agent_id);
        if ( $ifEnabled ) {
            $binds->where("enabled",true);
        }
        if ( $ifBinded ) {
            $binds->where("binded",true);
        }
        $result = $binds->get();

        if ( ! $result ) {
            return false;
        }
        $finalbinds = array();
        foreach($result as $v) {
            $finalbinds[(int) $v["queue_id"]] = $v;
        }
        return $finalbinds;
    }



    public static function bind($agent_id,$queue_id,$station_id) {
        $bind = QueueBinds::where("agent_id",$agent_id);
        if ( $queue_id ) {
            $bind->where("queue_id",$queue_id);
        }
        $bind->update([
            "station_id"    => $station_id,
            "binded"        => true,
            "binded_at"     => date("Y-m-d H:i:s")
        ]);
    }


    public static function unbind($agent_id,$queue_id) {
        $bind = QueueBinds::where("agent_id",$agent_id);
        if ( $queue_id ) {
            $bind->where("queue_id",$queue_id);
        }
        $bind->where("binded",true);
        $bind->update([
            "station_id"    => null,
            "binded"        => false,
            "binded_at"     => date("Y-m-d H:i:s")
        ]);
    }


    public static function logwatchBegin($agent_id,$station_id,$queue_id,$by = "",$reason = "") {
        $logwatch = new Logwatch();
        $logwatch->agent_id = $agent_id;
        $logwatch->station_id = $station_id;
        $logwatch->queue_id = $queue_id;
        $logwatch->logged_in = date("Y-m-d H:i:s");
        $logwatch->logged_in_by = $by;
        $logwatch->note = $reason;
        $logwatch->save();
    }

    public static function logwatchTerminate($agent_id,$queue_id, $by = "", $reason = "") {
        $logwatch = Logwatch::where("agent_id",$agent_id);
        if (  $queue_id ) {
            $logwatch->where("queue_id",$queue_id);
        }
        $logwatch->where("closed",false);

        return $logwatch->update([
            "logged_out"    => date("Y-m-d H:i:s"),
            "logged_out_by" => $by,
            "note"          => $reason,
            "closed"        => true,
            "duration"      => DB::raw("TIME_TO_SEC(TIMEDIFF(NOW(),logged_in))/60")
        ]);


    }


    public static function getQueueNameById($queue_id) {
        $queue =  Queues::select("name")->where("id",$queue_id)->where("enabled",true)->first();
        if ( ! $queue ) {
            return false;
        }
        return $queue["name"];
    }


    public static function hasBind($agent_id,$queue_id) {
        return QueueBinds::where("agent_id",$agent_id)->where("queue_id",$queue_id)->count();
    }

    public static function createBind($agent_id,$queue_id) {
        $newBind = new QueueBinds();
        $newBind->agent_id = $agent_id;
        $newBind->queue_id = $queue_id;
        $newBind->save();
    }


    public static function removeBind($agent_id,$queue_id) {
        $removeBind = QueueBinds::where("agent_id",$agent_id);
        if (  $queue_id ) {
            $removeBind->where("queue_id",$queue_id);
        }
        return $removeBind->delete();
    }

    public static function disableBind($agent_id,$queue_id) {
        $removeBind = QueueBinds::where("agent_id",$agent_id);
        if (  $queue_id ) {
            $removeBind->where("queue_id",$queue_id);
        }
        $removeBind->update(["enabled" => false]);
    }

    public static function enableBind($agent_id,$queue_id) {
        $removeBind = QueueBinds::where("agent_id",$agent_id);
        if (  $queue_id ) {
            $removeBind->where("queue_id",$queue_id);
        }
        $removeBind->update(["enabled" => true]);
    }


    public static function bindSyncer($agent_id) {
        $ext = AgentController::ext($agent_id);
        $queueStatus = QueuesController::queueStatus(false,"Local/$ext@home-agents");


        if ( ! $queueStatus["result"] ) {
            return array(
                "result"    => false,
                "error"     => "Unable to sync binding due to AMI Problem"
            );
        }

        $activeBinds = self::getAgentBinds($agent_id,false,false);

        if ( ! $activeBinds ) {
            // Agent has no binding! So remove him from every Queue
            $queueRemove = 0;
            foreach( $queueStatus as $k=>$queue ) {
                if ( isset( $queue["member"][$ext] ) ) {
                    $remove = QueuesController::RemoveQueueMemberByExt($k,$ext);
                    if ( $remove["result"] ) {
                        $queueRemove++;
                    }
                }
            }
            return array(
                "result"    => true,
                "message"   => "BindSyncer completed with QueueRemove($queueRemove)"
            );

        }

        // Here
        $agentBinds = self::getAgentBinds($agent_id,false,false);
        $queueRemove = 0;
        $queueAdd = 0;

        foreach( $queueStatus["queues"] as $queue_name=>$queue ) {

            $queue_id = QueuesController::getQueueIdByName($queue_name);

            // Here : Queue does not exist anymore or been disabled on database
            if ( ! $queue_id ) {
                $remove = QueuesController::RemoveQueueMemberByExt($queue_name,$ext);
                if ( $remove["result"] ) {
                    $queueRemove++;
                }
            } else {
                // Here : Queue is enabled. Checking if Agent bind is active on this queue;
                if ( isset($agentBinds[$queue_id])) {
                    if ( $agentBinds[$queue_id]["enabled"]) {
                        // Agent should be in Queue
                        // 1 : Checking if Agent does not exist, then add it
                        if ( ! isset( $queue["members"][$ext] ) ) {
                            $add = QueuesController::AddQueueMemberByExt($queue_name,$ext);
                            if ( $add["result"] ) {
                                $queueAdd++;
                            }
                        }
                    } else {
                        // Agent should not be in Queue
                        if ( isset($queue["members"][$ext])) {
                            $remove = QueuesController::RemoveQueueMemberByExt($queue_name,$ext);
                            if ( $remove["result"] ) {
                                $queueRemove++;
                            }
                        }
                    }
                }
            } // end of ELSE

        } // End of foreach

        return array(
            "result"    => true,
            "message"   => "bindSyner done. QueueRemove($queueRemove), QueueAdd($queueAdd)"
        );

    } // end of method

}
