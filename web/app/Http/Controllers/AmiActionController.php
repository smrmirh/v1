<?php



namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use PAMI\Client\Impl\ClientImpl as ClientImpl;
use PAMI\Exception\PAMIException;
use PAMI\Listener\IEventListener;
use PAMI\Message\Action as PamiAction;
use PAMI\Message\Event\EventMessage as EventMessage;

/*
class AmiEvent implements IEventListener {
    public function handle(EventMessage $event) {
        var_dump($event);
    }
}
*/

class AmiActionController extends Controller
{

    private $host;
    private $scheme = "tcp://";
    private $port = 5038;
    private $username = "alopad";
    private $secret = "alopad";
    private $connect_timeout = 10000;
    private $read_timeout = 10000;
    private $pamiClient;
    private $eve;

    function __construct()
    {
        $this->host             = config("alopad.ast_host");
        $this->port             = config("alopad.ast_port");
        $this->scheme           = config("alopad.ast_scheme");
        $this->username         = config("alopad.ast_user");
        $this->secret           = config("alopad.ast_pass");
        $this->connect_timeout  = config("alopad.ast_ctimeout");
        $this->read_timeout     = config("alopad.ast_rtimeout");


        try {
            $options = array(
                "host"      => $this->host,
                "scheme"    => $this->scheme,
                "port"      => $this->port,
                "username"  => $this->username,
                "secret"    => $this->secret,
                "connect_timeout"   => $this->connect_timeout,
                "read_timeout"      => $this->read_timeout
            );

            $this->pamiClient = new ClientImpl($options);
            $this->pamiClient->registerEventListener(function($event){
                $this->eve = $event;
                //return $event;
                //var_dump($event);
                //exit;
            });
            //$this->pamiClient->registerEventListener(new AmiEvent());

        } catch(\PAMI\Client\Exception\ClientException $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }
    }


    function SIPPeers() {

        try {
            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\SIPPeersAction());
            $this->pamiClient->close();

        } catch (Exception $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }


        if ( ! $response->isSuccess() ) {
            return array(
                "result"    => false,
                "error"     => $response->getMessage()
            );
        }

        if ( ! $response->getEvents() ) {
            return array(
                "result"    => false,
                "error"     => "No events found"
            );
        }

        $events = (array) $response->getEvents();

