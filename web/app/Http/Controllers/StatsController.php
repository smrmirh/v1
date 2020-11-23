<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\QueueBinds;
use App\Models\Queues;
use App\Models\Stations;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PAMI\Client\Impl\ClientImpl as ClientImpl;
use PAMI\Message\Action as PamiAction;

class StatsController extends Controller
{
    /* The very main array to build stats */
    private $stats = array();

    private $globals;

    /* Stations */
    private $stationsId;
    private $stationsName;

    /* Trunks */
    private $trunks;

    /* Departments and Queues */
    private $departments;
    private $queuesId;
    private $queuesName;

    /* Binds data */
    private $binds;
    private $bindsId;
    private $bindsExt;

    /* Variables to store database records */
    private $users;
    private $usersId;
    private $usersExt;

    private $queues;





    /* Variable for AMI Responses */
    private $CoreShowChannels;
    private $QueueStatus;
    private $CoreStatus;
    private $hints = array();
    private $AmiError = "";


    //private $agents;

    public function index() {
        //echo file_get_contents(config("alopad.stats"));
        //exit;
        $stats = file_get_contents(config("alopad.stats"));
        $stats = (array) json_decode($stats);
        $stats["token"] = ( Auth::check() ) ? Auth::user()->getRememberToken() : null;
        echo json_encode($stats);
        exit;

    }

    public function __construct()
    {

    }

    public function run() {

        $this->stats["ts"] = time();
        $this->stats["pbx"]["activeCalls"] = 0;
        $this->stats["pbx"]["activeChannels"] = 0;

        $this->stats["pbx"]["calls"]["total"] = 0;
        $this->stats["pbx"]["calls"]["answered"] = 0;
        $this->stats["pbx"]["calls"]["waiting"] = 0;
        $this->stats["pbx"]["calls"]["abandoned"] = 0;


        $this->stats["pbx"]["op"]["total"] = 0;
        $this->stats["pbx"]["op"]["plugged"]= 0;
        $this->stats["pbx"]["op"]["busy"] = 0;
        $this->stats["pbx"]["op"]["logged"] = 0;

        /* This will initiate $stationsId and $stationsNames */
        $this->globals = GlobalVarsController::all();
        $this->stations(); // Sorting $


        /* This will initiate departments array */
        $this->departments();

        /* This will get Queues from database, initiate $queuesId, $queuesName and update $departments */
        $this->queues();

        /* This will initiate $binds */
        $this->binds();

        /* This will initiate $usersId and $usersExt */
        $this->users();
        //dd($this->queuesId);

        /* This will get CoreShowChannels,QueueStatus and Hints */
        $this->ami();



        //$this->stats["pbx"]["channels"] = null;
        $this->stats["pbx"]["stations"] = $this->stationsId;
        $this->stats["pbx"]["agents"] = $this->usersId;
        $this->stats["pbx"]["queues"] = $this->queuesId;



        $this->stats["pbx"]["binds"] = $this->binds;
        $this->stats["pbx"]["hints"] = $this->hints;

        $this->stats["pbx"]["today"] = null;
        $this->stats["pbx"]["today"] = null;
        $this->stats["pbx"]["today"] = null;
        $this->stats["pbx"]["yesterday"] = null;
        $this->stats["pbx"]["yesterday"] = null;
        $this->stats["pbx"]["yesterday"] = null;





        $f = fopen(config('alopad.stats'),'w');
        fwrite($f,json_encode($this->stats,JSON_NUMERIC_CHECK));
        fclose($f);
    }

