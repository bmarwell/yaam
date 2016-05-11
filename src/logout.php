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
	$smarty->assign("CONFIG_version",$CONFIG["game"]["int_version"]);
	
	session_start();
	$db = new cl_extended_database;
	
	if ( isset($_SESSION["user"]) )
		$smarty->assign("msg",'Du hast dich erfolgreich ausgeloggt!');	
	
	$smarty->assign("sessionname",session_name());
	$_SESSION["id"] = -1;
	unset($_SESSION);
	session_destroy();
	
	$smarty->assign("register",$db->getallow_register());
	
	$smarty->display("index.tpl");
?>