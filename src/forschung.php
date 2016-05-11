<?php
	error_reporting(E_ALL);
	require("config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/config.php");
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	session_start();
	
	$db = new cl_extended_database;
	
	// Forschung lesen und anzeigen...
	if(isset($_SESSION["user"]) && !isset($_POST['update']) && !isset($_POST['update2']) )
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$db->reinit();
		
		$smarty->assign("forschung",$db->forschung($uid));
   	$smarty->display("forschung.tpl");
  	}
  	
  	// Hier will wer ein paar Daten ändern...
	elseif( isset($_SESSION["user"]) && isset($_POST['update']) )
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		
		// Abschuss...
		$db->forschung_add($uid,$_POST['VbA'],$_POST['IoA'],$_POST['RkA'],$_POST['RfA'],$_POST['Ionis'],$_POST['Energ'],$_POST['Explo'],$_POST['Spio'],$_POST['Panzer'],$_POST['LadeKapa'],$_POST['Recycler']);
	
		$smarty->assign("changed",1);
		$smarty->assign("forschung",$db->forschung($uid));	
		$smarty->display("forschung.tpl");
	}

	// Böse: ein Parser muss her!
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		$toparse = ($_POST['forschung_raw']);
		
		//$toparse = preg_replace("/&uuml;/", 'ü', $toparse);
		//$toparse = preg_replace("/&Uuml;/", 'Ü', $toparse);
		//$toparse = preg_replace("/&Auml;/", 'A', $toparse);
		//$toparse = preg_replace("/&auml;/", 'a', $toparse);
		//$toparse = preg_replace("/&ouml;/", 'o', $toparse);
		//$toparse = preg_replace("/&Ouml;/", 'O', $toparse);
		//$toparse = preg_replace("/&szlig;/", 'ß', $toparse);
		//$toparse = htmlentities($toparse, ENT_QUOTES, 'utf-8');
		// parsen		
		// Erklärung: found ist die Position, an der der String auftaucht.
		// Da noch die Länge dazu, und man steht direkt auf der ersten Ziffer.
		// Die Länge (eine oder zwei oder drei stellen) ergibt sich aus der Fifferenz
		// von der Position der folgenden Klammer und der zuvor ermittelten Stelle der Ziffer.
		
		$VbA = $IoA = $RkA = $RfA = $Ionis = $Energ = $Explo = $Spio = $LadeKapa = $Panzer = $Recycler = 0;
		$noint = 0;
		$changed = 0;
		$delimiter = ')';		
		
		$comp = 'Verbrennungsantrieb (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$VbA = 0;
		else
			$VbA = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
						
		$comp = 'Ionenantrieb (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$IoA = 0;
		else
			$IoA = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		// ACHTUNG! Sieht komisch aus, ist aber richtig!
		$comp = 'Raumkr';
		$found = strpos($toparse, $comp);
		//echo $found.'<br>';
		$comp = 'Raumkrummungsantrieb (Stufe '; // nur für die Länge da!
		if ($found == false)
			$RkA = 0;
		else
			$RkA = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
				
		$comp = 'Raumfaltungsantrieb (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$RfA = 0;
		else
			$RfA = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		$comp = 'Ionisation (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Ionis = 0;
		else
			$Ionis = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		$comp = 'Energieb';
		$found = strpos($toparse, $comp);
		$comp = 'Energiebundelung (Stufe '; // nur für die Länge da!
		if ($found == false)
			$Energ = 0;
		else
			$Energ = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		$comp = 'Explosivgeschosse (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Explo = 0;
		else
			$Explo = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));

		$comp = 'Spionagetechnik (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Spio = 0;
		else
			$Spio = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		$comp = 'Ladekapazit';
		$found = strpos($toparse, $comp);
		$comp = 'Ladekapazitat (Stufe '; // nur für die Länge da!
		if ($found == false)
			$LadeKapa = 0;
		else
			$LadeKapa = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		$comp = 'Erweiterte Schiffspanzerung (Stufe ';
		$found = strpos($toparse, $comp);
		//echo "found=" . $found. "<br>";
		if ($found === false)
			$Panzer = 0;
		else
			$Panzer = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		$comp = 'Recycling-Technik (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Recycler = 0;
		else
			$Recycler = substr($toparse, $found + strlen($comp), ((strpos($toparse, $delimiter, $found)-$found)-strlen($comp)));
		
		// Hat er auch alles gefunden?
		// VbA muss es immer geben. Hat er DAS nicht erkannt - nicht weiter,
		// weil sonst alles 0 werden könnte...
		if ( $VbA == 0 || $VbA == false ) 
			$noint = 1;		
		
		if ($noint == 0) 
		{
			// Jetzt, wo wir alles haben: Abschuss!
			$db->forschung_add($uid,$VbA,$IoA,$RkA,$RfA,$Ionis,$Energ,$Explo,$Spio,$Panzer,$LadeKapa,$Recycler);
			$changed = 1;
		}
		
		
		// Jetzt wieder quasi das anzeigen von oben, aber mit changed = true		
		$smarty->assign("changed",$changed);
		$smarty->assign("noint",$noint);
		$smarty->assign("forschung",$db->forschung($uid));	
		$smarty->display("forschung.tpl");
	}	
	// Autsch... tut weh...
	else
   {
		session_destroy();
	    $smarty->display("error.tpl");
	}
?>