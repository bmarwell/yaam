<?php
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
	
	
	// Seite jungfräulich aufrufen
	if(isset($_SESSION["user"]) && !isset($_POST['add']) && !isset($_POST['change']) && !isset($_POST['delete']) )
	{
			$uid = $db->user_get_id($_SESSION["user"]);
			$db->reinit();
			$smarty->assign("user_koords",$db->sql_koords($uid));
	   	$smarty->display("planeten_view.tpl");
	}
	
	// Wenn er eine Koordinate hinzufügen will...	
	elseif( isset($_SESSION["user"]) && isset($_POST['add']) )
	{
			$uid = $db->user_get_id($_SESSION["user"]);
			$koordinate = $_POST['koordinate'];
			$db->reinit();
			
			$koordinate = preg_split("/:/",$koordinate);

			// Koordinatenformat auf 000:000:00 umwandeln
			if ($koordinate[0]<10) $koordinate[0] = '00'.($koordinate[0]+0);
			elseif ($koordinate[0]<100) $koordinate[0] = '0'.($koordinate[0]+0);


			if ($koordinate[1]<10) $koordinate[1] = '00'.($koordinate[1]+0);
			elseif ($koordinate[1]<100) $koordinate[1] = '0'.($koordinate[1]+0);

			if ($koordinate[2]<10) $koordinate[2] = '0'.($koordinate[2]+0);

			$koordinate = $koordinate[0].":".$koordinate[1].":".$koordinate[2];
			
			// Prüfen, ob die Koordinate schon existiert:
			$exist = $db->find_koords($koordinate);
			
			// Ja? Dann zeige den $dieb! ;)
			if( $koordinate == $exist && $exist != -1)
			{
				$db->reinit();				
				$dieb = $db->finde_besitzer($koordinate);
				$smarty->assign("msg",'Die Koordinate '.$koordinate.' wurde bereits von '.$dieb.' eingetragen!');
				$smarty->display("planeten_fehler.tpl");
			}
			
			// koordinate gültig?
			elseif ( strpos($koordinate,':') == false || strpos($koordinate,':') == strrpos($koordinate,':'))
			{
				$smarty->assign("msg",$koordinate.' ist keine gültige Koordinate!');
				$smarty->display("planeten_fehler.tpl");
			}
			// Nein? Guuuuut....
			else
			{
				$db->reinit();
			 	$result = $db->add_koord($koordinate, $uid);
			 	$db->reinit();
				$smarty->assign("user_koords",$db->sql_koords($uid));
				$smarty->assign("user_koords2",$db->sql_koords($uid));
	   		$smarty->display("planeten_view.tpl");
			}
	} 
	
	// wenn er was ändert... uff... wird komplex.
	elseif( isset($_SESSION["user"]) && isset($_POST['change']) )
	{
		$uid = $db->user_get_id($_SESSION["user"]);
		// todo...
	}
	
	// Er will was löschen? So sei es...
	elseif( isset($_SESSION["user"]) && isset($_POST['delete']) )
	{
		$koordinate = $_POST['koordinate'];
		$uid = $db->user_get_id($_SESSION["user"]);
		$db->reinit();
		$result = $db->del_koord($koordinate);
		$db->reinit();
		$smarty->assign("user_koords",$db->sql_koords($uid));
		$smarty->assign("geloescht",1);
	   $smarty->display("planeten_view.tpl");
	}
	
	// nichts Session:	
	else
	{
		session_destroy();
		$smarty->display("error.tpl");
	}
?>