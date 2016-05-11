<?php
	/***************************************************************
	*  Copyright notice
	*
	*  (c) 2008 Sebastian Meese aka JabbaTheHood
	*  All rights reserved
	*
	*  This script is free software; you can redistribute it and/or modify
	*  it under the terms of the GNU General Public License as published by
	*  the Free Software Foundation; either version 2 of the License, or#"] 
	*  (at your option) any later version.
	*
	*  The GNU General Public License can be found at
	*  http://www.gnu.org/copyleft/gpl.html.
	*
	*  This script is distributed in the hope that it will be useful,
	*  but WITHOUT ANY WARRANTY; without even the implied warranty of
	*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	*  GNU General Public License for more details.
	*
	*  This copyright notice MUST APPEAR in all copies of the script!
	***************************************************************/
	
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
	
	// Template blanko ausgeben
	if(isset($_SESSION["user"]) && !isset($_POST['update']) && !isset($_POST['update2']) )
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		$db->reinit();
		$smarty->display("inaktive.tpl");
  	}
	
	// Daten verarbeiten und Statusmeldung ueber Template ausgeben
	// Inhaltliche Pruefung der Daten fehlt noch!
	elseif( isset($_SESSION["user"]) && isset($_POST['kid']) && isset($_POST['update2']))
	{
		$changed=0;
		$wrongdata=0;
		$wrongfields=0;
		$uid = $db->user_get_id($_SESSION["user"]);
		
		if (!($_POST['part1']=="" || $_POST['part2']=="" || $_POST['part3']=="" || $_POST['part4']=="" || $_POST['part5']=="" || $_POST['part6']=="" || $_POST['part7']=="" || $_POST['part8']=="" || $_POST['part9']=="" || $_POST['part10']=="" || $_POST['part11']=="" || $_POST['part12']=="" || $_POST['part13']=="" || $_POST['part14']=="" || $_POST['part15']=="" || $_POST['part16']=="" || $_POST['part17']=="" || $_POST['part18']=="" || $_POST['part19']=="" || $_POST['part20']=="")) {
			
			// Aus uebergebenen Daten Kopf entfernen
			$toparse1 = $_POST['part1'];
			$toparse1 = preg_split("/Planeten/", $toparse1);
			$toparse1 = $toparse1[3];
			$toparse2 = $_POST['part2'];
			$toparse2 = preg_split("/Planeten/", $toparse2);
			$toparse2 = $toparse2[3];
			$toparse3 = $_POST['part3'];
			$toparse3 = preg_split("/Planeten/", $toparse3);
			$toparse3 = $toparse3[3];
			$toparse4 = $_POST['part4'];
			$toparse4 = preg_split("/Planeten/", $toparse4);
			$toparse4 = $toparse4[3];
			$toparse5 = $_POST['part5'];
			$toparse5 = preg_split("/Planeten/", $toparse5);
			$toparse5 = $toparse5[3];
			$toparse6 = $_POST['part6'];
			$toparse6 = preg_split("/Planeten/", $toparse6);
			$toparse6 = $toparse6[3];
			$toparse7 = $_POST['part7'];
			$toparse7 = preg_split("/Planeten/", $toparse7);
			$toparse7 = $toparse7[3];
			$toparse8 = $_POST['part8'];
			$toparse8 = preg_split("/Planeten/", $toparse8);
			$toparse8 = $toparse8[3];
			$toparse9 = $_POST['part9'];
			$toparse9 = preg_split("/Planeten/", $toparse9);
			$toparse9 = $toparse9[3];
			$toparse10 = $_POST['part10'];
			$toparse10 = preg_split("/Planeten/", $toparse10);
			$toparse10 = $toparse10[3];
			$toparse11 = $_POST['part11'];
			$toparse11 = preg_split("/Planeten/", $toparse11);
			$toparse11 = $toparse11[3];
			$toparse12 = $_POST['part12'];
			$toparse12 = preg_split("/Planeten/", $toparse12);
			$toparse12 = $toparse12[3];
			$toparse13 = $_POST['part13'];
			$toparse13 = preg_split("/Planeten/", $toparse13);
			$toparse13 = $toparse13[3];
			$toparse14 = $_POST['part14'];
			$toparse14 = preg_split("/Planeten/", $toparse14);
			$toparse14 = $toparse14[3];
			$toparse15 = $_POST['part15'];
			$toparse15 = preg_split("/Planeten/", $toparse15);
			$toparse15 = $toparse15[3];
			$toparse16 = $_POST['part16'];
			$toparse16 = preg_split("/Planeten/", $toparse16);
			$toparse16 = $toparse16[3];
			$toparse17 = $_POST['part17'];
			$toparse17 = preg_split("/Planeten/", $toparse17);
			$toparse17 = $toparse17[3];
			$toparse18 = $_POST['part18'];
			$toparse18 = preg_split("/Planeten/", $toparse18);
			$toparse18 = $toparse18[3];
			$toparse19 = $_POST['part19'];
			$toparse19 = preg_split("/Planeten/", $toparse19);
			$toparse19 = $toparse19[3];
			$toparse20 = $_POST['part20'];
			$toparse20 = preg_split("/Planeten/", $toparse20);
			$toparse20 = $toparse20[3];
			
			// Tabs von Opera und Firefox durch Leerzeichen ersetzen
			$toparse1 = preg_replace ("/\t/", " ", $toparse1);
			$toparse2 = preg_replace ("/\t/", " ", $toparse2);
			$toparse3 = preg_replace ("/\t/", " ", $toparse3);
			$toparse4 = preg_replace ("/\t/", " ", $toparse4);
			$toparse5 = preg_replace ("/\t/", " ", $toparse5);
			$toparse6 = preg_replace ("/\t/", " ", $toparse6);
			$toparse7 = preg_replace ("/\t/", " ", $toparse7);
			$toparse8 = preg_replace ("/\t/", " ", $toparse8);
			$toparse9 = preg_replace ("/\t/", " ", $toparse9);
			$toparse10 = preg_replace ("/\t/", " ", $toparse10);
			$toparse11 = preg_replace ("/\t/", " ", $toparse11);
			$toparse12 = preg_replace ("/\t/", " ", $toparse12);
			$toparse13 = preg_replace ("/\t/", " ", $toparse13);
			$toparse14 = preg_replace ("/\t/", " ", $toparse14);
			$toparse15 = preg_replace ("/\t/", " ", $toparse15);
			$toparse16 = preg_replace ("/\t/", " ", $toparse16);
			$toparse17 = preg_replace ("/\t/", " ", $toparse17);
			$toparse18 = preg_replace ("/\t/", " ", $toparse18);
			$toparse19 = preg_replace ("/\t/", " ", $toparse19);
			$toparse20 = preg_replace ("/\t/", " ", $toparse20);
			
			// Zeilen der Gesamtuebersicht in Arrays schreiben
			$parselines1 = preg_split("/\n/", $toparse1);
			$parselines2 = preg_split("/\n/", $toparse2);
			$parselines3 = preg_split("/\n/", $toparse3);
			$parselines4 = preg_split("/\n/", $toparse4);
			$parselines5 = preg_split("/\n/", $toparse5);
			$parselines6 = preg_split("/\n/", $toparse6);
			$parselines7 = preg_split("/\n/", $toparse7);
			$parselines8 = preg_split("/\n/", $toparse8);
			$parselines9 = preg_split("/\n/", $toparse9);
			$parselines10 = preg_split("/\n/", $toparse10);
			$parselines11 = preg_split("/\n/", $toparse11);
			$parselines12 = preg_split("/\n/", $toparse12);
			$parselines13 = preg_split("/\n/", $toparse13);
			$parselines14 = preg_split("/\n/", $toparse14);
			$parselines15 = preg_split("/\n/", $toparse15);
			$parselines16 = preg_split("/\n/", $toparse16);
			$parselines17 = preg_split("/\n/", $toparse17);
			$parselines18 = preg_split("/\n/", $toparse18);
			$parselines19 = preg_split("/\n/", $toparse19);
			$parselines20 = preg_split("/\n/", $toparse20);
			
			// Pruefen auf falsche Daten (Erste Ranking-Nummer muss richtig sein)
			if (false) {
				$wrongdata = 1;
			}
			
			if ($wrongdata !=1){
			
				// Umkopieren der Second-Daten auf die First-Daten in der DB
				$list = $db->get_inaktive();
				for ($i = 0; $i<count($list); $i++) {
					$name = $list[$i][0];
					$punkte = $list[$i][2];
					// echo "<p>".$name." - ".$punkte;
					if ($name == "") {$name="DUMMYUSER";}
					$db->change_inaktive($name, $punkte);
				}

				// Daten auslesen und in DB schreiben
				for ($i = 1; $i<(count($parselines1)-1); $i++){
					$parselines1[$i] = str_replace(".", '', $parselines1[$i]);
					$temp1 = preg_split("/ /", $parselines1[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines2)-1); $i++){
					$parselines2[$i] = str_replace(".", '', $parselines2[$i]);
					$temp1 = preg_split("/ /", $parselines2[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines3)-1); $i++){
					$parselines3[$i] = str_replace(".", '', $parselines3[$i]);
					$temp1 = preg_split("/ /", $parselines3[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines4)-1); $i++){
					$parselines4[$i] = str_replace(".", '', $parselines4[$i]);
					$temp1 = preg_split("/ /", $parselines4[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines5)-1); $i++){
					$parselines5[$i] = str_replace(".", '', $parselines5[$i]);
					$temp1 = preg_split("/ /", $parselines5[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines6)-1); $i++){
					$parselines6[$i] = str_replace(".", '', $parselines6[$i]);
					$temp1 = preg_split("/ /", $parselines6[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines7)-1); $i++){
					$parselines7[$i] = str_replace(".", '', $parselines7[$i]);
					$temp1 = preg_split("/ /", $parselines7[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines8)-1); $i++){
					$parselines8[$i] = str_replace(".", '', $parselines8[$i]);
					$temp1 = preg_split("/ /", $parselines8[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines9)-1); $i++){
					$parselines9[$i] = str_replace(".", '', $parselines9[$i]);
					$temp1 = preg_split("/ /", $parselines9[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines10)-1); $i++){
					$parselines10[$i] = str_replace(".", '', $parselines10[$i]);
					$temp1 = preg_split("/ /", $parselines10[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines11)-1); $i++){
					$parselines11[$i] = str_replace(".", '', $parselines11[$i]);
					$temp1 = preg_split("/ /", $parselines11[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines12)-1); $i++){
					$parselines12[$i] = str_replace(".", '', $parselines12[$i]);
					$temp1 = preg_split("/ /", $parselines12[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines13)-1); $i++){
					$parselines13[$i] = str_replace(".", '', $parselines13[$i]);
					$temp1 = preg_split("/ /", $parselines13[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines14)-1); $i++){
					$parselines14[$i] = str_replace(".", '', $parselines14[$i]);
					$temp1 = preg_split("/ /", $parselines14[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines15)-1); $i++){
					$parselines15[$i] = str_replace(".", '', $parselines15[$i]);
					$temp1 = preg_split("/ /", $parselines15[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines16)-1); $i++){
					$parselines16[$i] = str_replace(".", '', $parselines16[$i]);
					$temp1 = preg_split("/ /", $parselines16[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines17)-1); $i++){
					$parselines17[$i] = str_replace(".", '', $parselines17[$i]);
					$temp1 = preg_split("/ /", $parselines17[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines18)-1); $i++){
					$parselines18[$i] = str_replace(".", '', $parselines18[$i]);
					$temp1 = preg_split("/ /", $parselines18[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines19)-1); $i++){
					$parselines19[$i] = str_replace(".", '', $parselines19[$i]);
					$temp1 = preg_split("/ /", $parselines19[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				for ($i = 1; $i<(count($parselines20)-1); $i++){
					$parselines20[$i] = str_replace(".", '', $parselines20[$i]);
					$temp1 = preg_split("/ /", $parselines20[$i]);
					$temp11 = $temp1[1];
					$temp12 = $temp1[count($temp1)-3];
					if ($temp11 == "") {$temp11="DUMMYUSER";}
					$db->add_inaktive($temp11, $temp12);
					
				}
				$changed = 1;
			}
		}
		else {$wrongfields = 1;}

		
		
		// Flags ans Template uebergeben und Template anzeigen
		$smarty->assign("changed",$changed);
		$smarty->assign("wrongdata",$wrongdata);
		$smarty->assign("wrongfields",$wrongfields);
		$smarty->display("inaktive.tpl");
	}
	
	// Wurde Skript nicht vom AM aufgerufen, verwerfen der Session
	else
	{
		echo "Session Destroy wird ausgeführt...";
		session_destroy();
		$smarty->display("error.tpl");
	}
?>