<?php
	error_reporting(0);
	require("config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	session_start();

	$db = new cl_extended_database;
	
	// Keine Koordinaten übergeben??? Geht ja gar nicht...
	if( isset($_SESSION["user"]) && !isset($_GET['kid']) && !isset($_POST['update']) && !isset($_POST['update2']) )
	{
		$db->reinit();
		$smarty->assign("user_koords",$db->sql_koords($_SESSION["user"]));
   		$smarty->display("flotte.tpl");
  	}
  	
  	// Koords normal übergeben, aber nur angucken
	elseif( isset($_SESSION["user"]) && isset($_GET['kid']) && !isset($_POST['update']) && !isset($_POST['update2']) )
   {
		$kid = $_GET['kid'];
		$db->reinit();

		$flotte = $db->flotte($kid);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("kid",$kid);
		$smarty->assign("koord",$db->get_koord($kid));
		$smarty->display("flotte.tpl");
	}
	
	// Hier wurde was geändert...
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update']))
	{
		$kid = $_POST['kid'];
		$db->flotte_add($kid, $_POST['Sonden'], $_POST['Recycler'], $_POST['Tjugar'], $_POST['Cougar'], $_POST['LeV'], $_POST['Noah'], $_POST['LeX'], $_POST['Schakal'], $_POST['Rene'], $_POST['Raid'], $_POST['Tarn'], $_POST['Kolo'], $_POST['Klein'], $_POST['Gross']);
		
		// Jetzt wieder quasi das anzeigen von oben, aber mit changed = true		
		$smarty->assign("changed",1);
		$flotte = $db->flotte($kid);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("kid",$kid);
		$smarty->assign("koord",$db->get_koord($kid));   
		$smarty->display("flotte.tpl");
	}

	// Böse: ein Parser muss her!
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{
		$kid = $_POST['kid'];
		$toparse = $_POST['flotte_raw'];
		
		// parsen		
		// Erklärung: found ist die Position, an der der String auftaucht.
		// Da noch die Länge dazu, und man steht direkt auf der ersten Ziffer.
		// Die Länge (eine oder zwei oder drei stellen) ergibt sich aus der Fifferenz
		// von der Position der folgenden Klammer und der zuvor ermittelten Stelle der Ziffer.
		
		$Recycler = $Sonden = $Tjugar = $Cougar = $LeV = $Noah = $LeX = $Schakal = $Rene = $Raid = $Tarn = $Kolo = $Klein = $Gross = 0;

		$changed = 0;
		
		// Daten interpretieren		
			$delimiter = ')';		

			$comp = 'Spionagesonde ( ';
			$found = strpos($toparse, $comp);
	        if ($found == false)
				$Sonden = 0;
			else
				$Sonden = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found);
			
			$comp = 'Recycler ( ';
			$found = strpos($toparse, $comp);
	        if ($found == false)
				$Recycler = 0;
			else
				$Recycler = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found);

			$comp = 'Tjuger ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Tjugar = 0;
			else
				$Tjugar = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
			
			$comp = 'Cougar ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Cougar = 0;
			else
				$Cougar = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
					
			$comp = 'Longeagle V ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$LeV = 0;
			else
				$LeV = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
			
			$comp = 'Ikarus ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Noah = 0;
			else
				$Noah = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
			
			$comp = 'Longeagle X ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$LeX = 0;
			else
				$LeX = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
			
           	 $comp = 'Schakal ( ';
			 $found = strpos($toparse, $comp);
	        	 if ($found == false)
				$schakal = 0;
			else
				$Schakal = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found);

			$comp = 'Renegade ( ';
			$found = strpos($toparse, $comp);
	      		if ($found == false)
				$Rene = 0;
			else
				$Rene = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found);

			$comp = 'Raider ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Raid = 0;
			else
				$Raid = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

			$comp = 'Tarnbomber ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Tarn = 0;
			else
				$Tarn = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

			$comp = 'Kolonisationsschiff ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Kolo = 0;
			else
				$Kolo = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

			$comp = 'Kleines Handelsschiff ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Klein = 0;
			else
				$Klein = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

			$comp = 'Großes Handelsschiff ( ';
			$found = strpos($toparse, $comp);
			if ($found == false)
				$Gross = 0;
			else
				$Gross = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );	

		
		// Jetzt, wo wir alles haben: Abschuss!
		$db->flotte_add($kid, $Sonden, $Recycler, $Tjugar, $Cougar, $LeV, $Noah, $LeX, $Schakal, $Rene, $Raid, $Tarn, $Kolo, $Klein, $Gross );
		$changed = 1;
		
		// Jetzt wieder quasi das anzeigen von oben, aber mit changed = true		
		$smarty->assign("changed",$changed);
		$flotte = $db->flotte($kid);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("kid",$kid);
		$smarty->assign("koord",$db->get_koord($kid));   
	    $smarty->display("flotte.tpl");
	}
		
	// Keine Session? Schade...
	else
   {
		session_destroy();
		$smarty->display("error.tpl");
	}
?>