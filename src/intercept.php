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
	
	if(isset($_SESSION["user"]))
	{
		   $nick = $_SESSION["user"];
	   $uid = $db->user_get_id($nick);
	   
	   $smarty->display("intercept.tpl");    
	 }
	 else
	 {
	   $smarty->display("error.tpl");
	 }
?>