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
	if( isset($_SESSION["user"]) )
	{
			$uid = $db->user_get_id($_SESSION["user"]);
			$db->reinit();
	   	$smarty->display("punkte.tpl");
	}

	// nichts Session:	
	else
	{
		session_destroy();
		$smarty->display("error.tpl");
	}
?>