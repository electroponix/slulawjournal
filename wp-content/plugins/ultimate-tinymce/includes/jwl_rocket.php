<?php

	error_reporting(E_ALL ^ E_NOTICE);
	
	function SpinTax($s) {
	    preg_match('#{(.+?)}#is',$s,$m);
	    if(empty($m)) return $s;

	    $t = $m[1];

	    if(strpos($t,'{')!==false){
	            $t = substr($t, strrpos($t,'{') + 1);
	    }

	    $parts = explode("|", $t);
	    $s = preg_replace("+{".preg_quote($t)."}+is", $parts[array_rand($parts)], $s, 1);

	    return SpinTax($s);
	}
	
	$output = @file_get_contents("https://s3.amazonaws.com/UltimateMCE/output.txt"); 
	
	$str = "";
	
	if ($output === false ) {
   		$str= "";
	} else {
		$str = $output;
	}

	echo SpinTax($str);
	
	
?>