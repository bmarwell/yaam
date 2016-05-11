<?php
	error_reporting(0);
	require("config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/config.php");
	require_once("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require_once(SMARTY_DIR.'Smarty.class.php');

	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	$db = new cl_extended_database;
	@session_start();
	
	if( isset($_SESSION["user"]))
	{		

	$db = new cl_extended_database;
				echo "<div align='center'>
		<table border=2>
        <table width='*'>
	      <tr><th colspan='8'><font size='4' color='yellow'>Ranking nach CKK</font></th></tr>
	    
		
	      <tr/>
	        
	      
	      <tr>
		      <th colspan='8'>Gebashte CKK</th>
	      </tr>
		    
		<tr>
	        <td align='center'>&nbsp;Platz&nbsp;</td>
	        <td align='center'>&nbsp;Spieler&nbsp;</td>			
	        <td align='center'>&nbsp;CKK&nbsp;</td> </div>";
	
		$db->reinit();
		
		$sql = "SELECT SUM(`KB_CKK`) AS `CKKges`, `KB_UPLOADER` FROM `".$CONFIG['mysql']['prefix']."kbs` GROUP BY `KB_UPLOADER` ORDER BY `CKKges`DESC LIMIT 0, 30";
		global $i;
		$r = mysql_query($sql) or die("MySQL-Fehler: " . mysql_error());
		
		while ($row = mysql_fetch_array($r)) {$i++;
		

		    
		
	      		echo "
	      <tr>

		      <td align='center'>{$i}</td>
		      <td align='center'>
			 	&nbsp;{$row[1]}</a>&nbsp;
		      </td>
		      <td align='center'>
				&nbsp;{$row[0]}&nbsp;
		      </td>

		";
	 }
		
		
	}  
	// Wurde Skript fehlerhaft aufgerufen, verwerfen der Session
	else
	{
		echo "Session Destroy wird ausgeführt...";
		session_destroy();
		$smarty->display("error.tpl");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Allianzmanager der SuNriser</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>


</body>
</html>