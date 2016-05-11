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
	
	$menu = '<tr>
			<td width="25%" align="center" class="none"><a href="info.php?page=info" onmouseover="info.src=image15.src" onmouseout="info.src=image16.src">
<img border="0" src="./bilder/navi/_info2.png" name="info"></a></td>

			<td colspan="2" align="center" class="none"><a href="info.php?page=history" onmouseover="history.src=image9.src" onmouseout="history.src=image10.src">
<img border="0" src="./bilder/navi/_history.png" name="history"></a></td>
					
		</tr>';
	
	if( isset($_SESSION["user"]) && (!isset($_GET['page']) || $_GET['page'] == 'info'))
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$smarty->assign("CONFIG_version",$CONFIG["game"]["int_version"]);
		$smarty->assign("menu",$menu);
		$smarty->display("info.tpl");
	}
	
	elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'history' )
	{
		$db->reinit();		
		$uid = $db->user_get_id($_SESSION["user"]);
		
		$smarty->assign("menu",$menu);
		$smarty->display("info_history.tpl");
	}
	
	
	
	/*elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'flotte' )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);	
	
		$smarty->assign("menu",$menu);
		$smarty->assign("flotte",$flotte);
		$smarty->assign("summe",$summe);
		$smarty->display("uebersicht_flotte.tpl");
	}
	
	elseif( isset($_SESSION["user"]) &&  $_GET['page'] == 'ressourcen' )	
	{
		$db->reinit();		
		$uid = $db->user_get_id($_SESSION["user"]);
				
		$smarty->assign("menu",$menu);
		$smarty->assign("ressourcen",$ressourcen);
		$smarty->assign("summe",$summe);
		$smarty->display("uebersicht_ressourcen.tpl");	
	}*/
	
	// Du schon wieder?? Hrmpf...
	else
	{
		session_destroy();
   	$smarty->display("error.tpl");
	}
?>