    public function stations() {
        $stations = Stations::select("id","enabled","peer","peer_fa")
            ->get();

        foreach($stations as $station ) {
            if ( isset($station["id"]) ) {
                $this->stationsId[$station["id"]]["id"] = $station["id"];
                $this->stationsId[$station["id"]]["enabled"] = (boolean)$station["enabled"];
                $this->stationsId[$station["id"]]["name"] = $station["peer"];
                $this->stationsId[$station["id"]]["name_fa"] = $station["peer_fa"];
                $this->stationsId[$station["id"]]["taken"] = false;
            }
            if ( isset($station["peer"]) ) {
                $this->stationsName[$station["peer"]]["id"] = $station["id"];
                $this->stationsName[$station["peer"]]["enabled"] = (boolean) $station["enabled"];
                $this->stationsName[$station["peer"]]["name"] = $station["peer"];
                $this->stationsName[$station["peer"]]["name_fa"] = $station["peer_fa"];
                $this->stationsName[$station["peer"]]["taken"] = false;
            }
        }
        /* We need to manually add External=0 */
        if ( isset($this->globals["EXTERNAL"])) {
            if ( $this->globals["EXTERNAL"]["val"] ) {

                $this->stationsId[0] = array(
                    "id"        => 0,
                    "enabled"   => true,
                    "name"      => "external",
                    "name_fa"   => "موبایل",
                    "status"    => "OK",
                    "available" => true,
                    "taken"     => false,
                );

                $this->stationsName["external"] = array(
                    "id"        => 0,
                    "enabled"   => true,
                    "name"      => "external",
                    "name_fa"   => "موبایل",
                    "status"    => "OK",
                    "available" => true,
                    "taken"     => false,
                );

            }
        }
    }

    public function departments() {
        $departments = Departments::select("id","enabled","name","name_fa","updated_by","updated_at")
            ->get();
        //dd($departments);

        foreach( $departments as $department) {
            if ( isset($department["id"])  ) {
                $id = $department["id"];
                $this->departments[$id]["id"] = $id;
                $this->departments[$id]["enabled"]      = isset($department["enabled"]) ? (boolean) $department["enabled"] : null;
                $this->departments[$id]["name"]         = isset($department["name"]) ? $department["name"] : null;
                $this->departments[$id]["name_fa"]      = isset($department["name_fa"]) ? $department["name_fa"] : null;
                $this->departments[$id]["queues"]       = array();
            }
        }
    }


    public function queues() {
        $queues = Queues::select("id","enabled","depid","name","name_fa","by247","preplay","voting","intro","recording")
            //->where("enabled",true)
            ->get();

        foreach($queues as $queue) {
            if ( isset($queue["id"]) ) {
                $id = $queue["id"];
                $depid = isset($queue["depid"]) ? (int)$queue["depid"] : null;
                $this->queuesId[$id]["id"]          = isset($queue["id"]) ? (int)$queue["id"] : "";
                $this->queuesId[$id]["name"]        = isset($queue["name"]) ? $queue["name"] : "";
                $this->queuesId[$id]["name_fa"]     = isset($queue["name_fa"]) ? $queue["name_fa"] : "";
                $this->queuesId[$id]["depid"]       = $depid;
                $this->queuesId[$id]["by247"]       = isset($queue["by247"]) ? (boolean)$queue["depid"] : false;
                $this->queuesId[$id]["voting"]      = isset($queue["voting"]) ? (boolean)$queue["voting"] : 0;
                $this->queuesId[$id]["intro"]       = isset($queue["intro"]) ? $queue["intro"] : "";
                $this->queuesId[$id]["recording"]   = isset($queue["recording"]) ? (boolean)$queue["recording"] : false;

                /* updating $departments[$id][queues] */
                if ( isset($this->departments[$depid]) ) {
                    $this->departments[$depid][$id]["name"] = $this->queuesId[$id]["name"];
                    $this->departments[$depid][$id]["name_fa"] = $this->queuesId[$id]["name"];
                    $this->departments[$depid][$id]["voting"] = $this->queuesId[$id]["voting"];
                    $this->departments[$depid][$id]["intro"] = $this->queuesId[$id]["intro"];
                }
            }

            if( isset($queue["name"])) {
                $name = $queue["name"];
                $this->queuesName[$name]["id"]            = isset($queue["id"]) ? (int) $queue["id"] : null;
                $this->queuesName[$name]["name"]          = isset($queue["name"]) ? (int) $queue["name"] : null;
                $this->queuesName[$name]["name_fa"]       = isset($queue["name_fa"]) ? (int) $queue["name_fa"] : null;
                $this->queuesName[$name]["depid"]         = isset($queue["depid"]) ? (int) $queue["depid"] : null;
                $this->queuesName[$name]["by247"]         = isset($queue["by247"]) ? (boolean) $queue["by247"] : null;
                $this->queuesName[$name]["voting"]        = isset($queue["voting"]) ? (boolean) $queue["voting"] : null;
                $this->queuesName[$name]["intro"]         = isset($queue["intro"]) ? $queue["intro"] : null;
                $this->queuesName[$name]["recording"]     = isset($queue["recording"]) ? (boolean) $queue["recording"] : null;

            }
        }
    }

