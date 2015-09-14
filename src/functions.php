<?php

function url($to = '/'){
	// Make sure it has a leading /
	if (strpos($to, '/') !== 0){
		$to = '/' . $to;
	}

	$retval = $to;
	if (array_key_exists('HTTP_HOST', $_SERVER)){
		$retval = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' .
			$_SERVER['HTTP_HOST'] . $to;
	}

	return $retval;
}

function app(){
	global $app;

	return $app;
}
