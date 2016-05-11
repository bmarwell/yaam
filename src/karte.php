<?php
	error_reporting(E_ALL);
	require("config/config.php");
	require("log/hlog.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/config.php");
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	session_start();
	
	$db = new cl_extended_database;
	$uid = $db->user_get_id($_SESSION["user"]);
	
	// Template blanko ausgeben
	if(isset($_SESSION["user"]) && !isset($_POST['update']) && !isset($_POST['update2']) )
	{
		$db->reinit();
		$smarty->assign("rechte",$db->rechte($uid));		
		$smarty->display("karte.tpl");
  	}
	
	// Daten verarbeiten und Statusmeldung ueber Template ausgeben
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{		
		$toparse = $_POST['angriffsdaten_raw'];
		$koor="";
		$wrongdata = 0;
		$wrongplani = 0;
		$changed = 0;
		
		// - durch 0 ersetzen und Tabs von Opera und Firefox durch Leerzeichen ersetzen
		$toparse = str_replace ("-", "0", $toparse);
		$toparse = preg_replace ("/\t/", " ", $toparse);
		
		$toparse = trim($toparse);

		// In Array schreiben
		$parselines = preg_split("/\n/", $toparse);
		
		//h_debug_array("Nachrichten:",$parselines);
		$Ueberschrift="";
		for ($i = 0; $i <=(count($parselines)-1); $i++) {		
			if (strpos($parselines[$i], "rdner")) {
						$Ueberschrift = $parselines[$i];
			}
		}
		
		// Pruefen, ob Daten korrekt sind	
		if (strlen($Ueberschrift)>0) {			
			// Koordinaten  auf 000:000:00 umwandeln 
			for ($i = 0; $i <=(count($parselines)-1); $i++){
			
				$koordinate = preg_split("/Eine Flotte vom Planeten/",$parselines[$i]);
				if (count($koordinate)>1) {
					//h_debug_array("koordinate0:",$koordinate);
					
					$koordinate = preg_split("/:/",$koordinate[1]);
	
					//h_debug_array("koordinate1:",$koordinate);
					
					if (count($koordinate)==5) {
					    $tmpK=preg_split("/ /",$koordinate[2]);
						$koordinate[2] = $tmpK[0];
						if ($koordinate[0]<10) $koordinate[0] = '00'.($koordinate[0]+0);
						elseif ($koordinate[0]<100) $koordinate[0] = '0'.($koordinate[0]+0);
		
						if ($koordinate[1]<10) $koordinate[1] = '00'.($koordinate[1]+0);
						elseif ($koordinate[1]<100) $koordinate[1] = '0'.($koordinate[1]+0);
		
						if ($koordinate[2]<10) $koordinate[2] = '0'.($koordinate[2]+0);
		
						$koordinate = $koordinate[0].":".$koordinate[1].":".$koordinate[2];
						//h_debug_array("koordinate2:",$koordinate);
						$changed = 1;
						
						if (strpos($parselines[$i+1], "lottenbefehl: Angreifen")) {
							//Feindkoordinate eintragen
							$db->add_koordOnly(trim($koordinate), 255);
							echo "Feindkoordinate ".$koordinate . " eingetragen!<br>";
						}
					}
				}
			}
		}
		// Flag setzen, dass die ins Textfeld kopierten Daten nicht verarbeitbar sind
		else $wrongdata = 1;
		
		// Flags ans Template uebergeben und Template anzeigen
		$smarty->assign("changed",$changed);
		$smarty->assign("wrongdata",$wrongdata);
		$smarty->assign("rechte",$db->rechte($uid));
		$smarty->display("karte.tpl");
	}
	
	// Wurde Skript nicht vom AM aufgerufen, verwerfen der Session
	else
	{
		echo "Session Destroy wird ausgeführt...";
		session_destroy();
		$smarty->display("error.tpl");
	}
?>