        $peers = array();
        foreach( $events as $eve  ) {
            $peer = (array) $eve->getKeys();
            if ( isset($peer["event"]) ) {
                if ( $peer["event"] == "PeerEntry" ) {
                    $name = isset($peer["objectname"]) ? $peer["objectname"] : null;
                    if ( is_null($name) ) {
                        continue;
                    }

                    $ip = isset($peer["ipaddress"]) ? $peer["ipaddress"] : null;
                    $status = isset($peer["status"]) ? $peer["status"] : null;

                    $available = false;
                    if ( preg_match("/OK/",$status)) {
                        $available = true;
                    }

                    $type = isset($peer["description"]) ? $peer["description"] : "NONE";

                    $peers[$name] = array(
                        "available"     => $available,
                        "ip"            => $ip,
                        "status"        => $status,
                        "type"          => $type
                    );
                }
            }
        }
        return array(
            "result"    => true,
            "sippeers"  => $peers
        );

    }


    public function QueueAdd($queue,$agent) {

        try {
            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\QueueAddAction($queue,$agent));
            $this->pamiClient->close();

            if ( $response->isSuccess() ) {
               return array(
                   "result"     => true,
                   "message"    => $response->getMessage() ? $response->getMessage() : "None"
               );
            } else {

                if ( preg_match("/Already there/",$response->getMessage()) ) {
                    return array(
                        "result"        => true,
                        "message"       => "Already there"
                    );
                }

                return array(
                    "result"        => false,
                    "error"         => $response->getMessage()
                );

            }
        } catch (Exception $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }
    }

    public function QueueRemove($queue,$agent) {

        try {
            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\QueueRemoveAction($queue,$agent));
            $this->pamiClient->close();

            if ( $response->isSuccess() ) {
                return array(
                    "result"     => true,
                    "message"    => $response->getMessage() ? $response->getMessage() : "None"
                );
            } else {

                if ( preg_match("/Not there/",$response->getMessage()) ) {
                    return array(
                        "result"        => true,
                        "message"       => "Not there"
                    );
                }

                return array(
                    "result"        => false,
                    "error"         => $response->getMessage()
                );

            }
        } catch (Exception $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }

    }


    public function QueuePause($agent,$queue,$reason) {
        try {
            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\QueuePauseAction($agent,$queue,$reason));
            $this->pamiClient->close();

            if ( $response->isSuccess() ) {
                return array(
                    "result"        => true,
                    "message"       => $response->getMessage()
                );
            } else {
                if ( preg_match("/not found/",$response->getMessage()) ) {
                    return array(
                        "result"        => false,
                        "error"         => $response->getMessage()
                    );
                }

                return array(
                    "result"        => false,
                    "error"         => "UNKNOWN"
                );

            }


        } catch(\Exception $e) {

        }
    }

    public function QueueUnpause($agent,$queue = false ,$reason = "") {
        try {
            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\QueueUnpauseAction($agent,$queue,$reason) );
            $this->pamiClient->close();

            if ( $response->isSuccess() ) {
                return array(
                    "result"    => true,
                    "message"   => $response->getMessage()
                );
            } else {
                    return array(
                        "result"    => false,
                        "error"     => $response->getMessage()
                    );

            }

        } catch(\Exception $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }
    }





    public function QueueStatus($queue_name = false,$agent_ext = false) {
        try {

            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\QueueStatusAction($queue_name,$agent_ext));
            $this->pamiClient->close();


        } catch(Exception $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }

        if ( ! $response->isSuccess() ) {
            return array(
                "result"    => false,
                "error"     => $response->getMessage()
            );
        }

        if ( ! $response->getEvents() ) {
            return array(
                "result"    => false,
                "error"     => "No events found"
            );
        }

        $events =  $response->getEvents();
        $queues = array();
        $members = array();

        foreach($events as $eve) {
            $info = $eve->getKeys();
            if ( isset($info["event"])) {
                if ( $info["event"] == "QueueParams" ) {
                    if ( isset($info["queue"]) ) {
                        if ( strlen($info["queue"]) > 0 ) {
                            $queues[$info["queue"]] = array();
                        }
                    }
                }
            }
        }

        foreach($events as $eve ) {
            $info = $eve->getKeys();
            if ( isset( $info["event"] ) ) {
                if ( $info["event"] == "QueueParams" ) {

                    if ( isset( $queues[$info["queue"]] ) ) {
                        $queues[$info["queue"]] = array(
                            "calls"     => isset($info["calls"]) ? (int) $info["calls"] : null,
                            "holdtime"  => isset($info["holdtime"]) ? (int) $info["holdtime"] : null,
                            "talktime"  => isset($info["talktime"]) ? (int) $info["talktime"] : null,
                            "completed" => isset($info["completed"]) ? (int) $info["completed"] : null,
                            "sla"     => isset($info["servicelevel"]) ? (int) $info["servicelevel"] : null,
                            "max"     => isset($info["max"]) ? (int) $info["max"] : null,
                            "members" => array()
                        );
                    }

                }
            }
        }


        foreach($events as $eve) {
            $info = $eve->getKeys();
            if ( isset($info["event"])) {
                if ( $info["event"] == "QueueMember" ) {
                    if ( isset($info["queue"]) ) {
                        if ( isset($info["name"]) ) {
                            // Note : !!!!!!!
                            $agent = Helpers::homeAgent($info["name"]);
                            if ( ! is_null($agent) ) {
                                if ( isset($queues[$info["queue"]])) {
                                    if ( ! isset($queues[$info["queue"]]["members"][$agent])) {
                                        $queues[$info["queue"]]["members"][$agent] = array(
                                            "callstaken"     => isset($info["callstaken"]) ? (int) $info["callstaken"] : null,
                                            "lastcall"       => isset($info["lastcall"]) ? (int) $info["lastcall"] : null,
                                            "incall"     => isset($info["incall"]) ? (int) $info["incall"] : null,
                                            "status"     => isset($info["status"]) ? (int) $info["status"] : null,
                                            "paused"     => isset($info["paused"]) ? (int) $info["paused"] : null,
                                            "pausedreason"     => isset($info["pausedreason"]) ? (int) $info["pausedreason"] : null,

                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return array(
            "result"    => true,
            "queues"    => $queues,
            "message"   => "Got fishes"
        );

    }


    public function ExtensionState($ext) {
        try {
            $this->pamiClient->open();
            //$response = $this->pamiClient->send( new PamiAction\ExtensionStateAction("101","home-hints") );
            $response = $this->pamiClient->send( new PamiAction\ExtensionStateAction($ext,"home-hints") );
            $this->pamiClient->close();

            //dd($response);
            if ( $response->isSuccess() ) {
                $keys = $response->getKeys();
                if ( isset($keys["statustext"]) ) {
                    return $keys["statustext"];
                }
                return "UNKNOWN";
            }
            return "UNKNOWN";
            //return $response;
        } catch(\Exception $e) {
            return array(
                "result"    => false,
                "error"     => $e->getMessage()
            );
        }
    }


    public function Command() {

        try {
            $this->pamiClient->open();
            //$response = $this->pamiClient->send( new PamiAction\CommandAction("core show channels") );
            $response = $this->pamiClient->send( new PamiAction\CoreStatusAction());
            $this->pamiClient->close();
            dd($response);

        } catch(Exception $e) {
            return null;
        }

    }


    public function CoreShowChannels() {
        try {
            $this->pamiClient->open();
            $response = $this->pamiClient->send( new PamiAction\CommandAction("core show channels") );
            //$response = $this->pamiClient->send( new PamiAction\CoreStatusAction());
            //$response = $this->pamiClient->send( new PamiAction\CoreShowChannelsAction());
            $this->pamiClient->close();

            if ( $response->isSuccess() ) {
                return $response->getRawContent();
            }

        } catch(Exception $e) {
            return null;
        }
    }



}
