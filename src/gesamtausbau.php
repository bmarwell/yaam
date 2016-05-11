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
	
	// Template blanko ausgeben
	if(isset($_SESSION["user"]) && !isset($_POST['update']) && !isset($_POST['update2']) )
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		$db->reinit();
		$smarty->display("gesamtausbau.tpl");
  	}
	
	// Daten verarbeiten und Statusmeldung ueber Template ausgeben
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		$toparse = $_POST['gesamtausbau_raw'];
		$KZ = $FZ = $FeMine = $LutRaff = $Bohr = $Chem = $ErwChem = $FeSpeicher = $LutSpeicher = $WasSpeicher = $H2Speicher = $SF = $OV = $Schild = $Fusi = "";
		$wrongdata = 0;
		$wrongplani = 0;
		$changed = 0;
		
		// - durch 0 ersetzen und Tabs von Opera und Firefox durch Leerzeichen ersetzen
		$toparse = str_replace ("-", "0", $toparse);
		$toparse = preg_replace ("/\t/", " ", $toparse);
		
		// Klammerung filtern & Leerzeichenfehler beheben
		$toparse = str_replace ("(", "<", $toparse);
		$toparse = str_replace (")", "/>", $toparse);
		$toparse = strip_tags($toparse);
		$toparse = str_replace ("  ", " ", $toparse);
		$toparse = str_replace (".", "", $toparse);		
		
		$toparse = trim($toparse);

		// Zeilen der Gesamtuebersicht in Array schreiben
		$parselines = preg_split("/\n/", $toparse);
		
		//h_debug_array("Parselines:",$parselines);
		
		$Ueberschrift = $parselines[0];
		$koords = $db->sql_koords($uid);
		
		// Pruefen, ob Daten korrekt sind anhand der Ueberschrift der Gesamtuebersicht	
		if (strpos($Ueberschrift, "esamt")){
			
			// Zeilen den entsprechenden Gebaeuden zuordnen
			// trim, da Daten in IE anders dargestellt werden als in Opera und FF
			$planis = preg_split("/ /", trim($parselines[1]));
  			$KZ = preg_split("/ /", trim($parselines[10]));
			$FZ = preg_split("/ /", trim($parselines[11]));
			$FeMine = preg_split("/ /", trim($parselines[12]));
			$LutRaff = preg_split("/ /", trim($parselines[13]));
			$Bohr = preg_split("/ /", trim($parselines[14]));
			$Chem = preg_split("/ /", trim($parselines[15]));
			$ErwChem = preg_split("/ /", trim($parselines[16]));
			$FeSpeicher = preg_split("/ /", trim($parselines[17]));
			$LutSpeicher = preg_split("/ /", trim($parselines[18]));
			$WasSpeicher = preg_split("/ /", trim($parselines[19]));
			$H2Speicher = preg_split("/ /", trim($parselines[20]));
			$SF = preg_split("/ /", trim($parselines[21]));
			$OV = preg_split("/ /", trim($parselines[22]));
			$Schild = preg_split("/ /", trim($parselines[23]));
			$Fusi = preg_split("/ /", trim($parselines[24]));
			
			$Sonden = preg_split("/ /", trim($parselines[28]));
			$Recycler = preg_split("/ /", trim($parselines[27]));
			$Tjugar = preg_split("/ /", trim($parselines[33]));
			$Cougar = preg_split("/ /", trim($parselines[34]));
			$LeV = preg_split("/ /", trim($parselines[35]));
			$Noah = preg_split("/ /", trim($parselines[38]));
			$LeX = preg_split("/ /", trim($parselines[39]));
			$Schakal = preg_split("/ /", trim($parselines[26]));
			$Rene = preg_split("/ /", trim($parselines[29]));
			$Raid = preg_split("/ /", trim($parselines[30]));
			$Tarn = preg_split("/ /", trim($parselines[31]));
			$Kolo = preg_split("/ /", trim($parselines[32]));
			$Klein = preg_split("/ /", trim($parselines[36]));
			$Gross = preg_split("/ /", trim($parselines[37]));
			
			//h_debug_array("Cougar:",$Cougar);
			// Flotten die unterwegs sind einem Plani zuordnen
			$unterw=count($planis)-2;
			
			$Sonden[1]+=$Sonden[$unterw];
			$Recycler[1]+=$Recycler[$unterw];
			$Tjugar[1]+=$Tjugar[$unterw];
			$Cougar[1]+=$Cougar[$unterw];
			$LeV[2]+=$LeV[$unterw+1];
			$Noah[1]+=$Noah[$unterw];
			$LeX[2]+=$LeX[$unterw+1];
			$Schakal[1]+=$Schakal[$unterw];
			$Rene[1]+=$Rene[$unterw];
			$Raid[1]+=$Raid[$unterw];
			$Tarn[1]+=$Tarn[$unterw];
			$Kolo[1]+=$Kolo[$unterw];
			$Klein[2]+=$Klein[$unterw+1];
			$Gross[2]+=$Gross[$unterw+1];
			
			//h_debug_array("Cougar++:",$Cougar);			
			
			// Anhand der KZ Anzahl der Planis im Spiel ermitteln und Anzahl der Planis in der DB ermitteln
			$planisgame = count($KZ)-3;
			$planisdb = count($koords);
			
			// Koordinaten  auf 000:000:00 umwandeln und Fehlende ergaenzen
			for ($i = 1; $i <=(count($planis)-3); $i++){
				$koordinate = preg_split("/:/",$planis[$i]);

				if ($koordinate[0]<10) $koordinate[0] = '00'.($koordinate[0]+0);
				elseif ($koordinate[0]<100) $koordinate[0] = '0'.($koordinate[0]+0);

				if ($koordinate[1]<10) $koordinate[1] = '00'.($koordinate[1]+0);
				elseif ($koordinate[1]<100) $koordinate[1] = '0'.($koordinate[1]+0);

				if ($koordinate[2]<10) $koordinate[2] = '0'.($koordinate[2]+0);

				$koordinate = $koordinate[0].":".$koordinate[1].":".$koordinate[2];
				$planis[$i] = $koordinate;
			}
			
			// Fehlende Planis werden ergaenzt
			if ($planisgame != $planisdb){
				for ($i = 1; $i <=(count($planis)-3); $i++){
					$exist = $db->find_koords($planis[$i]);
					if ($exist != $planis[$i]) {
						$db->add_koord($planis[$i], $uid);
						echo "Planet ".$planis[$i]." wurde hinzugef&uuml;gt!<br />";
					}
				}				
			}

			$koords = $db->sql_koords($uid);

			// Eintragen der ausgelesenen Daten in die Datenbank
			// Index der Gebaeudearrays um die Anzahl der Worte vor den Ausbaustufen in der Gesamtuebersicht erhoeht
			for ($i = 0; $i <(count($planis)-3); $i++){
				$koorSuch="";
				
				for ($x = 0; $x <(count($koords)); $x++){
					if (strcmp($koords[$x]['koord'], $planis[$i+1])==0) {
						$koorSuch=$koords[$x]['kid'];
					}
				}								
			
				echo "Planet ".$planis[$i+1]." wurde upgedated! ".$koorSuch."<br />";
				$db->ausbau_add($koorSuch, $KZ[$i+1], $FZ[$i+1], $FeMine[$i+1], $LutRaff[$i+1], $Bohr[$i+1], $Chem[$i+1], $ErwChem[$i+2], $FeSpeicher[$i+1], $LutSpeicher[$i+1], $WasSpeicher[$i+1], $H2Speicher[$i+1], $SF[$i+1], $OV[$i+2], $Schild[$i+2], $Fusi[$i+1]);
				
				echo "Flotten von Planet ".$planis[$i+1]." wurden upgedated! ".$koorSuch."<br />";
				$db->flotte_add($koorSuch, $Sonden[$i+1], $Recycler[$i+1], $Tjugar[$i+1], $Cougar[$i+1], $LeV[$i+2], $Noah[$i+1], $LeX[$i+2], $Schakal[$i+1], $Rene[$i+1], $Raid[$i+1], $Tarn[$i+1], $Kolo[$i+1], $Klein[$i+2], $Gross[$i+2]);
			}
			// Flag setzen, dass Daten eingetragen wurden
			$changed = 1;

		}
		// Flag setzen, dass die ins Textfeld kopierten Daten nicht verarbeitbar sind
		else $wrongdata = 1;
		
		// Flags ans Template uebergeben und Template anzeigen
		$smarty->assign("changed",$changed);
		$smarty->assign("wrongdata",$wrongdata);
		$smarty->assign("wrongplani",$wrongplani);
		$smarty->display("gesamtausbau.tpl");
	}
	
	// Wurde Skript nicht vom AM aufgerufen, verwerfen der Session
	else
	{
		echo "Session Destroy wird ausgeführt...";
		session_destroy();
		$smarty->display("error.tpl");
	}
?>