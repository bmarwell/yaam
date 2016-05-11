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
			
		// Nick des Users
		$nick = $db->user_get_name($_GET['uid']);
		
		// Dann mal los...
		$smarty->assign("user",$nick);
		$smarty->assign("forschung",$db->forschung($_GET['uid']));
		$smarty->display("forschung.tpl");
	}
	
	
	// Du schon wieder?? Hrmpf...
	else
	{
		session_destroy();
   	$smarty->display("error.tpl");
	}
?>