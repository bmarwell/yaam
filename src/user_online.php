<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<script language="JavaScript" type="text/javascript" src="pwgen.js"></script>
</head>

<?php
	$datei = "useronline.dat";
	$min = 7;
	$time = time() - $min*60;
	$current_ip = $_SERVER['REMOTE_ADDR'];
	
	// alte Beiträge löschen
	if(file_exists($datei)) {
	    $lines = file($datei);
	    foreach($lines as $key=>$data) {
	        list($ip, $timest) = explode("µ", $data);
	        if(trim($timest) < $time
	            || trim($ip) == $current_ip) {
	            unset($lines[$key]);
	        }
	    }
	}
	
	$lines[] = $current_ip."µ".time()."\n";
	$save = implode("", $lines);
	$handle = fopen($datei, "w");
	fputs($handle, $save);
	fclose($handle);
	$user = count($lines);
	if($user == 1) {
	    echo "Es ist 1 User online!";
	} else {
	    echo "Es sind ".$user." User online!";
}
?> 

</body>
</html>

