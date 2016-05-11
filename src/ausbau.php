<?php
	require("config/config.php");
	session_start();
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/config.php");
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);

	$db = new cl_extended_database;
	
	// Keine Koordinaten übergeben??? Geht ja gar nicht...
	if( isset($_SESSION["user"]) && !isset($_GET['kid']) && !isset($_POST['update']) && !isset($_POST['update2']) )
	{
		$db->reinit();
		$smarty->assign("user_koords",$db->sql_koords($_SESSION["user"]));
   	$smarty->display("ausbau.tpl");
  	}
  	
  	// Koords normal übergeben, aber nur angucken
	elseif( isset($_SESSION["user"]) && isset($_GET['kid']) && !isset($_POST['update']) && !isset($_POST['update2']) )
   {
		$kid = $_GET['kid'];
		$db->reinit();

		$ausbau = $db->ausbau($kid);
		$smarty->assign("ausbau",$ausbau);
		$smarty->assign("kid",$kid);
		$smarty->assign("koord",$db->get_koord($kid));
		$smarty->display("ausbau.tpl");
	}
	
	// Hier wurde was geändert...
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update']))
	{
		$kid = $_POST['kid'];
		$db->ausbau_add($kid, $_POST['KZ'], $_POST['FZ'], $_POST['FeMine'], $_POST['LutRaff'], $_POST['Bohr'], $_POST['Chem'], $_POST['ErwChem'], $_POST['FeSpeicher'], $_POST['LutSpeicher'], $_POST['WasSpeicher'], $_POST['H2Speicher'], $_POST['SF'], $_POST['OV'], $_POST['Schild'], $_POST['Fusi']);
		
		// Jetzt wieder quasi das anzeigen von oben, aber mit changed = true		
		$smarty->assign("changed",1);
		$ausbau = $db->ausbau($kid);
		$smarty->assign("ausbau",$ausbau);
		$smarty->assign("kid",$kid);
		$smarty->assign("koord",$db->get_koord($kid));   
	   $smarty->display("ausbau.tpl");
	}

	// Böse: ein Parser muss her!
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{
		$kid = $_POST['kid'];
		$toparse = $_POST['ausbau_raw'];
		
		// parsen		
		// Erklärung: found ist die Position, an der der String auftaucht.
		// Da noch die Länge dazu, und man steht direkt auf der ersten Ziffer.
		// Die Länge (eine oder zwei oder drei stellen) ergibt sich aus der Fifferenz
		// von der Position der folgenden Klammer und der zuvor ermittelten Stelle der Ziffer.
		
		$KZ = $FZ = $FeMine = $LutRaff = $Bohr = $Chem = $ErwChem = $FeSpeicher = $LutSpeicher = $WasSpeicher = $H2Speicher = $SF = $OV = $Schild = $Fusi = 0;
		$noint = 0;
		$changed = 0;
		$delimiter = ')';		
		
		$comp = 'Kommandozentrale (Stufe ';
		$found = strpos($toparse, $comp);	
		if ($found == false)
			$KZ = 0;
		else	
			$KZ = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found);
			
		$comp = 'Forschungszentrum (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$FZ = 0;
		else
			$FZ = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
		
		$comp = 'Eisenmine (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$FeMine == 0;
		else
			$FeMine = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
				
		$comp = 'Lutinumraffinerie (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$LutRaff = 0;
		else
			$LutRaff = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
		
		$comp = 'Bohrturm (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Bohr = 0;
		else
			$Bohr = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
		
		$comp = 'Chemiefabrik (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Chem = 0;
		else
			$Chem = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );	
		
		$comp = 'Erweiterte Chemiefabrik (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$ErwChem = 0;
		else
			$ErwChem = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Eisenspeicher (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$FeSpeicher = 0;
		else
			$FeSpeicher = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Siliziumspeicher (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$LutSpeicher = 0;
		else
			$LutSpeicher = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
		
		$comp = 'Wassertanks (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$WasSpeicher = 0;
		else
			$WasSpeicher = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Wasserstofftanks (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$H2Speicher = 0;
		else
			$H2Speicher = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Schiffsfabrik (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$SF = 0;
		else
			$SF = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Orbitale Verteidigungsstation (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$OV = 0;
		else
			$OV = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Planetarer Schild (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Schild = 0;
		else
			$Schild = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );

		$comp = 'Fusionsreaktor (Stufe ';
		$found = strpos($toparse, $comp);
		if ($found == false)
			$Fusi = 0;
		else		
			$Fusi = substr($toparse, $found + strlen($comp), strpos($toparse, $delimiter, $found) - $found );
		
		// Hat er auch alles gefunden?
		// KZ muss es immer geben. Hat er DAS nicht erkannt - nicht weiter,
		// weil sonst alles 0 wird.
		if ( $KZ == 0 || $KZ == false ) 
			$noint = 1;		
		
		if ($noint == 0) 
		{
			// Jetzt, wo wir alles haben: Abschuss!
			$db->ausbau_add($kid, $KZ, $FZ, $FeMine, $LutRaff, $Bohr, $Chem, $ErwChem, $FeSpeicher, $LutSpeicher, $WasSpeicher, $H2Speicher, $SF, $OV, $Schild, $Fusi);
			$changed = 1;
		}
		
		
		// Jetzt wieder quasi das anzeigen von oben, aber mit changed = true		
		$smarty->assign("changed",$changed);
		$ausbau = $db->ausbau($kid);
		$smarty->assign("ausbau",$ausbau);
		$smarty->assign("kid",$kid);
		$smarty->assign("noint",$noint);
		$smarty->assign("koord",$db->get_koord($kid));   
	   $smarty->display("ausbau.tpl");
	}
		
	// Keine Session? Schade...
	else
   {
		session_destroy();
	   $smarty->display("error.tpl");
	}
?>