<?php
	error_reporting(E_ALL);
	require("config/config.php");
	require("log/hlog.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	session_start();
	
	$db = new cl_extended_database;
	$uid = $db->user_get_id($_SESSION["user"]);
	$hsanz=$db->get_highscoreAnzahl();

	$smarty->assign("hsanz",$hsanz[0]['count(*)']);
	
	// Template blanko ausgeben
	if(isset($_SESSION["user"]) && !isset($_POST['update1']) && !isset($_POST['update2']) )
	{
		$db->reinit();
		$smarty->assign("rechte",$db->rechte($uid));		
		$smarty->display("finder.tpl");
  	}
	
	// Daten verarbeiten und Statusmeldung ueber Template ausgeben
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{		
		$toparse = $_POST['highscoredaten_raw'];
		$koor="";
		$wrongdata = 0;
		$wrongplani = 0;
		$changed = 0;
		$startIndex = 0;
		
		// - durch 0 ersetzen und Tabs von Opera und Firefox durch Leerzeichen ersetzen
		$toparse = preg_replace ("/\t/", " ", $toparse);
		$toparse = str_replace (".", "", $toparse);
		
		$toparse = trim($toparse);

		// In Array schreiben
		$parselines = preg_split("/\n/", $toparse);
		
		//h_debug_array("Daten:",$parselines);
		$Ueberschrift="";
		for ($i = 0; $i <=(count($parselines)-1); $i++) {		
			if (strpos($parselines[$i], "laneten")) {
						$Ueberschrift = $parselines[$i];
						$startIndex = $i;
			}
		}
		
		$c=0;
		// Pruefen, ob Daten korrekt sind
		if (strlen($Ueberschrift)>0) {					
			for ($i = $startIndex+1; $i <(count($parselines)); $i++){
			
				$player = preg_split("#(\[.* .*\])|\s+#Uis",$parselines[$i], -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
				
				//h_debug_array("player:" . count($player),$player);
				
				if (isset($_POST['sub1'])) {
					
					if (count($player)==8) {
							if (empty($player[3]) || $player[3]=="")
									$player[3]="";
							$db->highscore_insertOrUpdate($player[2], $player[5], $player[4], $player[7], $player[3]);				
					}
					
					if (count($player)==7) {
							if (empty($player[7]))
								$player[7]=0;
							$db->highscore_insertOrUpdate($player[2], $player[5], $player[4], $player[7], "keine Ally");				
					}
					if (count($player)<7 || count($player)>8) {
						h_debug_array("Daten falsch:",$player);
					}
					$changed = 1;
				}				

				if (isset($_POST['sub2'])) {
					if (count($player)==8) {
						$tmp=$db->get_inactiveHighscoreMember($player[2], $player[5], $player[4]);
						if (is_array($tmp)) {
							$erg[$c]=$tmp[0];
							$c++;							
						}
					}
					if (count($player)==7) {
						$tmp=$db->get_inactiveHighscoreMember($player[2], $player[5], $player[4]);

						if (is_array($tmp)) {
							$erg[$c]=$tmp[0];
							$c++;
						}
					}
					if (count($player)<7 || count($player)>8) {
					}
					
					
					$changed = 0;
				}
				
			}
			
		}
		
		// Flag setzen, dass die ins Textfeld kopierten Daten nicht verarbeitbar sind
		else $wrongdata = 1;
	
		$hsanz=$db->get_highscoreAnzahl();	

		// Flags ans Template uebergeben und Template anzeigen
		if ($c>0) {
			$smarty->assign("erg",$erg);
			//h_debug_array("erg:",$erg);
		}
		$smarty->assign("changed",$changed);
		$smarty->assign("wrongdata",$wrongdata);
		$smarty->assign("rechte",$db->rechte($uid));
		$smarty->assign("hsanz",$hsanz[0]['count(*)']);
		$smarty->display("finder.tpl");
	}
	elseif( isset($_SESSION["user"]) && isset($_POST['update1']))
	{	
		$erg=$db->get_highscoreMemberWithTag($_POST['allytag']);
		
		//h_debug_array("erg:",$erg);
		
		// Flags ans Template uebergeben und Template anzeigen
		$smarty->assign("rechte",$db->rechte($uid));
		
		if (count($erg)>0) {
			$smarty->assign("erg",$erg);		
		}
		$smarty->display("finder.tpl");
	}
	
	// Wurde Skript nicht vom AM aufgerufen, verwerfen der Session
	else
	{
		echo "Session Destroy wird ausgeführt...";
		session_destroy();
		$smarty->display("error.tpl");
	}
?>