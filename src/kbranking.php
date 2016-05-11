<?php
	/***************************************************************
	*  Copyright notice
	*
	*  (c) 2008 Sebastian Meese aka JabbaTheHood
	*  All rights reserved
	*
	*  This script is free software; you can redistribute it and/or modify
	*  it under the terms of the GNU General Public License as published by
	*  the Free Software Foundation; either version 2 of the License, or#"] 
	*  (at your option) any later version.
	*
	*  The GNU General Public License can be found at
	*  http://www.gnu.org/copyleft/gpl.html.
	*
	*  This script is distributed in the hope that it will be useful,
	*  but WITHOUT ANY WARRANTY; without even the implied warranty of
	*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	*  GNU General Public License for more details.
	*
	*  This copyright notice MUST APPEAR in all copies of the script!
	***************************************************************/
	
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

	
	// Daten verarbeiten und Statusmeldung ueber Template ausgeben
	if( isset($_SESSION["user"]) )
	{
		include("bashranking.php");
		$uid = $db->user_get_id($_SESSION["user"]);

		$ckk = 0;
		$ressis = 0;

		$ckk=$db->kb_topckk();
		$ressis=$db->kb_topress();

		
		if ($ckk != NULL){
			// Flags ans Template uebergeben und Template anzeigen
			$smarty->assign("ckk",$ckk);
			$smarty->assign("ressis",$ressis);
			$smarty->assign("rechte",$db->rechte($uid));
			$smarty->assign("path",$CONFIG["internal"]["serverpath"]);
			$smarty->assign("result",$result);
			$smarty->assign("ckkges",$CKKges);
			$smarty->assign("att",$att);
			$smarty->display("kbranking.tpl");
		}
		
	}
	
	// Wurde Skript fehlerhaft aufgerufen, verwerfen der Session
	else
	{
		echo "Session Destroy wird ausgeführt...";
		session_destroy();
		$smarty->display("error.tpl");
	}
?>