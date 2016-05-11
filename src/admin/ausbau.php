<?php
	require("../config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("../$PATH/config.php");
	require("../$PATH/mysql.inc.php");
	define('SMARTY_DIR', '../'.$CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	$db = new cl_extended_database;
	session_start();

	
	if( isset($_SESSION["user"]) && isset($_GET['uid']) )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$aus = $db->get_aus();
		$rechte = $db->rechte($uid);
		if ($rechte < $aus)
		{
				$smarty->assign("msg",'Du Schelm... du bist kein Administrator!');
				$smarty->display("error.tpl");
				die();
		}
	
		$koords = $db->sql_koords($_GET['uid']);

		$schnitt['KZ'] = 0;
		$schnitt['FZ'] = $schnitt['FeMine'] = $schnitt['LutRaff'] = $schnitt['Bohr'] = $schnitt['Chem'] = $schnitt['ErwChem'] = $schnitt['FeSpeicher'] = $schnitt['LutSpeicher'] = $schnitt['WasSpeicher'] = $schnitt['H2Speicher'] =  $schnitt['SF'] = $schnitt['OV'] = $schnitt['Schild'] = $schnitt['Fusi'] = 0;
		

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
		
		// Nick des Users
		$nick = $db->user_get_name($_GET['uid']);
		
		$smarty->assign("ausbau",$ausbau);
		$smarty->assign("user",$nick);
		$smarty->assign("schnitt",$schnitt);
		$smarty->display("ausbau.tpl");
	}
	
	
	// Du schon wieder?? Hrmpf...
	else
	{
		session_destroy();
   	$smarty->display("error.tpl");
	}
?>