<?php 


$socket = fsockopen("127.0.0.1","5038", $errno, $errstr,10); 

if (!$socket)
	{ 
		echo "$errstr ($errno)\n"; 
		}
else
	{ 
		fputs($socket, "Action: Login\r\n"); 
		fputs($socket, "UserName: admin\r\n"); 
		fputs($socket, "Secret: 13201\r\n\r\n"); 
		fputs($socket, "Action: WaitEvent\r\n"); 
		fputs($socket, "Action: Logoff\r\n\r\n"); 
		
		while(!feof($socket)) { 
			$result=fread($socket,5000); 
			if (preg_match("/\b$argv[1]\b/i", $result,$match)) { 
					echo $result; 
					} 
		} 
	
	} fclose($socket); ?>