#!/usr/bin/php -q
<?php
$type = $argv[1];
$number = $argv[2];


if ( $type == "date" ) {
	// Sample : 98/07/11
	$str = explode("/",$number);
	echo dayofmonth($str[2]) .  "&Month_$str[1]e&YearOf&" . ten($str[0]);
	exit;
	
}


// ARTA SHGHABZ    : 0055076606934
// ARTA_SHPARDAKHT : 0000022009705


if ( $type == "mobile" ) {
	// 0 912 019 86 57
	$p1 = ths(substr($number,1,3));
	$p2 = ths(substr($number,4,3));
	$p3 = ten(substr($number,7,2));
	$p4 = ten(substr($number,9,2));
	$p = "digits/0&$p1&$p2&$p3&$p4";
	echo $p;
	exit;
	
}

if ( $type == "shg" ) {
	$p1 = substr($number,0,2);
	$p2 = substr($number,2,2);
	$p3 = substr($number,4,2);
	$p4 = substr($number,6,2);
	$p5 = substr($number,8,2);
	$p6 = substr($number,10,3);
	$str = ten($p1) . "&" . ten($p2) . "&"  . ten($p3) . "&" . ten($p4) . "&" . ten($p5)  . "&" . ths($p6) ;
	echo $str;
	exit;
	
}


if ( $type == "numb" ) {
	$number = (int) $number;
	$len = strlen($number);
	$str= "";
	if ( $len % 2 ) {
		//ODD
		for ( $i = 0 ; $i < $len ; $i+=2 ) {
			if ( ($i+3 == $len) ) {
				$str .= ths(substr($number,$i,3));
				echo $str;
				exit;
			} else {
				$str .= ten(substr($number,$i,2)) . "&";
			}		
		}
		echo $str;
		exit;
	} 
	else {
		//EVEN
		for ( $i = 0 ; $i < $len ; $i+=2 ) {
			$str .= ten(substr($number,$i,2)) . "&";
		}
		echo substr($str,0,-1);
		exit;
	}	
}

if ( $type == "subs" ) {
	//$number = (int) $number;
	$len = strlen($number);
	$str= "";
	if ( $len % 2 ) {
		//ODD
		for ( $i = 0 ; $i < $len ; $i+=2 ) {
			if ( ($i+3 == $len) ) {
				$str .= ths(substr($number,$i,3));
				echo $str;
				exit;
			} else {
				$str .= ten(substr($number,$i,2)) . "&";
			}		
		}
		echo $str;
		exit;
	} 
	else {
		//EVEN
		for ( $i = 0 ; $i < $len ; $i+=2 ) {
			$str .= ten(substr($number,$i,2)) . "&";
		}
		echo substr($str,0,-1);
		exit;
	}	
}



if ( $type == "sub" )
	{
		if ( strlen($number) == 11 )
			{
				$p1 = substr($number,0,2);
				$p2 = substr($number,2,2);
				$p3 = substr($number,4,2);
				$p4 = substr($number,6,2);
				$p5 = substr($number,8,3);
				$str = ten($p1) . "&" . ten($p2) . "&"  . ten($p3) . "&" . ten($p4) . "&" . ths($p5) ;
			}
		if ( strlen($number) == 12 )
			{
				$p1 = substr($number,0,2);
				$p2 = substr($number,2,2);
				$p3 = substr($number,4,2);
				$p4 = substr($number,6,2);
				$p5 = substr($number,8,2);
				$p6 = substr($number,10,2);
				$str = ten($p1) . "&" . ten($p2) . "&"  . ten($p3) . "&" . ten($p4) . "&" . ten($p5) . "&" . ten($p6) ;
			}

		echo $str;
		exit;
	}
if ( $type == "mon" )
	{
		if ( $number < 999 ) {
			$str = thsmon($number);
			echo substr($str,-1) == "&" ? substr($str,0,-1):$str;
			exit;
		}
		
		$sect = explode(",",number_format($number));
		if ( count($sect) == 2 )
			$part = array( 0 => "digits/1000" , 1 => "" );
		if ( count($sect) == 3 )
			$part = array( 0 => "digits/1000000" , 1 => "digits/1000" , 2 => "" );
		if ( count($sect) == 4 )
			$part = array( 0 => "digits/1000000000" , 1 => "digits/1000000" , 2 => "digits/1000" , 3 => "" );
		
		$str = "";
		$max = count($sect);
		for( $i =0 ; $i < $max ; $i++ )
			{
				
				if ( $sect[$i] == 0 ) continue;
				//echo thsmon($sect[$i]) . "\n";
				$p = thsmon($sect[$i]) . $part[$i];
				if(isset($sect[$i+1]) && $sect[$i+1] > 0) 
					$p .="-o";
				
				$str .= $p;	
				if ( ($i+1) != $max )
					$str .= "&";
			}
		
		
		echo substr($str,-1) == "&" ? substr($str,0,-1):$str;
		exit;		
	
	}