    public function binds() {
        $bindings =  QueueBinds::select("id","enabled","agent_id","queue_id","station_id","binded","binded_at")
            ->get();

        foreach($bindings as $bind) {
            if ( isset($bind["agent_id"]) ) {
                $agent_id = (int) $bind["agent_id"];
                $queue_id = (int) $bind["queue_id"];
                //if ( isset($this->binds[$agent_id]) ) {
                    $this->binds[$agent_id][$queue_id]["enabled"]       = isset($bind["enabled"]) ? (boolean) $bind["enabled"] : null;
                    $this->binds[$agent_id][$queue_id]["binded"]        = isset($bind["binded"]) ? (boolean) $bind["binded"] : null;
                    $this->binds[$agent_id][$queue_id]["station_id"]    = isset($bind["station_id"]) ? (int) $bind["station_id"] : null;
                    $this->binds[$agent_id][$queue_id]["station"]       = isset($this->stationsId[$bind["station_id"]]["name"]) ? $this->stationsId[$bind["station_id"]]["name"] : null;
                    $this->binds[$agent_id][$queue_id]["queue_id"]      = $queue_id;
                    $this->binds[$agent_id][$queue_id]["queue_name"]    = isset($this->queuesId[$queue_id]) ? $this->queuesId[$queue_id]["name"] : null;
                    $this->binds[$agent_id][$queue_id]["queue_name_fa"] = isset($this->queuesId[$queue_id]) ? $this->queuesId[$queue_id]["name_fa"] : null;
                    $this->binds[$agent_id][$queue_id]["binded_at"]     = isset($bind["binded_at"]) ? strtotime($bind["binded_at"]) : null;
                //}
            }
        }
    }

    public function users() {
        $this->users = Users::select("id","depid","fullname","fullname_fa","plugged","ext","external","station","lsl")
            ->where("enabled",true)
            ->where("access","<",10)
            ->get();

        //$this->users = array();

        foreach($this->users as $user) {
            //if ( $user["access"] === 10 ) continue; // We dont expose ADMIN level

            if ( ! is_null($user["ext"]) ) {
                /* ---- */
                $this->stats["pbx"]["op"]++;
                if ( $user["plugged"] ) {
                    $this->stats["pbx"]["op"]["plugged"]++;
                }

                /* ---- */
                $ext = $user["ext"];
                $this->usersExt[$ext]["id"]            = $user["id"];
                $this->usersExt[$ext]["ext"]           = $user["ext"];
                $this->usersExt[$ext]["fullname"]      = $user["fullname"];
                $this->usersExt[$ext]["fullname_fa"]   = $user["fullname_fa"];
                $this->usersExt[$ext]["plugged"]       = $user["plugged"];
                $this->usersExt[$ext]["station"]       = $user["station"];
                $this->usersExt[$ext]["station_id"]    = isset($this->stationsName[$user["station"]]) ? (int) $this->stationsName[$user["station"]]["id"] : null;
                $this->usersExt[$ext]["lsl"]           = strtotime($user["lsl"]); //$user["lsl"];
                //$this->usersExt[$ext]["hint"]          = isset($this->hints[$ext]) ? $this->hints[$ext] : "Unknown";
                $this->usersExt[$ext]["binds"]         = isset($this->binds[$user["id"]]) ? $this->binds[$user["id"]] : null;
            }

            if ( isset($user["id"]) ) {
                $id = $user["id"];
                $this->usersId[$id]["id"]            = $user["id"];
                $this->usersId[$id]["ext"]           = $user["ext"];
                $this->usersId[$id]["fullname"]      = $user["fullname"];
                $this->usersId[$id]["fullname_fa"]   = $user["fullname_fa"];
                $this->usersId[$id]["plugged"]       = $user["plugged"];
                $this->usersId[$id]["station"]       = $user["station"];
                $this->usersId[$id]["station_id"]    = isset($this->stationsName[$user["station"]]) ? (int) $this->stationsName[$user["station"]]["id"] : null;
                $this->usersId[$id]["lsl"]           = strtotime($user["lsl"]); //$user["lsl"];
                //$this->usersId[$id]["hint"]          = isset($this->hints[$user["ext"]]) ? $this->hints[$user["ext"]] : "Unknown";
                $this->usersId[$id]["binds"]         = isset($this->binds[$user["id"]]) ? $this->binds[$user["id"]] : null;
            }

            /* If this user is using any station- we flag TAKEN */
            if ( ! is_null($user["station"]) && $user["station"] != "external" ) {
                if ( isset($this->stationsName[$user["station"]])) {
                    $id = $this->stationsName[$user["station"]]["id"];
                    $this->stationsName[$user["station"]]["taken"] = true;
                    if ( isset($this->stationsId[$id]) ) {
                        $this->stationsId[$id]["taken"] = true;
                    }
                }
            }
        }

    }


