<?php

namespace App\Http\Controllers;


use App\Models\QueueBinds;
use App\Models\Users as Users;
use App\User;
use Illuminate\Http\Request;
use App\Models\Plugwatch as Plugwatch;
use App\Models\Logwatch as Logwatch;
use App\Models\Stations as Stations;
use App\Models\Queues as Queues;

class AgentController extends Controller
{

    public static function login($agent_id,$queue_id,$by,$reason) {
        if ( ! self::isPlugged($agent_id) ) {
            return array(
                "result"    => false,
                "error"     => "Unable to proceed, Agent must be plugged first"
            );
        }

        $activeBinds = QueuebindsController::getAgentBinds($agent_id,true,false);

        if ( ! $activeBinds ) {
            return array(
                "result"    => false,
                "error"     => "No active bind found for Agent($agent_id)"
            );
        }


        // Station and Extensoion Validation
        $currentStationId = self::getCurrentStationId($agent_id);
        if ( ! $currentStationId ) {
            return array(
                "result"    => false,
                "error"     => "Unable to get current station for Agent($agent_id). Try to re-plug first"
            );
        }

        $ext = self::ext($agent_id);
        if ( ! $ext ) {
            return array(
                "result"    => false,
                "error"     => "Unable to find Extension-Number for Agent($agent_id). Contact administrator"
            );
        }


        // For external we re-value it back to 0 -- Escaping above validation
        if ( $currentStationId == "external" ) {
            $currentStationId = 0;
        }


        // Request to login on All-queues
        // $queue_id = false
        if ( ! $queue_id  ) {
            $total_binds = 0;
            $already_bound = 0;
            $failed_bind = 0;

            foreach($activeBinds as $binds ) {
                if ( ! $binds["binded"] ) {
                    $ami = new AmiActionController();
                    $unpauser = $ami->QueueUnpause("Local/$ext@home-agents",false,$reason);

                    if ( $unpauser["result"]) {
                        $total_binds++;
                        QueuebindsController::bind($agent_id,$binds["queue_id"],$currentStationId);
                        QueuebindsController::logwatchBegin($agent_id,$currentStationId,$binds["queue_id"],$by,$reason);
                    } else {
                        $failed_bind++;
                    }

                } else {
                    $already_bound++;
                }
            }
            if ( $total_binds > 0 ) {
                return array(
                    "result"    => $total_binds > 0 ? true : false,
                    "message"   => "Binding result for agent($ext) :  TotalBinds($total_binds), CurrentBinds($already_bound), FailedBind($failed_bind)"
                );
            } elseif ( $already_bound == count($activeBinds)) {
                return array(
                    "result"    => true,
                    "message"   => "Agent($ext) already logged in all queues. CurrentBinds($already_bound)"
                );
            } else {
                return array(
                    "result"    => false,
                    "error"     => "Unable to logged in : FailedBind($failed_bind)"
                );
            }
        }


        // $queue_id is specified for particular queue!
        // Which means : Login requested for single queue
        $queue_name = QueuebindsController::getQueueNameById($queue_id);
        if ( ! $queue_name ) {
            return array(
                "result"    => false,
                "error"     => "Unable to find the requested queue. Queue not exist or has been disabled"
            );
        }

        if ( ! isset($activeBinds[$queue_id]) ) {
            return array(
                "result"    => false,
                "error"     => "Unable to find any bind for agent($ext) on $queue_name($queue_id)"
            );
        }

        if ( $activeBinds[$queue_id]["binded"] ) {
            return array(
                "result"    => true,
                "message"   => "Agent($ext) is already bound to Queue($queue_name). No action required"
            );
        } else {
            // Here we proceed single login for agent
            $ami = new AmiActionController();
            $unpauser = $ami->QueueUnpause("Local/$ext@home-agents",$queue_name,$reason);
            if ( $unpauser["result"]) {
                QueuebindsController::bind($agent_id,$queue_id,$currentStationId);
                QueuebindsController::logwatchBegin($agent_id,$currentStationId,$queue_id,$by,$reason);
                return array(
                    "result"    => true,
                    "message"   => "Agent($ext) is now bound to Queue($queue_name) : " . $unpauser["message"]
                );
            }
            else {
                return array(
                    "result"    => false,
                    "error"     => "Unable to bind Agent($ext) to Qeueu($queue_name). " . $unpauser["error"]
                );
            }

        }

    }