if ( $type == "count" )
	{
		$sect = explode(",",number_format($number));
		if ( count($sect) == 2 )
			$part = array( 0 => "digits/1000" , 1 => "" );
		if ( count($sect) == 3 )
			$part = array( 0 => "digits/1000000" , 1 => "digits/1000" , 2 => "" );
		if ( count($sect) == 4 )
			$part = array( 0 => "digits/1000000000" , 1 => "digits/1000000" , 2 => "digits/1000" , 3 => "" );
		
		$str = "";
		$max = count($sect);
		for( $i =0 ; $i < $max ; $i++ )
			{
				
				if ( $sect[$i] == 0 ) continue;
				$p = thsmon($sect[$i]) . $part[$i];
				if(isset($sect[$i+1]) && $sect[$i+1] > 0) 
					$p .="-o";
				$str .= $p;	
				if ( ($i+1) != $max )
					$str .= "&";
			}
		
		//require_once "phpagi.php";
		//$agi = new AGI;
		//$agi->set_variable("COUNTSAY",$str);
		echo $str;
		exit;		
	
	}
	


	function ths($p1)
		{
			if ( $p1 == 0)
				return "digits/0&digits/0&digits/0";
			if ($p1 > 0 && $p1 < 10)
				return "digits/0&digits/0&digits/" . substr($p1,2,1);
			if ($p1 > 9 && $p1 <= 20)
				return "digits/0&digits/" . substr($p1,1,2);
			
			if ( $p1 > 20 && $p1 < 100 )
				{
					//if ( substr($p1,0,1) > 0 )
					if( substr($p1,2,1) == 0 )
						return "digits/0&digits/" . substr($p1,1,1) . "0";
					else
						return "digits/0&digits/" . substr($p1,1,1) . "0-o&digits/" . substr($p1,2,1);
					
				}
				
			$str = "digits/" . substr($p1,0,1) . "00";
			if( substr($p1,1,2) > 0 )
				{
					
					$str .= "-o&";
					
					if( substr($p1,1,2) < 10  )
						$str .= "digits/" . substr($p1,2);
					if( substr($p1,1,2) > 9 && substr($p1,1,2) < 20 )
						$str .= "digits/" . substr($p1,1);
					if( substr($p1,1,2) > 19 )
						{
							if( substr($p1,2) == 0)
								$str .= "digits/" . substr($p1,1);
							else
								$str .= "digits/" . substr($p1,1,1) . "0-o&" . "digits/" . substr($p1,2);
						}	
				}
			return $str;	
		}
	
		
	function ten($p)
		{
			
			if ( $p == 0 )
				return "digits/0&digits/0";
			if( $p < 10 )
				return "digits/0&digits/" . substr($p,1,1);
			if ( $p > 9 && $p < 20 )
				return "digits/$p";
			if ( substr($p,0,1) > 0 )
				if( substr($p,1,1) == 0 )
					return "digits/" . substr($p,0,1) . "0";
				else
					return "digits/" . substr($p,0,1) . "0-o&digits/" . substr($p,1,1);
		
		}
		
		
	function dayofmonth($p)
		{
			
			
			if( $p < 10 )
				return "digits/" . substr($p,1,1) . "-om";
			if ( $p > 9 && $p < 20 )
				return "digits/$p-om";
			if ( substr($p,0,1) > 0 )
				if( substr($p,1,1) == 0 )
					return "digits/" . substr($p,0,1) . "0-om";
				else
					return "digits/" . substr($p,0,1) . "0-o&digits/" . substr($p,1,1) . "-om";
		
		}
	
	
	function thsmon($p1)
		{
			//$p1 = $p1
			//echo "MON : $p1\n";
			if ( $p1 == 0  ) return "";
			
			if ($p1 > 0 && $p1 < 10)
				{
					if( strlen($p1) == 1)
						return "digits/$p1&";
					if ( strlen($p1) == 2 )
						return "digits/" . substr($p1,1,1) . "&";
					if ( strlen($p1) == 3 )
						return "digits/" . substr($p1,2,1) . "&";
						
				}
				
			if ($p1 > 9 && $p1 < 21)
				{
					if(strlen($p1) == 2 )
						return "digits/" . substr($p1,0,2) ."&";
					if( strlen($p1) == 3 )
						return "digits/" . substr($p1,1,2) ."&";
				}	
			
			if ( $p1 > 20 && $p1 < 100 )
				{
					if( strlen($p1) > 2 )
						$p1 = substr($p1,1,2);
					
					if ( substr($p1,0,1) > 0 )
						if( substr($p1,1,1) == 0 )
							return "digits/" . substr($p1,0,1) . "0&";
						else
							return "digits/" . substr($p1,0,1) . "0-o&digits/" . substr($p1,1,1) . "&";
				}
			$str = "digits/" . substr($p1,0,1) . "00";
			if( substr($p1,1,2) > 0 )
				{
					$str .= "-o&";
					if( substr($p1,1,2) < 10 )
						$str .= "digits/" . substr($p1,2) . "&";
					if( substr($p1,1,2) > 9 && substr($p1,1,2) < 20 )
						$str .= "digits/" . substr($p1,1) . "&";
					if( substr($p1,1,2) > 19 )
						{
							if( substr($p1,2) == 0)
								$str .= "digits/" . substr($p1,1) ."&";
							else
								$str .= "digits/" . substr($p1,1,1) . "0-o&" . "digits/" . substr($p1,2) ."&";
						}
					
				}
			else
				$str . "&";
			
			return $str;	
		}
		
		