    public function agents() {

        foreach($this->users as $user ) {
            if ( isset($user["ext"]) ) {
                if ( !is_null($user["ext"]) ) {
                    $this->stats["pbx"]["agents"]["total"]++;
                    if ( $user["plugged"] ) {
                        $this->stats["pbx"]["agents"]["plugged"]++;
                    }
                    $this->stats["pbx"]["agents"]["profiles"][$user["ext"]] = $user;
                    $hint = ( isset($this->hints[$user["ext"]]) ) ? $this->hints[$user["ext"]] : "Unknown";
                    $this->stats["pbx"]["agents"]["profiles"][$user["ext"]]["hint"] = $hint;
                    if ( $hint == "InUse" || $hint == "Ring" || $hint == "Ringing" || $hint == "Inuse&Ringing" ) {
                        $this->stats["pbx"]["agents"]["busy"]++;
                    }
                }
            }
        } // End of foreach()
        //$this->stats["pbx"]["agents"] = array(1,2,3);

    }



    public function ami() {

        $host             = config("alopad.ast_host");
        $port             = config("alopad.ast_port");
        $scheme           = config("alopad.ast_scheme");
        $username         = config("alopad.ast_user");
        $secret           = config("alopad.ast_pass");
        $connect_timeout  = config("alopad.ast_ctimeout");
        $read_timeout     = config("alopad.ast_rtimeout");

        try {
            $options = array(
                "host"      => $host,
                "scheme"    => $scheme,
                "port"      => $port,
                "username"  => $username,
                "secret"    => $secret,
                "connect_timeout"   => $connect_timeout,
                "read_timeout"      => $read_timeout
            );


            $pamiClient = new ClientImpl($options);
            $pamiClient->open();
            $CoreShowChannels       = $pamiClient->send( new PamiAction\CoreShowChannelsAction());
            $QueueStats             = $pamiClient->send( new PamiAction\QueueStatusAction(false,false));
            $SIPPeers               = $pamiClient->send( new PamiAction\SIPPeersAction());
            $CoreStatus             = $pamiClient->send( new PamiAction\CoreStatusAction());
            $activeCalls            = $pamiClient->send( new PamiAction\CommandAction("core show channels"));




            /* We update hints for users! */

            if ( $this->usersId ) {
                foreach($this->usersId as $id=>$user ) {
                    if ( isset($user["ext"]) ) {
                        $state = $pamiClient->send(new PamiAction\ExtensionStateAction($user["ext"],"home-hints"));
                        if ( $state->isSuccess() ) {
                            $keys = $state->getKeys();
                            $this->hints[$user["ext"]] = "Unknown";
                            if ( isset($keys["statustext"]) ) {
                                $this->hints[$user["ext"]] = $keys["statustext"];
                                $this->usersId[$id]["hint"] = $keys["statustext"];
                                $this->usersExt[$user["ext"]]["hint"] = $keys["statustext"];

                                if ( $keys["statustext"] == "InUse" || $keys["statustext"] == "Ring" || $keys["statustext"] == "InUse&Ringing"  ) {
                                    $this->stats["pbx"]["op"]["busy"]++;
                                }
                            }
                        }
                    }
                }
            }

            $pamiClient->close();
            /* $this->hints updated! */


            // Below : Getting sip registry status
            if ( $SIPPeers->isSuccess()  ) {
                if ( $SIPPeers->getEvents()  ) {
                    $peers = $SIPPeers->getEvents();
                    foreach($peers as $peer) {
                        $peerKeys = $peer->getKeys();
                        if ( isset($peerKeys["event"]) ) {
                            if ( $peerKeys["event"] == "PeerEntry" ) {
                                if ( isset($peerKeys["objectname"]) ) {
                                    $peerName = $peerKeys["objectname"];
                                    if ( isset($this->stationsName[$peerName]) ) {
                                        $id = $this->stationsName[$peerName]["id"];
                                        $this->stationsName[$peerName]["status"]        = isset($peerKeys["status"]) ? $peerKeys["status"] : null;
                                        $this->stationsName[$peerName]["ipaddress"]     = isset($peerKeys["ipaddress"]) ? $peerKeys["ipaddress"] : null;
                                        $this->stationsName[$peerName]["available"]     = preg_match("/OK/",$this->stationsName[$peerName]["status"]) ? true : false;

                                        if ( isset( $this->stationsId[$id] ) ) {
                                            $this->stationsId[$id]["status"]            = $this->stationsName[$peerName]["status"];
                                            $this->stationsId[$id]["ipaddress"]         = $this->stationsName[$peerName]["ipaddress"];
                                            $this->stationsId[$id]["available"]         = $this->stationsName[$peerName]["available"];
                                        }
                                        /* TODO : $this->trunks should be updated here */
                                    }
                                }
                            }
                        }
                    }

                }
            }
            /* End of sip registry validation */

            if ( $CoreShowChannels->isSuccess() ) {
                $this->CoreShowChannels = $CoreShowChannels->getEvents();
                //dd($this->CoreShowChannels);
            }

            if ( $QueueStats->isSuccess() ) {

                $this->QueueStatus = $QueueStats->getEvents();
                $this->QueueUpdateByConsoleData();
            }

            if ( $CoreStatus->isSuccess() ) {
                $vars = $CoreStatus->getKeys();

            }


            if ( $activeCalls->isSuccess() ) {
                $this->activeChannels($activeCalls->getRawContent());
            }






        } catch(\PAMI\Client\Exception\ClientException $e) {
            $this->AmiError = $e->getMessage();
        }
    }


