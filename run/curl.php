<?php


    $url = "http://10.97.65.171/gas/web/index.php/ws/incomecallevent?Event=AgentComplete&EventTime=1594284699&Linkedid=1594284616.137&Uniqueid=1594284616.137&Direction=in&Location=EMDAD&Number=09120198657&Agent=327&Status=ANSWERED&Holdtime=10&TalkTime=64&Reason=agent";



    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,0);

    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // Return data instead of outputting
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    curl_setopt($ch,CURLOPT_TIMEOUT,5);

    $result = curl_exec($ch);
    $http_status = (int) curl_getinfo($ch,CURLINFO_HTTP_CODE);
    $curl_errno  = curl_errno($ch);
    curl_close($ch);

    var_dump($result);


    /*
    if ( $http_status == 200) {

        if ( $result == "1\n" ) {
            echo 1;
        }
    } else {
	echo "0\n";
    */

    