    public static function logout($agent_id,$queue_id,$by,$reason) {

        $ext = self::ext($agent_id);

        /* Maybe not required at all
         * Validation is done before reaching here
         *
         */
        if ( ! $ext ) {
            return array(
                "result"    => false,
                "error"     => "Invalid Agent"
            );
        }


        // Here : Logout requested for all queues
        if ( ! $queue_id ) {
            $ami = new AmiActionController();
            $unpause = $ami->QueuePause("Local/$ext@home-agents",false,$reason);
            if ( $unpause["result"]) {
                // 1 : Terminate all logwatch!
                // 2 : Terminate all bind
                QueuebindsController::logwatchTerminate($agent_id,false,$by,$reason);
                QueuebindsController::unbind($agent_id,false);
                return array(
                    "result"        => true,
                    "message"       => "Agent($ext) is successfully logged out.$unpause[message]"
                );
            } else {
                return array(
                    "result"    => false,
                    "error"     => "Unable to logout Agent($ext) from Queues. $unpause[error]"
                );
            }
        }

        // Here : logout is requested for single queue
        $queue_name = QueuesController::getQueueNameById($queue_id);

        if ( ! $queue_name ) {
            return array(
                "result"    => false,
                "error"     => "Unable to find Queue($queue_id)"
            );
        }

        $ami = new AmiActionController();
        $unpause = $ami->QueuePause("Local/$ext@home-agents",$queue_name,$reason);
        if ( $unpause["result"] ) {
            QueuebindsController::logwatchTerminate($agent_id,$queue_id,$by,$reason);
            QueuebindsController::unbind($agent_id,$queue_id);
            return array(
                "result"    => true,
                "message"   => "Agent($ext) is successfully logged out of Queue($queue_name)"
            );
        } else {

            return array(
                "result"    => false,
                "error"     => "Unable to logged out agent. $unpause[error] "
            );

        }

    }




    public static function plug($agent_id,$station_id,$force = true,$by = null,$note = "") {

        $ext = self::ext($agent_id);
        $plugInfo = self::plugInfo($agent_id);

        if ( $plugInfo ) {
            // Agent is already plugged
            if ( $plugInfo["station_id"] == $station_id ) {
                // Agent is plugged on same station. Returning true
                return array(
                    "result"    => true,
                    "message"   => "Agent($ext) is already plugged on same station($plugInfo[station])"
                );
            } else {
                // Switching Station
                $unplugAgent = self::unplug($agent_id);
                //$unplug = self::logAgentPlug(0,$agent_id,-1,0);
            }
        }


        // Here : If login requested on EXTERNAL
        if ( ! $station_id ) {

            // Here : if EXTERNAL is disabled we can't proceed
            if ( ! GlobalVarsController::get("EXTERNAL") ) {
                if ( ! self::allowExternal($agent_id)) {
                    return array(
                        "result"    => false,
                        "error"     => "External login is disabled. Contact administrator"
                    );
                }
            }

            $userPlug = Users::where("id",$agent_id)
                    ->update([
                        "plugged"   => true,
                        "station"   => "external",
                        "lsl"       => date("Y-m-d H:i:s")
                    ]);

            if ( $userPlug ) {
                // TODO : Maybe we need to SYNC Binding here!
                $logAgentPlug = self::logAgentPlug(1,$agent_id,0,0);
                return array(
                    "result"        => true,
                    "message"       => "Done plugging Agent($ext). logAgentPlug($logAgentPlug)"
                );

            } else {
                return array(
                    "result"    => false,
                    "error"     => "Unable to update user profile. Contact administrator!"
                );
            }

        }

        // Here : Agent is to plug into Local-Station

        $station_name = PeersController::getStationNameById($station_id);

        if ( ! $station_name ) {
            return array(
                "result"    => false,
                "error"     => "Requested station disabled/Invalid"
            );
        }

        $who = PeersController::whoAreUsingThisStation($station_name);

        if ( ! $who  ) {
            // No headache!!  - No one else using it. Just plug it
            $plugUser = Users::where("id",$agent_id)
                    ->update([
                        "plugged"   => true,
                        "station"   => $station_name,
                        "lsl"       => date("Y-m-d H:i:s")
                    ]);

            if ( $plugUser ) {
                // TODO : Maybe we need to SYNC Binding here!
                $logAgentPlug = self::logAgentPlug(true,$agent_id,$station_id,0);
                return array(
                    "result"    => true,
                    "message"   => "Agent($ext) is successfully plugged on Station($station_name). logAgentPlug($logAgentPlug)"
                );

            } else {
                return array(
                    "result"    => false,
                    "error"     => "Unable to plug agent($ext). Contact administrator"
                );
            }
        }

        // Here : Other(s) are plugged on this station!
        // Checking 1 : MULTIPLUG
        // Checking 2 : FORCE!

        if ( GlobalVarsController::get("MULTIPLUG") ) {

            $agentPlug = Users::where("id",$agent_id)
                ->update([
                    "plugged"   => true,
                    "station"   => $station_name,
                    "lsl"       => date("Y-m-d H:i:s")
                ]);

            if ( $agentPlug ) {
                // TODO : Maybe we need to SYNC Binding here!
                $logAgentPlug = self::logAgentPlug(true,$agent_id,$station_id,0);
                return array(
                    "result"        => true,
                    "message"       => "Agent($ext) is plugged on Station($station_name). Notice : Multiplug is ON"
                );
            } else {
                return array(
                    "result"    => false,
                    "error"     => "Unable to update user profile"
                );
            }

        } else {
            // Here : Multiplug is disabled
            if ( ! $force ) {
                // Here : if no FORCE then we return false
                return array(
                    "result"    => false,
                    "error"     => "Unable to plug on station($station_name) while other agent is using it. No multiplug. No force"
                );
            } else {
                // Here : if FORCE, we unplug others and proceed with new Agent plug
                $whoCount = count($who);
                $othersUnplug = 0;
                foreach($who as $others) {
                    $unpluger = self::unplug($others["id"]);
                    if ( $unpluger["result"]  ) { $othersUnplug++; }
                }
                $agentPlug = Users::where("id",$agent_id)
                    ->update([
                        "plugged"   => true,
                        "station"   => $station_name,
                        "lsl"       => date("Y-m-d H:i:s")
                    ]);

                if ( $agentPlug ) {
                    $logAgentPlug = self::logAgentPlug(true,$agent_id,$station_id,0);
                    return array(
                        "result"    => true,
                        "messsage"  => "Agent($ext) is plugged on Station($station_name). TotalWho($whoCount), OthersUnplug($othersUnplug), logAgentPlug($logAgentPlug)"
                    );
                } else {
                    return array(
                        "result"    => false,
                        "error"     => "Unable to plug agent($ext). Warning : There are $othersUnplug agent(s) unplugged during this action"
                    );
                }
            }
        }

    }


