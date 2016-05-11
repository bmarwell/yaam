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
	
	$menu = '<tr>
			<td width="25%" align="center" class="none"><a href="uebersicht.php?page=main" onmouseover="uebersicht.src=image15.src" onmouseout="uebersicht.src=image16.src">
<img border="0" src="./bilder/navi/_uebersicht2.png" name="uebersicht"></a></td>
			<td colspan="2" align="center" class="none"><a href="uebersicht.php?page=ausbau" onmouseover="ausbau.src=image9.src" onmouseout="ausbau.src=image10.src">
<img border="0" src="./bilder/navi/_ausbau2.png" name="ausbau"></a></td>		
			<td width="25%" align="center" class="none"><a href="uebersicht.php?page=flotte" onmouseover="flotte.src=image13.src" onmouseout="flotte.src=image14.src">
<img border="0" src="./bilder/navi/_flotten.png" name="flotte"></a></td>
			<td width="25%" align="center" class="none"><a href="uebersicht.php?page=ressourcen" onmouseover="ressourcen.src=image17.src" onmouseout="ressourcen.src=image18.src">
<img border="0" src="./bilder/navi/_ressourcen.png" name="ressourcen"></a></td>			
		</tr>';
	
	if( isset($_SESSION["user"]) && (!isset($_GET['page']) || $_GET['page'] == 'main'))
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		// kummulierte Flotte
		$flotte = $db->flotte_user($uid);
		$ckk = $flotte;
		
		$prod = 0; // CKK, die produziert werden
		$zeit = 0; // benoetigte Zeit
		
		
		$koords = $db->sql_koords($uid);
		if ($koords != NULL)
		{
			for ($i = 0; $i < count($koords); $i++){
				$ausbau[$i] = $db->ausbau($koords[$i]['kid']);
				$ausbau[$i]['koord'] = $koords[$i]['koord'];

				$sf = $ausbau[$i]['SF'];
				if ($sf > 1) {
					$zeitlev = 480000 * (floor(2 + pow(1+1,3) / 10) /2 ) * (1 / (floor(pow($sf,2) / 1.667 +2) *0.5 )); // Zeit fuer einen LEV
					$zeitlex = 2400000 * (floor(2 + pow(1+1,3) / 10) /2 ) * (1 / (floor(pow($sf,2) / 1.667 +2) *0.5 )); // Zeit fuer einen LEX
					$prodlev += (86400/$zeitlev); // LEVs pro Tag
					$prodlex += (86400/$zeitlex); // LEX pro Tag
				    
                }
			}
		}

        
        // Effektive CKK inkl. Forschung berechnen
        $temp3 = $db->forschung($uid);

        $feckk['Sonden']   = 1 * sqrt(( 1     * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 1     * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Recycler'] = 1 * sqrt(( 300   * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 100   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Tjugar']   = 1 * sqrt(( 2000  * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 900   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Cougar']   = 1 * sqrt(( 2250  * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 6500  * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['LeV']      = 1 * sqrt(( 15000 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 35000 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Noah']     = 1 * sqrt(( 1000  * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 24000 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['LeX']      = 1 * sqrt(( 92000 * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 50000 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
		$feckk['Schakal']  = 1 * sqrt(( 50    * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 100   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Rene']     = 1 * sqrt(( 200   * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 200   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Raid']     = 1 * sqrt(( 1500  * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 300   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Tarn']     = 1 * sqrt(( 1300  * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 150   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Kolo']     = 1 * sqrt(( 1     * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 1000  * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Klein']    = 1 * sqrt(( 1     * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 500   * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        $feckk['Gross']    = 1 * sqrt(( 15    * ( 1 + sqrt($temp3['Ionis'] * 100 ) / 100) * ( 1 + sqrt($temp3['Energ'] * 100 ) / 100) *( 1 + sqrt($temp3['Explo'] * 100 ) / 100) * 12000 * (1 +  sqrt($temp3['Panzer'] * 100 )/ 100) )/(2250*6500));
        
        
        // eckk anzeige Formatieren formatiert
        $eckk['Sonden'] =  number_format($feckk['Sonden'], 6, ',', '.');
		$eckk['Recycler'] =  number_format($feckk['Recycler'], 6, ',', '.');
		$eckk['Cougar'] =  number_format($feckk['Cougar'], 6, ',', '.');
		$eckk['Tjugar'] = number_format($feckk['Tjugar'], 6, ',', '.');
		$eckk['LeV'] = number_format($feckk['LeV'], 6, ',', '.');
		$eckk['Noah'] = number_format($feckk['Noah'], 6, ',', '.');
		$eckk['LeX'] = number_format($feckk['LeX'], 6, ',', '.');
        
		// flotte formatiert
		$fflotte['Sonden'] =  $flotte['Sonden'];
		$fflotte['Recycler'] =  $flotte['Recycler'];
		$fflotte['Cougar'] =  $flotte['Cougar'];
		$fflotte['Tjugar'] = $flotte['Tjugar'];
		$fflotte['LeV'] = $flotte['LeV'];
		$fflotte['Noah'] = $flotte['Noah'];
		$fflotte['LeX'] = $flotte['LeX'];
		$fflotte['Rest'] = $flotte['Schakal'] + $flotte['Rene'] + $flotte['Raid'] + $flotte['Tarn'] + $flotte['Kolo'] + $flotte['Klein'] + $flotte['Gross'];
		$fflotte['Summe'] = $flotte['Sonden'] + $flotte['Tjugar'] + $flotte['Cougar'] + $flotte['LeV'] + $flotte['Noah'] + $flotte['LeX'] + $flotte['Schakal'] + $flotte['Rene'] + $flotte['Raid'] + $flotte['Tarn'] + $flotte['Kolo'] + $flotte['Klein'] + $flotte['Gross'];		
		
		// ckk in zahlen
		$ckk['Sonden'] =  round(	$ckk['Sonden'] * 0.000262, 2);
		$ckk['Recycler'] = round(	$ckk['Recycler'] * 0.045291, 2);
		$ckk['Tjugar'] = round(	$ckk['Tjugar'] / 3, 2);
		$ckk['Cougar'] =  round(	$ckk['Cougar'] * 1.0, 2);
		$ckk['LeV'] = round(	$ckk['LeV'] * 6, 2);
		$ckk['Noah'] = round(	$ckk['Noah'] * 1.3, 2);
		$ckk['LeX'] = round(	$ckk['LeX'] * 17.7, 2);
		$ckk['Schakal'] =  round(	$ckk['Schakal'] * 0.018490, 2);
		$ckk['Rene'] = round(	$ckk['Rene'] * 0.052298, 2);
		$ckk['Raid'] = round(	$ckk['Raid'] * 0.055470, 2);
		$ckk['Tarn'] =  round(	$ckk['Tarn'] * 0.115470, 2);
		$ckk['Kolo'] = round(	$ckk['Kolo'] * 0.008269, 2);
		$ckk['Klein'] = round(	$ckk['Klein'] * 0.005847, 2);
		$ckk['Gross'] = round(	$ckk['Gross'] * 0.110940, 2);
		
		// ckk formatiert
		$fckk['Summe'] = number_format($ckk['Sonden'] + $ckk['Recycler'] + $ckk['Tjugar'] + $ckk['Cougar'] + $ckk['LeV'] + $ckk['Noah'] + $ckk['LeX'] + $ckk['Schakal'] + $ckk['Rene'] + $ckk['Raid'] + $ckk['Tarn'] + $ckk['Kolo'] + $ckk['Klein'] + $ckk['Gross'], 2, ',', '.');
		$fckk['Sonden'] =  number_format($ckk['Sonden'], 2, ',', '.');
		$fckk['Recycler'] =  number_format($ckk['Recycler'], 2, ',', '.');
		$fckk['Cougar'] =  number_format($ckk['Cougar'], 2, ',', '.');
		$fckk['Tjugar'] = number_format($ckk['Tjugar'], 2, ',', '.');
		$fckk['LeV'] = number_format($ckk['LeV'], 2, ',', '.');
		$fckk['Noah'] = number_format($ckk['Noah'], 2, ',', '.');
		$fckk['LeX'] = number_format($ckk['LeX'], 2, ',', '.');
		$fckk['Rest'] = number_format($ckk['Schakal'] + $ckk['Rene'] + $ckk['Raid'] + $ckk['Tarn'] + $ckk['Kolo'] + $ckk['Klein'] + $ckk['Gross'], 2, ',', '.');
		
  		// eckk in zahlen
		$eeeckk['Sonden'] =  round($fflotte['Sonden'] * $feckk['Sonden'], 2);
		$eeeckk['Recycler'] = round($fflotte['Recycler'] * $feckk['Recycler'], 2);
		$eeeckk['Tjugar'] = round($fflotte['Tjugar'] * $feckk['Tjugar'], 2);
		$eeeckk['Cougar'] =  round($fflotte['Cougar'] * $feckk['Cougar'], 2);
		$eeeckk['LeV'] = round($fflotte['LeV'] * $feckk['LeV'], 2);
		$eeeckk['Noah'] = round($fflotte['Noah'] * $feckk['Noah'], 2);
		$eeeckk['LeX'] = round($fflotte['LeX'] * $feckk['LeX'], 2);
		$eeeckk['Rest'] = ($flotte['Schakal'] * $feckk['Schakal'] + $flotte['Rene'] * $feckk['Rene'] + $flotte['Raid'] * $feckk['Raid'] + $flotte['Tarn'] * $feckk['Tarn'] + $flotte['Kolo'] * $feckk['Kolo'] + $flotte['Klein'] * $feckk['Klein'] + $flotte['Gross'] * $feckk['Gross']);
        $sumeckk = $eeeckk['Sonden']+$eeeckk['Recycler']+$eeeckk['Tjugar']+$eeeckk['Cougar']+$eeeckk['LeV']+$eeeckk['Noah']+$eeeckk['LeX']+$eeeckk['Rest'];
		
		// eckk formatiert
		$eeckk['Sonden'] =  number_format($eeeckk['Sonden'], 2, ',', '.');
		$eeckk['Recycler'] =  number_format($eeeckk['Recycler'], 2, ',', '.');
		$eeckk['Cougar'] =  number_format($eeeckk['Cougar'], 2, ',', '.');
		$eeckk['Tjugar'] = number_format($eeeckk['Tjugar'], 2, ',', '.');
		$eeckk['LeV'] = number_format($eeeckk['LeV'], 2, ',', '.');
		$eeckk['Noah'] = number_format($eeeckk['Noah'], 2, ',', '.');
		$eeckk['LeX'] = number_format($eeeckk['LeX'], 2, ',', '.');
		$eeckk['Rest'] = number_format($eeeckk['Rest'], 2, ',', '.');
		$sumeckk = number_format($sumeckk, 2, ',', '.');
		
		// Nick des Users
		$nick = $db->user_get_name($uid);
		
		// Dann mal los...
		$smarty->assign("prodlev",$prodlev);
        $smarty->assign("prodlex",$prodlex);
		$smarty->assign("menu",$menu);
		$smarty->assign("user",$nick);
		$smarty->assign("fflotte",$fflotte);
		$smarty->assign("fckk",$fckk);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("ckk",$ckk);
		$smarty->assign("eckk",$eckk);
		$smarty->assign("eeckk",$eeckk);
		$smarty->assign("sumeckk",$sumeckk);
		$smarty->assign("forschung",$db->forschung($uid));
		$smarty->display("uebersicht.tpl");
	}
	
	elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'ausbau' )
	{
		$db->reinit();
		$ausbau = '';		
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$schnitt['KZ'] = 0;
		$schnitt['FZ'] = $schnitt['FeMine'] = $schnitt['LutRaff'] = $schnitt['Bohr'] = $schnitt['Chem'] = $schnitt['ErwChem'] = $schnitt['FeSpeicher'] = $schnitt['LutSpeicher'] = $schnitt['WasSpeicher'] = $schnitt['H2Speicher'] =  $schnitt['SF'] = $schnitt['OV'] = $schnitt['Schild'] = $schnitt['Fusi'] = 0;
				
		$koords = $db->sql_koords($uid);
		
		if ($koords != NULL)
		{			
				
			for ($i = 0; $i < count($koords); $i++)
			{
				$ausbau[$i] = $db->ausbau($koords[$i]['kid']);
				$ausbau[$i]['koord'] = $koords[$i]['koord'];
				
				// Schnittwerte
				$schnitt['KZ'] += $ausbau[$i]['KZ'];
				$schnitt['FZ'] += $ausbau[$i]['FZ'];
				$schnitt['FeMine'] += $ausbau[$i]['FeMine'];
				$schnitt['LutRaff'] += $ausbau[$i]['LutRaff'];
				$schnitt['Bohr'] += $ausbau[$i]['Bohr'];
				$schnitt['Chem'] += $ausbau[$i]['Chem'];
				$schnitt['ErwChem'] += $ausbau[$i]['ErwChem'];
				$schnitt['FeSpeicher'] += $ausbau[$i]['FeSpeicher'];
				$schnitt['LutSpeicher'] += $ausbau[$i]['LutSpeicher'];
				$schnitt['WasSpeicher'] += $ausbau[$i]['WasSpeicher'];
				$schnitt['H2Speicher'] += $ausbau[$i]['H2Speicher'];
				$schnitt['SF'] += $ausbau[$i]['SF'];
				$schnitt['OV'] += $ausbau[$i]['OV'];
				$schnitt['Schild'] += $ausbau[$i]['Schild'];
				$schnitt['Fusi'] += $ausbau[$i]['Fusi'];
				
			}
			
			// Schnittwerte
				$schnitt['KZ'] = round($schnitt['KZ'] / count($koords),2);
				$schnitt['FZ'] = round($schnitt['FZ'] / count($koords),2);
				$schnitt['FeMine'] = round($schnitt['FeMine'] / count($koords),2);
				$schnitt['LutRaff'] = round($schnitt['LutRaff'] / count($koords),2);
				$schnitt['Bohr'] = round($schnitt['Bohr'] / count($koords),2);
				$schnitt['Chem'] = round($schnitt['Chem'] / count($koords),2);
				$schnitt['ErwChem'] = round($schnitt['ErwChem'] / count($koords),2);
				$schnitt['FeSpeicher'] = round($schnitt['FeSpeicher'] / count($koords),2);
				$schnitt['LutSpeicher'] = round($schnitt['LutSpeicher'] / count($koords),2);
				$schnitt['WasSpeicher'] = round($schnitt['WasSpeicher'] / count($koords),2);
				$schnitt['H2Speicher'] = round($schnitt['H2Speicher'] / count($koords),2);
				$schnitt['SF'] = round($schnitt['SF'] / count($koords),2);
				$schnitt['OV'] = round($schnitt['OV'] / count($koords),2);
				$schnitt['Schild'] = round($schnitt['Schild'] / count($koords),2);
				$schnitt['Fusi'] = round($schnitt['Fusi'] / count($koords),2); 
				
		}
		
		$smarty->assign("menu",$menu);
		$smarty->assign("ausbau",$ausbau);
		$smarty->assign("schnitt",$schnitt);
		$smarty->display("uebersicht_ausbau.tpl");
	}
	
elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'flotte' )
	{
		$db->reinit();
		$flotte = '';
		$uid = $db->user_get_id($_SESSION["user"]);

		$koords = $db->sql_koords($uid);
		$summe['Rest'] = $summe['Cougar'] = $summe['Tjugar'] = $summe['LeV'] = $summe['Noah'] = $summe['LeX'] = 0;

		if ($koords != NULL)
		{
			for ($i = 0; $i < count($koords); $i++)
			{
				$flotte[$i] = $db->flotte($koords[$i]['kid']);
				$temp = $db->forschung ($uid);


				$summe['Rest'] += $flotte[$i]['Sonden'] + $flotte[$i]['Recycler']+ $flotte[$i]['Schakal'] + $flotte[$i]['Rene'] + $flotte[$i]['Raid'] + $flotte[$i]['Tarn'] + $flotte[$i]['Kolo'] + $flotte[$i]['Klein'] + $flotte[$i]['Gross'];
				$summe['Cougar'] += $flotte[$i]['Cougar'];
				$summe['Tjugar'] += $flotte[$i]['Tjugar'];
				$summe['LeV'] += $flotte[$i]['LeV'];
				$summe['Noah'] += $flotte[$i]['Noah'];
				$summe['LeX'] += $flotte[$i]['LeX'];

				$flotte[$i]['ckk'] = $flotte[$i]['Sonden'] * 0.000262;
			    $flotte[$i]['ckk'] += $flotte[$i]['Recycler'] * 0.045291;
			    $flotte[$i]['ckk'] += $flotte[$i]['Tjugar'] / 3.0;
			    $flotte[$i]['ckk'] += $flotte[$i]['Cougar'] * 1.0;
			    $flotte[$i]['ckk'] += $flotte[$i]['LeV'] * 6.0;
			    $flotte[$i]['ckk'] += $flotte[$i]['Noah'] * 1.3;
			    $flotte[$i]['ckk'] += $flotte[$i]['LeX'] * 17.7;
				$flotte[$i]['ckk'] += $flotte[$i]['Schakal'] * 0.018490;
		      	$flotte[$i]['ckk'] += $flotte[$i]['Rene'] * 0.052298;
		      	$flotte[$i]['ckk'] += $flotte[$i]['Raid'] * 0.055470;
		        $flotte[$i]['ckk'] += $flotte[$i]['Tarn'] * 0.115470;
    			$flotte[$i]['ckk'] += $flotte[$i]['Kolo'] * 0.008269;
    			$flotte[$i]['ckk'] += $flotte[$i]['Klein'] * 0.005847;
    			$flotte[$i]['ckk'] += $flotte[$i]['Gross'] * 0.110940;

				$flotte[$i]['eckk']= $flotte[$i]['Sonden']  *sqrt(( 1 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100)  * 1 *       (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Recycler']  *sqrt(( 300 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 100 * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Tjugar']  *sqrt(( 2000 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100)  * 900 * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Cougar']  * sqrt(( 2250 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 6500 *(1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['LeV']  *sqrt(( 15000 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100)  * 35000 * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Noah']  *sqrt(( 1000 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 24000 *   (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['LeX']  *sqrt(( 92000 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 50000 *   (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
				$flotte[$i]['eckk']+= $flotte[$i]['Schakal']  *sqrt(( 50 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100)  * 100 *       (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Rene']  *sqrt(( 200 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 200 * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Raid']  *sqrt(( 1500 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100)  * 300 * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Tarn']  * sqrt(( 1300 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 150 *(1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Kolo']  *sqrt(( 1 * ( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100)  * 1000 * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Klein']  *sqrt(( 1 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 500 *   (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));
                $flotte[$i]['eckk']+= $flotte[$i]['Gross']  *sqrt(( 15 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) *( 1 + sqrt($temp['Explo'] * 100 ) / 100) * 12000 *   (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )/(2250*6500));


				$flotte[$i]['fckk']= sqrt((($flotte[$i]['Sonden'] * 1 + $flotte[$i]['Recycler'] * 300 + $flotte[$i]['Tjugar'] * 2000 + $flotte[$i]['Cougar'] * 2250 + $flotte[$i]['LeV'] * 15000 + $flotte[$i]['Noah'] * 1000 + $flotte[$i]['LeX'] * 92000 + $flotte[$i]['Schakal'] * 50 + $flotte[$i]['Rene'] * 200 + $flotte[$i]['Raid'] * 150 + $flotte[$i]['Tarn'] * 1300 + $flotte[$i]['Kolo'] * 1 + $flotte[$i]['Klein'] * 1 + $flotte[$i]['Gross'] * 15) *($flotte[$i]['Sonden'] * 1 + $flotte[$i]['Recycler'] * 100 + $flotte[$i]['Tjugar'] * 900 + $flotte[$i]['Cougar'] * 6500 + $flotte[$i]['LeV'] * 35000 + $flotte[$i]['Noah'] * 24000 + $flotte[$i]['LeX'] * 50000 + $flotte[$i]['Schakal'] * 100 + $flotte[$i]['Rene'] * 200 + $flotte[$i]['Raid'] * 300 + $flotte[$i]['Tarn'] * 150 + $flotte[$i]['Kolo'] * 1000 + $flotte[$i]['Klein'] * 500 + $flotte[$i]['Gross'] * 12000))/(2250*6500));

				$flotte[$i]['feckk']= sqrt(((($flotte[$i]['Sonden'] * 1 + $flotte[$i]['Recycler'] * 300 + $flotte[$i]['Tjugar'] * 2000 + $flotte[$i]['Cougar'] * 2250 + $flotte[$i]['LeV'] * 15000 + $flotte[$i]['Noah'] * 1000 + $flotte[$i]['LeX'] * 92000 + $flotte[$i]['Schakal'] * 50 + $flotte[$i]['Rene'] * 200 + $flotte[$i]['Raid'] * 150 + $flotte[$i]['Tarn'] * 1300 + $flotte[$i]['Kolo'] * 1 + $flotte[$i]['Klein'] * 1 + $flotte[$i]['Gross'] * 15) * ( 1 *( 1 + sqrt($temp['Ionis'] * 100 ) / 100) *( 1 + sqrt($temp['Energ'] * 100 ) / 100) * ( 1 + sqrt($temp['Explo'] * 100 ) / 100)) *(($flotte[$i]['Sonden'] * 1 + $flotte[$i]['Recycler'] * 100 + $flotte[$i]['Tjugar'] * 900 + $flotte[$i]['Cougar'] * 6500 + $flotte[$i]['LeV'] * 35000 + $flotte[$i]['Noah'] * 24000 + $flotte[$i]['LeX'] * 50000 + $flotte[$i]['Schakal'] * 100 + $flotte[$i]['Rene'] * 200 + $flotte[$i]['Raid'] * 300 + $flotte[$i]['Tarn'] * 150 + $flotte[$i]['Kolo'] * 1000 + $flotte[$i]['Klein'] * 500 + $flotte[$i]['Gross'] * 12000) * (1 +  sqrt($temp['Panzer'] * 100 )/ 100) )))/(2250*6500));

				$flotte[$i]['koord'] = $koords[$i]['koord'];
				$flotte[$i]['Rest'] =  number_format($flotte[$i]['Sonden'] + $flotte[$i]['Recycler']+ $flotte[$i]['Schakal'] + $flotte[$i]['Rene'] + $flotte[$i]['Raid'] + $flotte[$i]['Tarn'] + $flotte[$i]['Kolo'] + $flotte[$i]['Klein'] + $flotte[$i]['Gross'], 0, ',', '.');
				$flotte[$i]['Cougar'] =  number_format($flotte[$i]['Cougar'], 0, ',', '.');
				$flotte[$i]['Tjugar'] = number_format($flotte[$i]['Tjugar'], 0, ',', '.');
				$flotte[$i]['LeV'] = number_format($flotte[$i]['LeV'], 0, ',', '.');
				$flotte[$i]['Noah'] = number_format($flotte[$i]['Noah'], 0, ',', '.');
				$flotte[$i]['LeX'] = number_format($flotte[$i]['LeX'], 0, ',', '.');
				$flotte[$i]['ckk'] = number_format($flotte[$i]['ckk'], 1, ',', '.');
				$flotte[$i]['eckk'] = number_format($flotte[$i]['eckk'], 1, ',', '.');
				$flotte[$i]['fckk'] = number_format($flotte[$i]['fckk'], 1, ',', '.');
				$flotte[$i]['feckk'] = number_format($flotte[$i]['feckk'], 1, ',', '.');
			}
		}

		// Formatieren
		$summe['Rest'] = number_format($summe['Rest'], 0, ',', '.');
		$summe['Recycler'] = number_format($summe['Recycler'], 0, ',', '.');
		$summe['Cougar'] = number_format($summe['Cougar'], 0, ',', '.');
		$summe['Tjugar'] = number_format($summe['Tjugar'], 0, ',', '.');
		$summe['LeV'] = number_format($summe['LeV'], 0, ',', '.');
		$summe['Noah'] = number_format($summe['Noah'], 0, ',', '.');
		$summe['LeX'] = number_format($summe['LeX'], 0, ',', '.');

		$smarty->assign("menu",$menu);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("summe",$summe);
		$smarty->display("uebersicht_flotte.tpl");
	}

	elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'flotte1' )
	{
		$db->reinit();
		$flotte = '';
		$uid = $db->user_get_id($_SESSION["user"]);

		$koords = $db->sql_koords($uid);
		$summe['Rest'] = $summe['Cougar'] = $summe['Tjugar'] = $summe['LeV'] = $summe['Noah'] = $summe['LeX'] = 0;

		if ($koords != NULL)
		{
			for ($i = 0; $i < count($koords); $i++)
			{
				$flotte[$i] = $db->flotte($koords[$i]['kid']);

                $summe['Schakal'] += $flotte[$i]['Schakal'];
				$summe['Recycler'] += $flotte[$i]['Recycler'];
				$summe['Sonden'] += $flotte[$i]['Sonden'];
				$summe['Rene'] += $flotte[$i]['Rene'];
				$summe['Raid'] += $flotte[$i]['Raid'];
				$summe['Tarn'] += $flotte[$i]['Tarn'];
				$summe['Kolo'] += $flotte[$i]['Kolo'];
				$summe['Klein'] += $flotte[$i]['Klein'];
				$summe['Gross'] += $flotte[$i]['Gross'];

				$flotte[$i]['koord'] = $koords[$i]['koord'];
				$flotte[$i]['Schakal'] =  number_format($flotte[$i]['Schakal'], 0, ',', '.');
				$flotte[$i]['Recycler'] =  number_format($flotte[$i]['Recycler'], 0, ',', '.');
				$flotte[$i]['Sonden'] = number_format($flotte[$i]['Sonden'], 0, ',', '.');
				$flotte[$i]['Rene'] = number_format($flotte[$i]['Rene'], 0, ',', '.');
				$flotte[$i]['Raid'] = number_format($flotte[$i]['Raid'], 0, ',', '.');
				$flotte[$i]['Tarn'] = number_format($flotte[$i]['Tarn'], 0, ',', '.');
				$flotte[$i]['Kolo'] = number_format($flotte[$i]['Kolo'], 0, ',', '.');
				$flotte[$i]['Klein'] = number_format($flotte[$i]['Klein'], 0, ',', '.');
				$flotte[$i]['Gross'] = number_format($flotte[$i]['Gross'], 0, ',', '.');
			}
		}

		// Formatieren
		$summe['Schakal'] = number_format($summe['Schakal'], 0, ',', '.');
		$summe['Recycler'] = number_format($summe['Recycler'], 0, ',', '.');
		$summe['Sonden'] = number_format($summe['Sonden'], 0, ',', '.');
		$summe['Rene'] = number_format($summe['Rene'], 0, ',', '.');
		$summe['Raid'] = number_format($summe['Raid'], 0, ',', '.');
		$summe['Tarn'] = number_format($summe['Tarn'], 0, ',', '.');
        $summe['Kolo'] = number_format($summe['Kolo'], 0, ',', '.');
		$summe['Klein'] = number_format($summe['Klein'], 0, ',', '.');
		$summe['Gross'] = number_format($summe['Gross'], 0, ',', '.');

		$smarty->assign("menu",$menu);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("summe",$summe);
		$smarty->display("uebersicht_flotte1.tpl");
	}
	elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'ressourcen' )	
	{
		$db->reinit();
		$ressourcen = '';
		$summe = array("Eisen" => 0, "Lutinum" => 0, "Wasser" => 0, "Wasserstoff" => 0);		
		$uid = $db->user_get_id($_SESSION["user"]);
				
		$koords = $db->sql_koords($uid);
		
		if ($koords != NULL)
		{			
			for ($i = 0; $i < count($koords); $i++)
			{
				$ausbau[$i] = $db->ausbau($koords[$i]['kid']);
				$ressourcen[$i]['koord'] = $koords[$i]['koord'];				
				
				// Eisen
				$fe = $ausbau[$i]['FeMine'];
				if ( $fe == 0 )
					$ressourcen[$i]['Eisen'] = 0;
				else							
					$ressourcen[$i]['Eisen'] = 4*(($fe+1)*$fe+2*floor($fe/5)*($fe%5)+5*floor($fe/5)*(floor($fe/5)-1)+2);
				// Lutinum
				$lut = $ausbau[$i]['LutRaff'];
				if ($lut == 0)
					$ressourcen[$i]['Lutinum'] = 0;
				else
					$ressourcen[$i]['Lutinum'] = 2.5*(($lut+1)*$lut+2*floor($lut/5)*($lut%5)+5*floor($lut/5)*(floor($lut/5)-1)+2);
				// Wasser
				$bohr = $ausbau[$i]['Bohr'];
				if ($bohr == 0)
					$ressourcen[$i]['Wasser'] = 0;
				else
					$ressourcen[$i]['Wasser'] = 5*(($bohr+1)*$bohr+2*floor($bohr/5)*($bohr%5)+5*floor($bohr/5)*(floor($bohr/5)-1)+2);
				// Wasserstoff
				$chem = $ausbau[$i]['Chem'];
				$echem = $ausbau[$i]['ErwChem'];
				if ($chem == 0)
				{
					$ressourcen[$i]['Wasserstoff'] = 0;
					$ressourcen[$i]['Wasserstoff24'] = 0;
				}
				else
				{
					$chemp = (($chem+1)*$chem+2*floor($chem/5)*($chem%5)+5*floor($chem/5)*(floor($chem/5)-1)+2);
					if ($echem != 0)					
						$echemp = 12.5*(($echem+1)*$echem+2*floor($echem/5)*($echem%5)+5*floor($echem/5)*(floor($echem/5)-1)+2);
					else
						$echemp = 0;
					$chemv = 5 * (($chem+1)*$chem+2*floor($chem/5)*($chem%5)+5*floor($chem/5)*(floor($chem/5)-1)+2);
					
					if ($echemp != 0)
						$echemv = 25*(($echem+1)*$echem+2*floor($echem/5)*($echem%5)+5*floor($echem/5)*(floor($echem/5)-1)+2);
					else
						$echemv = 0;
					
					$ressourcen[$i]['Wasser'] = $ressourcen[$i]['Wasser'] - $chemv - $echemv;
					$summe['Wasserstoff'] += $chemp + $echemp;
					$ressourcen[$i]['Wasserstoff24'] = number_format(24*($chemp + $echemp), 0, ',', '.');
					$ressourcen[$i]['Wasserstoff'] = number_format($chemp + $echemp, 0, ',', '.');
				}

				$summe['Eisen'] += $ressourcen[$i]['Eisen'] + 10;				
				$summe['Lutinum'] += $ressourcen[$i]['Lutinum'] + 10;
				$summe['Wasser'] += $ressourcen[$i]['Wasser'] + 10;								
				
				// Ressis pro Tag
				$ressourcen[$i]['Eisen24'] =  number_format(24*($ressourcen[$i]['Eisen'] + 10), 0, ',', '.');
				$ressourcen[$i]['Lutinum24'] = number_format(24*($ressourcen[$i]['Lutinum'] + 10), 0, ',', '.');
				$ressourcen[$i]['Wasser24'] = number_format(24*($ressourcen[$i]['Wasser'] + 10), 0, ',', '.');
				
				// Ressis pro Stunde
				$ressourcen[$i]['Eisen'] =  number_format($ressourcen[$i]['Eisen'] + 10, 0, ',', '.');
				$ressourcen[$i]['Lutinum'] = number_format($ressourcen[$i]['Lutinum'] + 10, 0, ',', '.');
				$ressourcen[$i]['Wasser'] = number_format($ressourcen[$i]['Wasser'] + 10, 0, ',', '.');
				

				// alles zusammen?				
								
			}
				
				$summe['Eisen'] = number_format(24*$summe['Eisen'], 0, ',', '.');				
				$summe['Lutinum'] = number_format(24*$summe['Lutinum'], 0, ',', '.');
				$summe['Wasser'] = number_format(24*$summe['Wasser'], 0, ',', '.');
				$summe['Wasserstoff'] = number_format(24*$summe['Wasserstoff'], 0, ',', '.');			
			
		}
		
		$smarty->assign("menu",$menu);
		$smarty->assign("ressourcen",$ressourcen);
		$smarty->assign("summe",$summe);
		$smarty->display("uebersicht_ressourcen.tpl");	
	}
	
	// Du schon wieder?? Hrmpf...
	else
	{
		session_destroy();
   	$smarty->display("error.tpl");
	}
?>