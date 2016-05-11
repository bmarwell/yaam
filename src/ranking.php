<?php
	require("config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/config.php");
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	$db = new cl_extended_database;
	session_start();
	
	if( isset($_SESSION["user"]))
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		$users = $db->get_allusers(); // nur die IDs
		
		foreach ($users as $u)
		{
			$urlaub[$u] = $db->urlaub_read($u);
			$urlaub[$u]['nick'] = $db->user_get_name($u);
		}
				
		$flotte = array(); // erstes element = UserID, zweites = summeCKK
		
		// Variablen leeren
			$temp = 0;
			$ckk = 0.0;
			$allyfleet = 0;	
			$allyfleet1 = 0;
			
		// kummulierte Flotte
		foreach ($users as $us)
		{			
			// Fleet des users ins array laden
			$temp = $db->flotte_user($us);
			
			// Wert der Flotte ermitteln
			$ckk = $temp['Sonden'] * 0.000261;
			$ckk += $temp['Recycler'] * 0.045291;
			$ckk += $temp['Tjugar'] / 3;
			$ckk += $temp['Cougar'] * 1.0;
			$ckk += $temp['LeV'] * 6;
			$ckk += $temp['Noah'] * 1.3;
			$ckk += $temp['LeX'] * 17.7;
			$ckk += $temp['Schakal'] * 0.018490;
			$ckk += $temp['Rene'] * 0.052298;
			$ckk += $temp['Raid'] * 0.055470;
			$ckk += $temp['Tarn'] * 0.115470;
			$ckk += $temp['Kolo'] * 0.008269;
			$ckk += $temp['Klein'] * 0.005847;
			$ckk += $temp['Gross'] * 0.110940;
			
			$flotte[$us]['ckk'] = $ckk;
			$flotte[$us]['uid'] = $us;
			$flotte[$us]['Nick'] = $db->user_get_name($us);
			$flotte[$us]['LastChg'] = $db->get_LastChg($us);
			$flotte[$us]['Tag'] = $db->get_tag($us);
			$flotte[$us]['Forschung'] = 0;
			$flotte[$us]['Main'] = $db->get_main($us);
			
		
			if ($flotte[$us]['Main'] == 1) {$allyfleet += $ckk; $mainuser++;} 
            else if ($flotte[$us]['Main'] == 2) {$allyfleet1 += $ckk; $winguser++;} 
			
			
            if ($flotte[$us]['Main'] == 1) $mainschnitt = $allyfleet / ($mainuser);
		    else if ($flotte[$us]['Main'] == 2) $wingschnitt = $allyfleet1 / ($winguser);
			
			$prod = 0; // CKK, die produziert werden
			$zeit = 0; // benoetigte Zeit
			
			$koords = $db->sql_koords($us);
			if ($koords != NULL)
			{                                                                                             
				for ($i = 0; $i < count($koords); $i++){
					$ausbau[$i] = $db->ausbau($koords[$i]['kid']);
					$ausbau[$i]['koord'] = $koords[$i]['koord'];
					
					$sf = $ausbau[$i]['SF'];
					if ($sf > 1) {
						$zeit = 480000 * (floor(2 + pow(1+1,3) / 10) /2 ) * (1 / (floor(pow($sf,2) / 1.667 +2) *0.5 )); // Zeit fuer einen Coug
						$prod += (86400/$zeit); // LEVs pro Tag
					}
				}
			}
			$flotte[$us]['ProdLev'] = $prod;			
			
			/*				
			3 Verbrennungsantrieb 
			1 Ionenantrieb
			3 Raumkrümmungsantrieb
			3 Raumfaltungsantrieb
			5 Ionisation
			5 Energiebündelung
			5 Explosivgeschosse
			1 Spionagetechnik
			5 Schiffspanzerung
			2 Erhöhte Ladekapazität
			3 Recyclingtechnik
			*/

			// Angepaßte Forschungspunkte-Berechnung
			foreach ($db->forschung($us) as $f)

				$temp1 = $db->forschung ($us);
				$flotte[$us]['Forschung'] += $f
				= $temp1['VbA'] * 2.5
                + $temp1['IoA'] * 25
			    + $temp1['RkA'] * 75
			    + $temp1['RfA'] * 300
			    + $temp1['Ionis'] * 39.25
			    + $temp1['Energ'] * 78.725
                + $temp1['Explo'] * 10
			    + $temp1['Spio'] * 1.25
			    + $temp1['Panzer'] * 40
			    + $temp1['LadeKapa'] * 25.5
			    + $temp1['Recycler'] * 72.5;
		}
		
		// Effektive CKK inkl. Forschung berechnen (Recycler noch deaktiviert)
		foreach ($users as $us)
		{   
            $temp2 = $db->flotte_user($us);
            $temp3 = $db->forschung ($us);
            $flotte[$us]['eckk'] += $eckk
            = $temp2['Sonden']  *sqrt(( 1 *( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100)  * 1 *       (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Recycler']  *sqrt(( 300 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 100 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Tjugar']  *sqrt(( 2000 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100)  * 900 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Cougar']  * sqrt(( 2250 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 6500 *(1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['LeV']  *sqrt(( 15000 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100)  * 35000 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Noah']  *sqrt(( 1000 *( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 24000 *   (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['LeX']  *sqrt(( 92000 *( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 50000 *   (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Schakal']  *sqrt(( 50 *( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100)  * 100 *       (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Rene']  *sqrt(( 200 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 200 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Raid']  *sqrt(( 1500 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100)  * 300 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Tarn']  * sqrt(( 1300 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 150 *(1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Kolo']  *sqrt(( 1 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100)  * 1000 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Klein']  *sqrt(( 1 *( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 500 *   (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500))
            + $temp2['Gross']  *sqrt(( 15 *( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 12000 *   (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
            $flotte[$us]['eckk'] = number_format($flotte[$us]['eckk'], 0, ',', '.');  
        }
		
		// Effektive CKK inkl. Forschung berechnen (Recycler noch deaktiviert)
		foreach ($users as $us)
		{
            $temp4 = $db->flotte_user($us);
            $temp5 = $db->forschung ($us);
            $temp8 = $db->flotte_user($us);
            $flotte[$us]['fckk'] += $fckk
            = sqrt((($temp4['Sonden'] * 1 + $temp4['Recycler'] * 300 + $temp4['Tjugar'] * 2000 + $temp4['Cougar'] * 2250 + $temp4['LeV'] * 15000 + $temp4['Noah'] * 1000 + $temp4['LeX'] * 92000 + $temp4['Schakal'] * 50 + $temp4['Rene'] * 200 + $temp4['Raid'] * 150 + $temp4['Tarn'] * 1300 + $temp4['Kolo'] * 1 + $temp4['Klein'] * 1 + $temp4['Gross'] * 15 ) *($temp8['Sonden'] * 1 + $temp8['Recycler'] * 100 + $temp8['Tjugar'] * 900 + $temp8['Cougar'] * 6500 + $temp8['LeV'] * 35000 + $temp8['Noah'] * 24000 + $temp8['LeX'] * 50000 + $temp8['Schakal'] * 100 + $temp8['Rene'] * 200 + $temp8['Raid'] * 300 + $temp8['Tarn'] * 150 + $temp4['Kolo'] * 1000 + $temp4['Klein'] * 500 + $temp4['Gross'] * 12000 ))/(2250*6500));
            $flotte[$us]['fckk'] = number_format($flotte[$us]['fckk'], 0, ',', '.');
        }
		
		// Effektive CKK inkl. Forschung berechnen (Recycler noch deaktiviert)
		foreach ($users as $us)
		{
            $temp6 = $db->flotte_user($us);
            $temp7 = $db->forschung ($us);
            $flotte[$us]['feckk'] += $feckk
            = sqrt(((($temp6['Sonden'] * 1 + $temp6['Recycler'] * 300 + $temp6['Tjugar'] * 2000 + $temp6['Cougar'] * 2250 + $temp6['LeV'] * 15000 + $temp6['Noah'] * 1000 + $temp6['LeX'] * 92000 + $temp6['Schakal'] * 50 + $temp6['Rene'] * 200 + $temp6['Raid'] * 150 + $temp6['Tarn'] * 1300 + $temp6['Kolo'] * 1 + $temp6['Klein'] * 1 + $temp6['Gross'] * 15 ) * ( 1 *( 1 + sqrt($temp7['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp7['Energ'] * 100 ) / 100) * ( 1 + sqrt($temp7['Explo'] * 100 ) / 100)) *(($temp6['Sonden'] * 1 + $temp6['Recycler'] * 100 + $temp6['Tjugar'] * 900 + $temp6['Cougar'] * 6500 + $temp6['LeV'] * 35000 + $temp6['Noah'] * 24000 + $temp6['LeX'] * 50000 + $temp6['Schakal'] * 100 + $temp6['Rene'] * 200 + $temp6['Raid'] * 300 + $temp6['Tarn'] * 150 + $temp6['Kolo'] * 1000 + $temp6['Klein'] * 500 + $temp6['Gross'] * 12000 ) * (1 +  sqrt($temp7['Panzer'] * 100 )/ 100) )))/(2250*6500));
            $flotte[$us]['feckk'] = number_format($flotte[$us]['feckk'], 0, ',', '.');
        }
		
		// GesamtCKK Main und Wing berechnen
		foreach ($users as $us)
		{
			if ($allyfleet == 0)
				$flotte[$us]['ProGes'] = 0;
			else {
				if ($flotte[$us]['Main'] == 1)	$flotte[$us]['ProGes'] = $flotte[$us]['ckk'] / $allyfleet * 100;
				if ($flotte[$us]['Main'] == 2)	$flotte[$us]['ProGes'] = $flotte[$us]['ckk'] / $allyfleet1 * 100;
			}
		}
		
		// Ab hier formatieren
		array_multisort($flotte, $users);
		
		$max = end($flotte);
		$max = $max['ckk'];
		
		
		for ($i = 0; $i < count($users); $i++)
		{
			if ( $max == 0)
				$flotte[$i]['ProErst'] = 0;
			else
				$flotte[$i]['ProErst'] = number_format(($flotte[$i]['ckk'] / $max * 100), 2, ',', '.');
			$flotte[$i]['ckk'] = number_format($flotte[$i]['ckk'], 0, ',', '.');
			$flotte[$i]['ProGes'] = number_format($flotte[$i]['ProGes'], 2, ',', '.');
			
			$datum = explode('-', $flotte[$i]['LastChg']);
			$tag = explode(' ', $datum[2]);

			$flotte[$i]['Unixzeit'] = mktime(0, 0, 0,  $datum[1], $tag[0], $datum[0]);
			
		}
		$allyfleet = number_format($allyfleet, 0, ',', '.');
		$allyfleet1 = number_format($allyfleet1, 0, ',', '.');
		$mainschnitt = number_format($mainschnitt, 0, ',', '.');
		$wingschnitt = number_format($wingschnitt, 0, ',', '.');
		date('Y-m-d H:i:s');
		
		// noch richtig drehen...
		$flotte = array_reverse($flotte);

		// Und ab dafür!
		$smarty->assign("u9",$db->get_u9());
		$smarty->assign("rechte",$db->rechte($uid));
		$smarty->assign("proa",$db->get_proa());
		$smarty->assign("pro1",$db->get_pro1());
		$smarty->assign("ckk",$db->get_ckk());
		$smarty->assign("eckk",$db->get_eckk());
		$smarty->assign("fckk",$db->get_fckk());
		$smarty->assign("feckk",$db->get_feckk());
		$smarty->assign("forsch",$db->get_forsch());
		$smarty->assign("update",$db->get_update());
		$smarty->assign("lev",$db->get_lev());
		$smarty->assign("aus",$db->get_aus());
		$smarty->assign("proa1",$db->get_proa1());
		$smarty->assign("pro11",$db->get_pro11());
		$smarty->assign("ckk1",$db->get_ckk1());
		$smarty->assign("eckk1",$db->get_eckk1());
		$smarty->assign("fckk1",$db->get_fckk1());
		$smarty->assign("feckk1",$db->get_feckk1());
		$smarty->assign("forsch1",$db->get_forsch1());
		$smarty->assign("update1",$db->get_update1());
		$smarty->assign("lev1",$db->get_lev1());
		$smarty->assign("aus1",$db->get_aus1());
        $smarty->assign("urlaub",$urlaub);
		$smarty->assign("urlaub1",$urlaub);
		$smarty->assign("user",$flotte);
		$smarty->assign("user1",$flotte);
		$smarty->assign("summeckk",$allyfleet);
		$smarty->assign("summeckk1",$allyfleet1);
		$smarty->assign("schnittckk",$mainschnitt);
		$smarty->assign("schnittckk1",$wingschnitt);
		$smarty->display("ranking.tpl");		
	}
	
	// Du schon wieder?? Hrmpf...
	else
	{
		session_destroy();
		$smarty->display("error.tpl");
	}
?>