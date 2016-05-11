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
	
	function generate_pw($length = 8)
	{										 
		
		$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
                     'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
                     'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
                     'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
                     'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                     'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
                     'Y', 'Z','0', '1', '2', '3', '4', '5', '6', '7',
                     '8', '9','@');
      
      srand((double)microtime() * 10000000);               	
		$temp = array_rand($chars, count($chars));
		
		srand((double)microtime() * 10000000);
		$random_chars = array_rand($temp, $length);
		srand((double)microtime() * 10000000);
		$random_chars = array_rand($temp, $length);
		srand((double)microtime() * 10000000);
		$random_chars = array_rand($temp, $length);
		srand((double)microtime() * 10000000);
		$random_chars = array_rand($temp, $length);
		srand((double)microtime() * 10000000);
		$random_chars = array_rand($temp, $length);
		
		$password = '';
		
		foreach($random_chars as $pos)
			$password .= $chars[$pos];
			
		return $password;
	}
		
	
	
	if(isset($_POST['nick']) && isset($_POST['email']))
	{
		$error = "";
		if($_POST["nick"] == '')
		{
			$error .= "Bitte gebe einen Namen ein!<br>";
		}
		if($_POST["email"] == '')
		{
			$error .= "Bitte geben sie eine Email-Adresse an<br>";
		}
	    
	   $uid = $db->user_get_id($_POST['nick']);
		$email = $db->user_get_mail($uid);
	    
		if($_POST['email'] != $email)
		{
			$error .= "Die angegebene Mail-Adresse '".$_POST['email']."' passt nicht zum User '".$_POST['nick']."'!<br>";
		}
	    
		if($error != "")
		{
			$smarty->assign("msg",$error);
			$smarty->display("passwort.tpl");
		}
		
		// Erfolgreich - ab zum start
		else
		{
			$db->reinit();
			$newautopw = generate_pw(10);
			$db->change_pw($uid,md5($newautopw));
						
			require 'config/passwort.php';
			$smarty->assign("msg","Neues Passwort erfolgreich erstellt und verschickt!");
			$smarty->assign("nick",$_POST["nick"]);
			$smarty->assign("email",$_POST["email"]);
			$smarty->assign("register",$db->getallow_register());
			$smarty->display("index.tpl");
		}
	}
	
	else
	{  
		$smarty->display("passwort.tpl");
	}
?>