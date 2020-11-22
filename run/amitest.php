<?php
$wrets = "";
$socket = fsockopen("127.0.0.1","5038", $errno, $errstr,1);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: alopad\r\n");
fputs($socket, "Secret: alopad\r\n\r\n");
//fputs($socket, "\r\n");
//fputs($socket, "\r\n\r\n");
fputs($socket, "Action: SIPpeers\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");
 while (!feof($socket)) {
    $wrets .= fread($socket, 8192);
    }
fclose($socket);
echo $wrets;

?>