    public function QueueUpdateByConsoleData() {

        foreach($this->QueueStatus as $queueStatus) {
            $params = $queueStatus->getKeys();
            if ( isset($params["event"]) ) {
                if ( $params["event"] == "QueueParams" ) {
                    if ( isset($params["queue"]) ) {
                        $thisQueue = $params["queue"];

                        if ( isset($this->queuesName[$thisQueue])) {
                            $this->queuesName[$thisQueue]["calls"] = isset($params["calls"]) ? (int)$params["calls"] : null;
                            $this->queuesName[$thisQueue]["holdtime"] = isset($params["holdtime"]) ? (int)$params["holdtime"] : null;
                            $this->queuesName[$thisQueue]["talktime"] = isset($params["talktime"]) ? (int)$params["talktime"] : null;
                            $this->queuesName[$thisQueue]["completed"] = isset($params["completed"]) ? (int)$params["completed"] : null;
                            $this->queuesName[$thisQueue]["abandoned"] = isset($params["abandoned"]) ? (int)$params["abandoned"] : null;

                            // This is to count Active Calls
                            //$this->stats["pbx"]["activeCalls"] += $this->queuesName[$thisQueue]["calls"];

                            $thisQueueId = $this->queuesName[$thisQueue]["id"];
                            if ( isset($this->queuesId[$thisQueueId])) {

                                $this->queuesId[$thisQueueId]["calls"] = isset($params["calls"]) ? (int)$params["calls"] : null;
                                $this->queuesId[$thisQueueId]["holdtime"] = isset($params["holdtime"]) ? (int)$params["holdtime"] : null;
                                $this->queuesId[$thisQueueId]["talktime"] = isset($params["talktime"]) ? (int)$params["talktime"] : null;
                                $this->queuesId[$thisQueueId]["completed"] = isset($params["completed"]) ? (int)$params["completed"] : null;
                                $this->queuesId[$thisQueueId]["abandoned"] = isset($params["abandoned"]) ? (int)$params["abandoned"] : null;

                                $this->stats["pbx"]["calls"]["answered"] += $this->queuesId[$thisQueueId]["completed"];
                                $this->stats["pbx"]["calls"]["abandoned"] += $this->queuesId[$thisQueueId]["abandoned"];
                                $this->stats["pbx"]["calls"]["waiting"] += $this->queuesId[$thisQueueId]["calls"];
                            }
                        }
                    }
                } // End of QueueParams
                if ( $params["event"] == "QueueMember" ) {
                    if ( isset($params["name"]) ) {
                        if ( isset($params["queue"])) {
                            $ext = Helpers::homeAgent($params["name"]);
                            if ( ! is_null($ext) ) {
                                if ( isset($this->usersExt[$ext]) ) {
                                    $id = isset($this->usersExt[$ext]["id"]) ? (int) $this->usersExt[$ext]["id"] : null;
                                    $queueId = isset($this->queuesName[$params["queue"]]) ? $this->queuesName[$params["queue"]]["id"] : null;

                                    // Updating $this->usersId
                                    if ( isset($this->usersId[$id]["binds"][$queueId]) ) {

                                        $this->usersId[$id]["callstaken"]                          = isset($params["callstaken"]) ? (int)$params["callstaken"] : 0;
                                        $this->usersId[$id]["lastcall"]                            = isset($params["lastcall"]) ? (int)$params["lastcall"] : null;
                                        $this->usersId[$id]["binds"][$queueId]["callstaken"]       = isset($params["callstaken"]) ? (int)$params["callstaken"] : 0;
                                        $this->usersId[$id]["binds"][$queueId]["lastcall"]         = isset($params["lastcall"]) ? (int)$params["lastcall"] : null;
                                        $this->usersId[$id]["binds"][$queueId]["paused"]           = isset($params["paused"]) ? (boolean)$params["paused"] : null;
                                        $this->usersId[$id]["binds"][$queueId]["pausedreason"]     = isset($params["pausedreason"]) ? $params["pausedreason"] : null;

                                    }
                                    // Updating $this->usersExt
                                    if ( isset($this->usersExt[$ext]["binds"][$queueId]) ) {
                                        $this->usersExt[$ext]["callstaken"]                          = isset($params["callstaken"]) ? (int)$params["callstaken"] : 0;
                                        $this->usersExt[$ext]["lastcall"]                            = isset($params["lastcall"]) ? (int)$params["lastcall"] : null;
                                        $this->usersExt[$ext]["binds"][$queueId]["callstaken"]       = isset($params["callstaken"]) ? (int)$params["callstaken"] : 0;
                                        $this->usersExt[$ext]["binds"][$queueId]["lastcall"]         = isset($params["lastcall"]) ? (int)$params["lastcall"] : null;
                                        $this->usersExt[$ext]["binds"][$queueId]["paused"]           = isset($params["paused"]) ? (boolean)$params["paused"] : null;
                                        $this->usersExt[$ext]["binds"][$queueId]["pausedreason"]     = isset($params["pausedreason"]) ? $params["pausedreason"] : null;
                                    }

                                }
                            }

                        }
                    }
                }
            }
        }

    }


    public function activeChannels($ch) {

        $raw = preg_split("/\n/",$ch,-1,PREG_SPLIT_NO_EMPTY);
        foreach($raw as $each ) {
            if ( preg_match("/active call/",$each)) {
                $activeCalls = explode("active",trim($each));
                //echo $each;
                if ( isset($activeCalls[0]) ) {
                    $activeCalls = trim($activeCalls[0]);
                }
            }

            if ( preg_match("/active channel/",$each) ) {
                $activeChannels = explode("active",trim($each));
                if( isset($activeChannels[0])) {
                    $activeChannels = $activeChannels[0];
                }
            }
        }

        $this->stats["pbx"]["activeCalls"] = isset($activeCalls) ? $activeCalls : 0;
        $this->stats["pbx"]["activeChannels"] = isset($activeChannels) ? $activeChannels : 0;
    }

    public function Channels() {
        // Todo : Channel analyze
    }

} // End of Class
