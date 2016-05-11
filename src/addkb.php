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
	if(!isset($_POST['update']) && !isset($_POST['update2']) ) // isset($_SESSION["user"]) &&
	{
		$db->reinit();
		$smarty->display("addkb.tpl");
  	}

	// Daten verarbeiten und Statusmeldung ueber Template ausgeben
	else if (isset($_POST['kb_raw']))
	{
		$dateadd = $datedone =  $toparse = "";
		$wrongdata = $wrongplani = $changed = $kbid = $addedlink = 0;
		$toparse = $_POST['kb_raw'];
		if(!isset($_SESSION["user"]))
			$user = "";
		else
			$user=$_SESSION["user"];

		// Daten je nach Browser angleichen
		$toparse = preg_replace ("/\t/", " ", $toparse);
		for ($i = 0; $i<5; $i++){
			$toparse = preg_replace ("/  /", " ", $toparse);
		}

		// Wenn es ein korrekter Kb war, dann parsen
		if ($wrongdata == 0){

			// Kb in drei Bereiche KB-Kopf, Angreifer, Verteidiger zerlegen
			$toparse = preg_split("/Schiffe/", $toparse);

			$parselines1 = preg_split("/\n/", $toparse[0]); // Bereich KB-Kopf
			for ($i=0;$i<count($parselines1);$i++) {$parselines1[$i]=trim($parselines1[$i]);}

			$parselines2 = preg_split("/\n/", $toparse[1]); // Bereich Angreifer
			for ($i=0;$i<count($parselines2);$i++) {$parselines2[$i]=trim($parselines2[$i]);}
			$toparse = preg_split("/Davon stammen vom/", $toparse[2]);
			$toparse = preg_split("/Recyclerausbeute/", $toparse[0]);
			$toparse = preg_split("/Spionagebericht/", $toparse[0]);
			$parselines3 = preg_split("/\n/", $toparse[0]); // Bereich Verteidiger und erbeutete Ressis
			for ($i=0;$i<count($parselines3);$i++) {$parselines3[$i]=trim($parselines3[$i]);}
			// $parselines4 = preg_split("/\n/", $toparse[1]); // Bereich recycelte Ressis - Fehlermeldung!

			$Ueberschrift = $parselines1[0];

			$dateadd = date("D, d.m.Y - H:i:s");

			$datedone = asearch($parselines1, 'Datum', 0);
			$datedone = str_replace("Datum ", "", $datedone);

			$plania = asearch($parselines2, 'des Angreifers (', 0);
			$plania = str_replace("des Angreifers (", "", trim($plania));
			$plania = str_replace(")", "", trim($plania));

			$planid = asearch($parselines3, '/T*', 0);
			$planid = str_replace("/TÃ¼rme des Verteidigers (", "", trim($planid));
			$planid = str_replace("/Türme des Verteidigers (", "", $planid);
			$planid = str_replace(")", "", trim($planid));

			$schakala = asearch($parselines2, 'Schakal*', 0);
			if ($schakala == "") {$schakala[1]=0; $schakala[2]=0;}
			else $schakala = preg_split("/ /", trim($schakala));

			$schakala = str_replace(".", "", $schakala);

			$schakald = asearch($parselines3, 'schakal*', 1);
			if ($schakald == "") {$schakald[1]=0; $schakald[2]=0;}
			else $schakald = preg_split("/ /", trim($schakald));

			$schakald = str_replace(".", "", $schakald);

			$recyca = asearch($parselines2, 'Recyc*', 0);
			if ($recyca == "") {$recyca[1]=0; $recyca[2]=0;}
			else $recyca = preg_split("/ /", trim($recyca));

			$recyca = str_replace(".", "", $recyca);

			$recycd = asearch($parselines3, 'Recyc*', 1);
			if ($recycd == "") {$recycd[1]=0; $recycd[2]=0;}
			else $recycd = preg_split("/ /", trim($recycd));

			$recycd = str_replace(".", "", $recycd);

			$spioa = asearch($parselines2, 'Spionage*', 0);
			if ($spioa == "") {$spioa[1]=0; $spioa[2]=0;}
			else $spioa = preg_split("/ /", trim($spioa));

			$spioa = str_replace(".", "", $spioa);

			$spiod = asearch($parselines3, 'Spionage*', 1);
			if ($spiod == "") {$spiod[1]=0; $spiod[2]=0;}
			else $spiod = preg_split("/ /", trim($spiod));

			$spiod = str_replace(".", "", $spiod);

			$renea = asearch($parselines2, 'Renegade*', 0);
			if ($renea == "") {$renea[1]=0; $renea[2]=0;}
			else $renea = preg_split("/ /", trim($renea));

			$renea = str_replace(".", "", $renea);

			$rened = asearch($parselines3, 'Renegade*', 1);
			if ($rened == "") {$rened[1]=0; $rened[2]=0;}
			else $rened = preg_split("/ /", trim($rened));

			$rened = str_replace(".", "", $rened);

			$raida = asearch($parselines2, 'Raider*', 0);
			if ($raida == "") {$raida[1]=0; $raida[2]=0;}
			else $raida = preg_split("/ /", trim($raida));

			$raida = str_replace(".", "", $raida);

			$raidd = asearch($parselines3, 'Raider*', 1);
			if ($raidd == "") {$raidd[1]=0; $raidd[2]=0;}
			else $raidd = preg_split("/ /", trim($raidd));

			$raidd = str_replace(".", "", $raidd);

			$tarna = asearch($parselines2, 'Falcon*', 0);
			if ($tarna == "") {$tarna[1]=0; $tarna[2]=0;}
			else $tarna = preg_split("/ /", trim($tarna));
			
			$tarna = str_replace(".", "", $tarna);

			$tarnd = asearch($parselines3, 'Falcon*', 1);
			if ($tarnd == "") {$tarnd[1]=0; $tarnd[2]=0;}
			else $tarnd = preg_split("/ /", trim($tarnd));
			
			$tarnd = str_replace(".", "", $tarnd);

			$koloa = asearch($parselines2, 'Kolonisationsschiff*', 0);
			if ($koloa == "") {$koloa[1]=0; $koloa[2]=0;}
			else $koloa = preg_split("/ /", trim($koloa));
			
			$koloa = str_replace(".", "", $koloa);

			$kolod = asearch($parselines3, 'Kolonisationsschiff*', 1);
			if ($kolod == "") {$kolod[1]=0; $kolod[2]=0;}
			else $kolod = preg_split("/ /", trim($kolod));
			
			$kolod = str_replace(".", "", $kolod);

			$tjuga = asearch($parselines2, 'Tjuger*', 0);
			if ($tjuga == "") {$tjuga[1]=0; $tjuga[2]=0;}
			else $tjuga = preg_split("/ /", trim($tjuga));
			
			$tjuga = str_replace(".", "", $tjuga);

			$tjugd = asearch($parselines3, 'Tjuger*', 1);
			if ($tjugd == "") {$tjugd[1]=0; $tjugd[2]=0;}
			else $tjugd = preg_split("/ /", trim($tjugd));
			
			$tjugd = str_replace(".", "", $tjugd);

			$couga = asearch($parselines2, 'Cougar*', 0);
			if ($couga == "") {$couga[1]=0; $couga[2]=0;}
			else $couga = preg_split("/ /", trim($couga));
			
			$couga = str_replace(".", "", $couga);

			$cougd = asearch($parselines3, 'Cougar*', 1);
			if ($cougd == "") {$cougd[1]=0; $cougd[2]=0;}
			else $cougd = preg_split("/ /", trim($cougd));
			
			$cougd = str_replace(".", "", $cougd);

			$leva = asearch($parselines2, 'Longeagle V*', 0);
			if ($leva == "") {$leva[2]=0; $leva[3]=0;}
			else $leva = preg_split("/ /", trim($leva));
			
			$leva = str_replace(".", "", $leva);

			$levd = asearch($parselines3, 'Longeagle V*', 1);
			if ($levd == "") {$levd[2]=0; $levd[3]=0;}
			else $levd = preg_split("/ /", trim($levd));
			
			$levd = str_replace(".", "", $levd);

			$kleina = asearch($parselines2, 'Kleines Handelsschiff*', 0);
			if ($kleina == "") {$kleina[2]=0; $kleina[3]=0;}
			else $kleina = preg_split("/ /", trim($kleina));
			
			$kleina = str_replace(".", "", $kleina);

			$kleind = asearch($parselines3, 'Kleines Handelsschiff*', 1);
			if ($kleind == "") {$kleind[2]=0; $kleind[3]=0;}
			else $kleind = preg_split("/ /", trim($kleind));
			
			$kleind = str_replace(".", "", $kleind);

			$grossa = asearch($parselines2, 'Großes Handelsschiff*', 0);
			if ($grossa == "") {$grossa[2]=0; $grossa[3]=0;}
			else $grossa = preg_split("/ /", trim($grossa));
			
			$grossa = str_replace(".", "", $grossa);

			$grossd = asearch($parselines3, 'Großes Handelsschiff*', 1);
			if ($grossd == "") {$grossd[2]=0; $grossd[3]=0;}
			else $grossd = preg_split("/ /", trim($grossd));
			
			$grossd = str_replace(".", "", $grossd);

			$noaha = asearch($parselines2, 'Noah*', 0);
			if ($noaha == "") {$noaha[1]=0; $noaha[2]=0;}
			else $noaha = preg_split("/ /", trim($noaha));
			
			$noaha = str_replace(".", "", $noaha);

			$noahd = asearch($parselines3, 'Noah*', 1);
			if ($noahd == "") {$noahd[1]=0; $noahd[2]=0;}
			else $noahd = preg_split("/ /", trim($noahd));
			
			$noahd = str_replace(".", "", $noahd);

			$lexa = asearch($parselines2, 'Longeagle X*', 0);
			if ($lexa == "") {$lexa[2]=0; $lexa[3]=0;}
			else $lexa = preg_split("/ /", trim($lexa));
			
			$lexa = str_replace(".", "", $lexa);

			$lexd = asearch($parselines3, 'Longeagle X*', 1);
			if ($lexd == "") {$lexd[2]=0; $lexd[3]=0;}
			else $lexd = preg_split("/ /", trim($lexd));
			
			$lexd = str_replace(".", "", $lexd);

			$leichtd = asearch($parselines3, 'Leichter Laserturm*', 0);
			if ($leichtd == "") {$leichtd[2]=0; $leichtd[3]=0;}
			else $leichtd = preg_split("/ /", trim($leichtd));
			
			$leichtd = str_replace(".", "", $leichtd);

			$laserd = asearch($parselines3, 'Laserturm*', 1);
			if ($laserd == "") {$laserd[1]=0; $laserd[2]=0;}
			else $laserd = preg_split("/ /", trim($laserd));
			
			$laserd = str_replace(".", "", $laserd);

			$empd = asearch($parselines3, 'EMP-Werfer*', 0);
			if ($empd == "") {$empd[1]=0; $empd[2]=0;}
			else $empd = preg_split("/ /", trim($empd));
			
			$empd = str_replace(".", "", $empd);

			$plasmad = asearch($parselines3, 'Plasmaturm*', 0);
			if ($plasmad == "") {$plasmad[1]=0; $plasmad[2]=0;}
			else $plasmad = preg_split("/ /", trim($plasmad));
			
			$plasmad = str_replace(".", "", $plasmad);

			$raksd = asearch($parselines3, 'Raks*', 0);
			if ($raksd == "") {$raksd[1]=0; $raksd[2]=0;}
			else $raksd = preg_split("/ /", trim($raksd));
			
			$raksd = str_replace(".", "", $raksd);

			$eisen = asearch($parselines3, 'Eisen*', 0);
			if ($eisen == "") {$eisen[1]=0;}
			else $eisen = preg_split("/ /", trim($eisen));			
			
			$eisen = str_replace(".", "", $eisen);

			$lutinum = asearch($parselines3, 'Lutinum*', 0);
			if ($lutinum == "") {$lutinum[1]=0;}
			else $lutinum = preg_split("/ /", trim($lutinum));
			
			$lutinum = str_replace(".", "", $lutinum);

			$wasser = asearch($parselines3, 'Trinkwasser*', 0);
			if ($wasser == "") {$wasser[1]=0;}
			else $wasser = preg_split("/ /", trim($wasser));
			
			$wasser = str_replace(".", "", $wasser);

			$wasserstoff = asearch($parselines3, 'Wasserstoff*', 0);
			if ($wasserstoff == "") {$wasserstoff[1]=0;}
			else $wasserstoff = preg_split("/ /", trim($wasserstoff));
			
			$wasserstoff = str_replace(".", "", $wasserstoff);

			// Planis umformatieren ins Format 000:000:00
			$plania = preg_split("/:/",trim($plania));
			if ($plania[0]<10) $plania[0] = '00'.($plania[0]+0);
			elseif ($plania[0]<100) $plania[0] = '0'.($plania[0]+0);
			if ($plania[1]<10) $plania[1] = '00'.($plania[1]+0);
			elseif ($plania[1]<100) $plania[1] = '0'.($plania[1]+0);
			if ($plania[2]<10) $plania[2] = '0'.($plania[2]+0);
			$plania = $plania[0].":".$plania[1].":".$plania[2];

			$planid = preg_split("/:/",trim($planid));
			if ($planid[0]<10) $planid[0] = '00'.($planid[0]+0);
			elseif ($planid[0]<100) $planid[0] = '0'.($planid[0]+0);
			if ($planid[1]<10) $planid[1] = '00'.($planid[1]+0);
			elseif ($planid[1]<100) $planid[1] = '0'.($planid[1]+0);
			if ($planid[2]<10) $planid[2] = '0'.($planid[2]+0);
			$planid = $planid[0].":".$planid[1].":".$planid[2];

			// Daten fuer Ressis berechnen
			$ressis = $eisen[1] + $lutinum[1] + $wasserstoff[1];

			// Pruefen ob Atter oder Deffer und wenn Spieler in DB, um Namen ergänzen
			$atter = $db->finde_besitzer($plania);
			$deffer = $db->finde_besitzer($planid);
			if ($atter <> -1){
				$ckk = $schakald[2]*0.018490 + $recycd[2]*0.045291 + $spiod[2]*0.000261 + $rened[2]*0.052298 + $raidd[2]*0.055470 + $tarnd[2]*0.115470 + $kolod[2]*0.008269 + $tjugd[2]*0.350823 + $cougd[2]*1 + $levd[3]*5.991447 + $kleind[3]*0.005847 + $grossd[3]*0.110940 + $noahd[2]*1.281025 + $lexd[3]*17.734991 + $leichtd[3]*0.059914 + $laserd[2]*0.218777 + $empd[2]*0.350823 + $plasmad[2]*0.258860 + $raksd[2]*1.578704;
				$ckk = round($ckk, 2);
				$planid = substr($planid,0,3).":xxx:xx";
				$plania = $plania." - ".$atter;
				$planid = $planid." - Gegner";
			}
			elseif ($deffer <> -1){
				$ckk = $schakala[2]*0.018490 + $recyca[2]*0.045291 + $spioa[2]*0.000261 + $renea[2]*0.052298 + $raida[2]*0.055470 + $tarna[2]*0.115470 + $koloa[2]*0.008269 + $tjuga[2]*0.350823 + $couga[2]*1 + $leva[3]*5.991447 + $kleina[3]*0.005847 + $grossa[3]*0.110940 + $noaha[2]*1.281025 + $lexa[3]*17.734991;
				$ckk = round($ckk, 2);
				$planid = $planid." - ".$deffer;
				$plania = $plania." - Gegner";
			}
			else ($ckk = 0);

			// Daten an DB uebergeben
			$kbid = $db->kb_add($user, $dateadd, $datedone, $plania, $schakala[1], $schakala[2], $recyca[1], $recyca[2], $spioa[1], $spioa[2], $renea[1], $renea[2], $raida[1], $raida[2], $tarna[1], $tarna[2], $koloa[1], $koloa[2], $tjuga[1], $tjuga[2], $couga[1], $couga[2], $leva[2], $leva[3], $kleina[2], $kleina[3], $grossa[2], $grossa[3], $noaha[1], $noaha[2], $lexa[2], $lexa[3], $planid, $schakald[1], $schakald[2], $recycd[1], $recycd[2], $spiod[1], $spiod[2], $rened[1], $rened[2], $raidd[1], $raidd[2], $tarnd[1], $tarnd[2], $kolod[1], $kolod[2], $tjugd[1], $tjugd[2], $cougd[1], $cougd[2], $levd[2], $levd[3], $kleind[2], $kleind[3], $grossd[2], $grossd[3], $noahd[1], $noahd[2], $lexd[2], $lexd[3], $leichtd[2], $leichtd[3], $laserd[1], $laserd[2], $empd[1], $empd[2], $plasmad[1], $plasmad[2], $raksd[1], $raksd[2], $eisen[1], $lutinum[1], $wasser[1], $wasserstoff[1], $ckk, $ressis);
			$changed = 1;
		}
		else {$changed = 0; $wrongdata=1;}

		// Flags ans Template uebergeben und Template anzeigen
		$smarty->assign("kbid",$kbid);
		$smarty->assign("changed",$changed);
		$smarty->assign("wrongdata",$wrongdata);
		$smarty->assign("path",$CONFIG["internal"]["serverpath"]);
		$smarty->display("addkb.tpl");

	}

	// Element in Array mit Wildcard suchen und extrahieren
	function asearch( $array, $searchString, $option ) {
		$onFront  = false;
		$onEnd    = false;

		// * on front
		if( preg_match( "/^\*/", $searchString ) ) {
			$searchString = preg_replace( "/^\*/", '', $searchString );
			$onFront      = true;
			$function     = 'return ( strrpos( strrev( $element ), "'.strrev( $searchString ).'" ) === 0 )?true:false;';
		}
		// * on end
		if( preg_match( "/\*$/", $searchString ) ) {
			$searchString = preg_replace( "/\*$/", '', $searchString );
			$onEnd        = true;
			$function     = 'return ( strpos( $element, "'.$searchString.'" ) === 0 )?true:false;';
		}
		if( !( $onFront xor $onEnd ) ) {
			$function = 'return ( strpos( $element, "'.$searchString.'" ) !== false )?true:false;';
		}
		$returnarray = array_filter( $array, create_function( '$element', $function ));
		return array_pop($returnarray);
	}
?>