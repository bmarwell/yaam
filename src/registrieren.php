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

	// Hmm? 
	if( isset($_POST["submit"]) && $_POST["submit"] == 25 )
	{
		$error = "";
		
		// Name...
		if ( $_POST["user"] == '' )
		{
			$error .= "Bitte geben sie einen Login-Namen ein!<br>";
		}
		
		// user ...
		if ( $_POST["pass1"] == '' )
		{
			$error .= "Bitte geben sie ein Passwort ein!<br>";
		}
		if ( strlen($_POST["pass1"]) < 6 )
		{
			$error .= "Das Passwort muß mindestens aus 6 Zeichen bestehen!<br>";
		}
		if ( $_POST["pass1"] != $_POST["pass2"] )
		{
			$error .= "Die eingegebenen Passwörter stimmen nicht überein!<br>";
	   }
	   
	   if ( $_POST["email"] == '' )
	   {
			$error .= "Bitte geben sie eine Email-Adresse an<br>";
	   }   
	   elseif ( !strpos($_POST['email'], '@') || !strpos($_POST['email'], '.') )
	   {
	   	$error .= "Die eingegebene E-Mailadresse ist ung&uuml;ltig!<br>";
	   }
	   
		$db = new cl_extended_database;
		if( $db->user_get_id( $_POST['user'] ) != -1 )
		{
			$error .= "Der Name '".$_POST['user']."' ist bereits vergeben!<br>";
		}
		
		if( $db->user_get_id_mail($_POST['email']) != -1 )
		{
			$error .= "Die E-Mailadresse '".$_POST['email']."' wird bereits benutzt!<br>";
	   }
	    
	    
	   if($error != "")
	   {
	   	$smarty->assign("nick", $_POST["user"]);
	   	$smarty->assign("mail", $_POST["email"]);
	   	$smarty->assign("msg",$error);
			$smarty->display("registrieren.tpl");
	   }
	    
	   else
	   {
	   	$db->user_add($_POST['user'],$_POST['pass1'],$_POST["email"]) or $db->getError();;
			$smarty->assign("msg", '<br />Erfolgreich angemeldet!');
			$smarty->assign("CONFIG_version",$CONFIG["game"]["int_version"]);
			$smarty->assign("register",$db->getallow_register());
			$smarty->display("index.tpl");
		}
	}
	else
	{  
		$smarty->display("registrieren.tpl");
	}
?>