    public static function unplug($agent_id) {

        $isPlugged = self::isPlugged($agent_id);
        $ext = self::ext($agent_id);

        if ( ! $isPlugged ) {
            $bindSyncer = QueuebindsController::bindSyncer($agent_id);
            return array(
                "result"    => true,
                "message"   => "Agent($ext) is already unplugged",
                "bindSyncer"=> $bindSyncer["result"]
            );
        }

        $unplug = Users::where("id",$agent_id);
        $ifUnplugged = $unplug->update([
            "plugged"   => false,
            "station"   => null
        ]);

        if ( ! $ifUnplugged ) {
            return array(
                "result"    => false,
                "error"     => "Error unplugging agent($ext). Contact administrator!",
                "bindSyncer"=> false,
            );
        } else {
            $ami = new AmiActionController();
            $pause = $ami->QueuePause("Local/$ext@home-agents",false,"unplug");
            $unbind = QueuebindsController::unbind($agent_id,false);
            $logwatch = QueuebindsController::logwatchTerminate($agent_id,false,"Unplugger","Unplugging");
            $addPlugRecord = self::logAgentPlug(0,$agent_id,-1,0);
            $bindSyncer = QueuebindsController::bindSyncer($agent_id);
            return array(
                "result"    => true,
                "message"   => "Unplug done for agent($ext). Pause($pause[result]), Unbind($unbind), Logwatch($logwatch),Plugwatch($addPlugRecord)",
                "bindSyncer"=> $bindSyncer["result"]
            );
        }

    }

    public static function logAgentPlug($plugged,$agent_id,$station_id,$by = 0 ) {
        $logThisPlug = new Plugwatch();
        $logThisPlug->plugged = $plugged;
        $logThisPlug->agent_id = $agent_id;
        $logThisPlug->station_id = $station_id;
        $logThisPlug->plugtime = date("Y-m-d H:i:s");
        $logThisPlug->plugged_by = $by;
        return $logThisPlug->save();
    }

    public static function isPlugged($agent_id) {
        return Users::select("plugged")->where("id",$agent_id)->where("plugged",true)->first();
    }


    public static function plugInfo($agent_id) {
        $plug = Users::select("plugged","station")->where("id",$agent_id)->first();

        if (! $plug ) {
            return false;
        }

        if ( isset($plug["plugged"]) ) {
            if ( ! is_null($plug["station"]) ) {
                $plug["station_id"] = $plug["station"] == "EXTERNAL" ? 0 : PeersController::getStationIdByName($plug["station"]);
                return $plug;
            }
        }
        return false;

    }

