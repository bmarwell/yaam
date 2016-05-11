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
		
		$rechte = $db->rechte($uid);
		if ($rechte < 3)
		{
				$smarty->assign("msg",'Du Schelm... du bist kein Administrator!');
				$smarty->display("error.tpl");
				die();
		}
			
		// Nick des Users
		$nick = $db->user_get_name($_GET['uid']);
	
		$flotte = '';

		
		$koords = $db->sql_koords($_GET['uid']);
		$summe['Sonden'] = $summe['Cougar'] = $summe['Tjugar'] = $summe['LeV'] = $summe['Noah'] = $summe['LeX'] = 0;		
		
		if ($koords != NULL)
		{			
			for ($i = 0; $i < count($koords); $i++)
			{
				$flotte[$i] = $db->flotte($koords[$i]['kid']);
				
				$summe['Sonden'] += $flotte[$i]['Sonden'];
				$summe['Recycler'] += $flotte[$i]['Recycler'];
				$summe['Cougar'] += $flotte[$i]['Cougar'];
				$summe['Tjugar'] += $flotte[$i]['Tjugar'];
				$summe['LeV'] += $flotte[$i]['LeV'];
				$summe['Noah'] += $flotte[$i]['Noah'];
				$summe['LeX'] += $flotte[$i]['LeX'];
				
				$flotte[$i]['koord'] = $koords[$i]['koord'];
				$flotte[$i]['Sonden'] =  number_format($flotte[$i]['Sonden'], 0, ',', '.');
				$flotte[$i]['Recycler'] =  number_format($flotte[$i]['Recycler'], 0, ',', '.');
				$flotte[$i]['Cougar'] =  number_format($flotte[$i]['Cougar'], 0, ',', '.');
				$flotte[$i]['Tjugar'] = number_format($flotte[$i]['Tjugar'], 0, ',', '.');
				$flotte[$i]['LeV'] = number_format($flotte[$i]['LeV'], 0, ',', '.');
				$flotte[$i]['Noah'] = number_format($flotte[$i]['Noah'], 0, ',', '.');
				$flotte[$i]['LeX'] = number_format($flotte[$i]['LeX'], 0, ',', '.');
			}
		}	
	
		// Formatieren
		$summe['Sonden'] = number_format($summe['Sonden'], 0, ',', '.');
		$summe['Recycler'] = number_format($summe['Recycler'], 0, ',', '.');
		$summe['Cougar'] = number_format($summe['Cougar'], 0, ',', '.');
		$summe['Tjugar'] = number_format($summe['Tjugar'], 0, ',', '.');
		$summe['LeV'] = number_format($summe['LeV'], 0, ',', '.');
		$summe['Noah'] = number_format($summe['Noah'], 0, ',', '.');
		$summe['LeX'] = number_format($summe['LeX'], 0, ',', '.');	
	
		$smarty->assign("flotte",$flotte);
		$smarty->assign("summe",$summe);
		$smarty->assign("user",$nick);
		$smarty->display("flotte.tpl");
	}
	
	// Du schon wieder?? Hrmpf...
	else
	{
		session_destroy();
   	$smarty->display("error.tpl");
	}
?>