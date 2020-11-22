<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PAMI\Client\Impl\ClientImpl as PamiClient;
use PAMI\Message\Action as PamiAction;
use PAMI\Message\Action\ReloadAction;


class AsteriskController extends Controller
{
    public function index() {

        $options = array(
            "host"      => "127.0.0.1",
            "scheme"    => "tcp://",
            "port"      => 5038,
            "username"  => "alopad",
            "secret"    => "alopad",
            "connect_timeout"   => 10000,
            "read_timeout"      => 10000
        );
        $pamiClient = new PamiClient($options);
        $pamiClient->open();
        //$response = $pamiClient->send( new ReloadAction());
        //$response = $pamiClient->send( new PamiAction\QueueAddAction("OPERATOR","Local/201@home-agents"));
        $response = $pamiClient->send(new PamiAction\SIPPeersAction());

        //echo $response->getMessage();
        //echo "<hr>";
        //echo $response->getRawContent();
        //echo "<hr>";
        //var_dump($response->getVariables());
        //echo "<hr>";
        //echo $response->isSuccess();
        //echo "<hr>";
        //var_dump(count($response->getEvents()));
        //echo "<hr>";
        $result = (array) $response->getEvents();
        echo "Events : " . count($result);
        echo "<hr>";
        foreach($result as $res) {
            $peer = (array) $res->getKeys();
            if ( $peer["event"] == "PeerEntry" ) {
                //echo $peer["status"];
                var_dump($peer);
            }
            echo "<hr>";
        }
        //var_dump($result);


        //echo "<hr><hr><hr>";
        //var_dump($response);

    }
}