    public static function getCurrentStationId($agent_id) {
        $station_name = Users::select("station")->where("id",$agent_id)->first();

        if ( ! $station_name ) {
            return false;
        }

        if ( $station_name["station"] ) {
            if ( ! is_null($station_name["station"]) ) {
                return PeersController::getStationIdByName($station_name["station"]);
            }
        }
        return false;

    }

    public static function ext($agent_id) {
        $ext =  Users::select("ext")->where("id",$agent_id)->first();

        if ( $ext ) {
            return $ext["ext"];
        }
        return false;
    }



    public static function binder($agent_id,$queue_id) {
        $ext = self::ext($agent_id);

        if ( ! $ext ) {
            return array(
                "result"    => false,
                "error"     => "Agent($agent_id) not found"
            );
        }
        if ( ! $queue_id ) {
            $queues = QueuesController::getAllQueuesFromDB();

            $queueAddCount = 0;
            $queueBindCount = 0;

            $ami = new AmiActionController();
            foreach($queues as $queue) {
                $queueAdd = $ami->QueueAdd($queue["name"],"Local/$ext@home-agents");
                if ( $queueAdd["result"] ) {
                    $queueAddCount++;
                    if ( ! QueuebindsController::hasBind($agent_id,$queue["id"]) ) {
                        QueuebindsController::createBind($agent_id,$queue["id"]);
                        $queueBindCount++;
                    }

                }
            }

            /* Since Pami is adding with unpaused status */
            if ( $queueAddCount > 0 ) {
                $ami->QueuePause("Local/$ext@home-agents",false,"");
            }
            /* Since Pami is adding with unpaused status */
            return array(
                "result"        => $queueAddCount > 0 ? true : false,
                "message"       => "Agent($ext) added. QueueAdd($queueAddCount), QueueBind($queueBindCount)"
            );
        } else {
            $queue = QueuesController::getQueueFromDB($queue_id);
            if ( ! $queue ) {
                return array(
                    "result"    => false,
                    "error"     => "Unable to find Queue($queue_id). May not exist or disabled"
                );
            }
            $ami = new AmiActionController();
            $queueAdd = $ami->QueueAdd($queue["name"],"Local/$ext@home-agents");
            if ( $queueAdd["result"] ) {
                if ( ! QueuebindsController::hasBind($agent_id,$queue_id) ) {
                    QueuebindsController::createBind($agent_id,$queue_id);
                }

                $ami->QueuePause("Local/$ext@home-agents",$queue["name"],"");
                return array(
                    "result"    => true,
                    "message"   => "Agent($ext) added."
                );
            }
            return array(
                "result"    => false,
                "error"     => "Unable to add Agent($ext) to Queue($queue_id|$queue[name]). " . $queueAdd["error"]
            );
        }

    }

    public static function unbinder($agent_id,$queue_id) {
        $ext = self::ext($agent_id);


        if ( ! $ext ) {
            return array(
                "result"    => false,
                "error"   => "Agent($agent_id) not found"
            );
        }


        if ( ! $queue_id ) {
            $queues = QueuesController::getAllQueuesFromDB();
            $queueRemoveCount = 0;
            $ami = new AmiActionController();
            foreach($queues as $queue ) {
                $queueRemove = $ami->QueueRemove($queue["name"],"Local/$ext@home-agents");
                if ( $queueRemove["result"] ) {
                    $queueRemoveCount++;
                }
            }
            QueuebindsController::removeBind($agent_id,false);

            return array(
                "result"    => true,
                "message"   => "Agent($ext) removed. QueueRemoveCount($queueRemoveCount)"
            );

        } else {
            $queue = QueuesController::getQueueFromDB($queue_id);
            if ( ! $queue ) {
                return array(
                    "result"    => false,
                    "error"     => "Unable to locate Queue with given id($queue_id)"
                );
            }

            $ami = new AmiActionController();
            $queueRemove = $ami->QueueRemove($queue["name"],"Local/$ext@home-agents");
            if ( $queueRemove["result"]) {
                QueuebindsController::removeBind($agent_id,$queue_id);
                return array(
                    "result"    => true,
                    "message"   => "Agent($ext) removed from Queue($queue[name]). "
                );
            } else {
                return array(
                    "result"        => false,
                    "error"         => "Unable to remove Agent($ext) from Queue($queue[name]). " . $queueRemove["error"]
                );
            }

        }
    }


    public static function allowExternal($agent_id) {
        return $allow = Users::where("id",$agent_id)->where("allowexternal",true)->count();
    }



    public static function getDepartmentId($agent_id) {
        $depid =  Users::select("depid")->where("id",$agent_id)->first();

        if ( $depid ) {
            return $depid["depid"];
        }
        return false;
    }



}
