<?php
	error_reporting(E_ALL);
	require("config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	/*require("$PATH/config.php");*/
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);
	$smarty->assign("CONFIG_version",$CONFIG["game"]["int_version"]);
	
	// Templates geladen, nun startet eine session.	
	session_start();	
	$db = new cl_extended_database;

	// Name, aber kein PW:
	if(isset($_POST["name"]) && !isset($_POST['pw']))
	{
		$smarty->display("index.tpl");
	}
	
	// Name und PW da:
	if(isset($_POST["name"]) && isset($_POST['pw']))
	{
		// User gibts nicht?
		$id = $db->user_get_id($_POST["name"]);
		if($id == -1)
		{
			$smarty->assign("msg","Nicht-existenter Benutzer oder falsches Passwort!");
			$smarty->display("error.tpl");
			die();
		}
		// Passwort richtig?
		if($db->user_get_pass($id) != md5($_POST['pw']))
		{
			$smarty->assign("msg","Nicht-existenter Benutzer oder falsches Passwort!");
			$smarty->display("error.tpl");
			die();
		}
		
		$name = $db->user_get_name($id);
		$_SESSION["user"] = $name;
	}
	
	
	if(isset($_SESSION["user"]))
	{
		
		if(!isset($db))
		{
			$db = new cl_extended_database;
		}
		
		$id = $_SESSION["user"]; 
		
		if(!isset($_SESSION["user"]))
		{
			$_SESSION["user"] = $db->user_get_name($id);
			
		}
		
		$smarty->assign("u9",$db->get_u9());
		$smarty->display("frameset.tpl");
	}
	
	// nix session -> ab zum login
	else
	{
		$smarty->assign("register",$db->getallow_register());
		$smarty->display("index.tpl");
	}
?>