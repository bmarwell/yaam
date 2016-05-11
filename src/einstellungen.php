<?php
	error_reporting(E_ALL);
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
	
	if(isset($_SESSION["user"]) && !isset($db))
	{
		$db = new cl_extended_database;
	}
	
	$error = "";	
	
	// Erstmal nur anzeigen, danke!
	if( isset($_SESSION["user"]) && !isset($_POST["pw_alt"]) && !isset($_POST['urlaub']) && !isset($_GET['del']) ) 
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$smarty->assign("urlaub",$db->urlaub_read($uid));
		$smarty->display("einstellungen.tpl");		
	}	
	
	// Urlaubsantrag?
	elseif( isset($_SESSION["user"]) && isset($_POST['urlaub']) )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		if ($_POST['vdatum'] != '' && $_POST['bdatum'] != '')
		{		
			$grund = $_POST['grund'];			
			
			$vdatum = explode(".",$_POST['vdatum']);
			$bdatum = explode(".",$_POST['bdatum']);
			
			$vdatum2 = $vdatum[2]."-".$vdatum[1]."-".$vdatum[0];
			$bdatum2 = $bdatum[2]."-".$bdatum[1]."-".$bdatum[0];
			
			if ($db->get_v_grund() == 1 && $grund == '')
				$grund = $db->getrandgrund();
			elseif ($db->get_v_grund() == 0 && $grund == '')
				$grund = 'Ohne Angabe';
			 
			$db->urlaub_add($uid,$vdatum2,$bdatum2,$_POST['sitter'],$grund) or $db->getError();
			
			$smarty->assign("urlaub",$db->urlaub_read($uid));
			$smarty->display("einstellungen.tpl");
		}
		else
		{
			$smarty->assign("urlaub",$db->urlaub_read($uid));
			$smarty->display("einstellungen.tpl");
		}
	}
	
	// Zurück aus dem Urlaub?
	elseif( isset($_SESSION["user"]) && isset($_GET['del']) )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$db->urlaub_del($uid) or $db->getError();
		
		$smarty->assign("urlaub",$db->urlaub_read($uid));
		$smarty->display("einstellungen.tpl");
	}
	
	// Ein altes und zwei neue PW? Kommt sofort!
	elseif(isset($_SESSION["user"]) && isset($_POST["pw_alt"]) && isset($_POST["pw_neu1"]) && isset($_POST["pw_neu2"]))
   {
   	$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$md5pass = md5($_POST["pw_alt"]);
		$pass = $db->user_get_pass($uid);
	
		// altes PW falsch? Dann Fehler != NULL
		if($md5pass != $pass)
		{
			$error .= "Das alte Passwort ist falsch!<br>";
		}
		
		// auch, wenn pw_neu1 != pw_neu2 ...
		if($_POST["pw_neu1"] != $_POST["pw_neu2"])
		{
			$error .= "Die beiden neuen Passwörter stimmen nicht ueberein!<br>";
		}
		
		if($error != "")
		{
			$smarty->assign("error",$error);
			$smarty->display("einstellungen.tpl");
		}
		
		// alle eingaben korrekt? Dann los!
		else
		{
			$db->change_pw($uid, md5($_POST["pw_neu1"])) or $db->getError();
			
			// anzeigen
			$smarty->assign("urlaub",$db->urlaub_read($uid));
			$smarty->assign("pw_erfolg",1);
			$smarty->display("einstellungen.tpl");
		}
	// Ende PW ändern.
	}
	
	// Ohne Fahrschein?
	else
	{
		$smarty->display("error.tpl");
	}
?>