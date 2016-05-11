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

	session_start();
	$db = new cl_extended_database;	
	// lass uns mal gucken...
	if(isset($_SESSION["user"]) && !isset($_POST['text']) && !isset($_GET['del']) )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		$smarty->assign("news",$db->news_from_admin());
		$smarty->assign("rechte",$db->rechte($uid));
	 	$smarty->display("news.tpl");
	}
	
	// hier kommt was neues!
	elseif(isset($_SESSION["user"]) && isset($_POST['text']) )
	{
		$text = $_POST['text'];
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		// überschüssige zeilen entfernen,
		// HTML-Umlaute in UTF-8 Wandeln,
		// HTML-Tags entfernen,
		// Sonderzeichen in UTF-8 umwandeln
		// newlines in breaks wandeln
		$text = chop($text);
		$text = preg_replace("/&uuml;/", 'ü', $text);
		$text = preg_replace("/&Uuml;/", 'Ü', $text);
		$text = preg_replace("/&Auml;/", 'A', $text);
		$text = preg_replace("/&auml;/", 'a', $text);
		$text = preg_replace("/&ouml;/", 'o', $text);
		$text = preg_replace("/&Ouml;/", 'O', $text);
		$text = preg_replace("/&szlig;/", 'ß', $text);
		$text = strip_tags($text);
		$text = htmlentities($text, ENT_QUOTES, 'utf-8');
		$text = nl2br($text);	
		
		$db->news_add($text, $uid);
		
		$smarty->assign("news",$db->news_from_admin());
		$smarty->assign("rechte",$db->rechte($uid));
	 	$smarty->display("news.tpl");
	}
	
	// Weg mit folgender Meldung...
	elseif ( isset($_SESSION['user']) && isset($_GET['del']) )
	{
		$nid = $_GET['del'];
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		if ($db->rechte($uid) == 4)  		
		{
			$db->news_delete($nid);
			
			$smarty->assign("news",$db->news_from_admin());
			$smarty->assign("rechte",$db->rechte($uid));
		 	$smarty->display("news.tpl");
	 	}
	}
	
	else
	{
		session_destroy();
	    $smarty->display("error.tpl");
	}
?>