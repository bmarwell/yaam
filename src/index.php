<?php
	// Let the user know wether sth will go wrong...
	error_reporting(E_ALL);
	
	// Load our settings...
	require("config/config.php");
	
	// See, where the config path is
	$PATH=$CONFIG['internal']['sqlconf'];  
	
	// Functions needed to communicate with DB
	require("$PATH/mysql.inc.php");
	
	// Load Session and Template management 
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	@session_start();
	session_destroy();	
	
	// Start a session and use templates
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	$smarty->assign("CONFIG_version",$CONFIG["game"]["int_version"]);
	
	// Darf man sich zur Zeit registrieren?
	$db = new cl_extended_database;
	$smarty->assign("register",$db->getallow_register());
	$smarty->display("index.tpl");
?>
