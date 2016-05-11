<?php
	require("../config/config.php");
	session_start();
	$PATH='../'.$CONFIG['internal']['sqlconf'];
	require("$PATH/config.php");
	require("$PATH/mysql.inc.php");
	define('SMARTY_DIR', '../'.$CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');

	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);

	$db = new cl_extended_database;

	// nur anzeigen
	if( isset($_SESSION["user"]) && !isset($_POST['delete']) && !isset($_POST['change']) && !isset($_POST['settings']) )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		$rechte = $db->rechte($uid);

		if ($rechte < 4)
			{
				$smarty->assign("msg",'Du Schelm... du bist kein Administrator!');
				$smarty->display("error.tpl");
				die();
			}

		$users = $db->get_allusers(); // nur die IDs

		$flotte = array(); // erstes element = UserID, zweites = summeCKK




		// jetzt noch die Einstellungen lesen...
		$register = $db->getallow_register();
		$ugrund = $db->get_v_grund();

		// Und ab dafür!
		$smarty->assign("rechte",$db->rechte($uid));
		$smarty->assign("register",$register);
		$smarty->assign("u9",$db->get_u9());
		$smarty->assign("proa",$db->get_proa());
		$smarty->assign("pro1",$db->get_pro1());
		$smarty->assign("ckk",$db->get_ckk());
		$smarty->assign("eckk",$db->get_eckk());
		$smarty->assign("fckk",$db->get_fckk());
		$smarty->assign("feckk",$db->get_feckk());
		$smarty->assign("forsch",$db->get_forsch());
		$smarty->assign("update",$db->get_update());
		$smarty->assign("lev",$db->get_lev());
		$smarty->assign("aus",$db->get_aus());
		$smarty->assign("proa1",$db->get_proa1());
		$smarty->assign("pro11",$db->get_pro11());
		$smarty->assign("ckk1",$db->get_ckk1());
		$smarty->assign("eckk1",$db->get_eckk1());
		$smarty->assign("fckk1",$db->get_fckk1());
		$smarty->assign("feckk1",$db->get_feckk1());
		$smarty->assign("forsch1",$db->get_forsch1());
		$smarty->assign("update1",$db->get_update1());
		$smarty->assign("lev1",$db->get_lev1());
		$smarty->assign("aus1",$db->get_aus1());
		$smarty->assign("ugrund",$ugrund);
		$smarty->assign("user",$flotte);
		$smarty->assign("user2",$flotte);
		$smarty->assign("user3",$flotte);
		$smarty->assign("summeckk",$allyfleet);
		$smarty->display("setup.tpl");
	}


	elseif ( isset($_SESSION["user"]) && isset($_POST['settings']) )
	{
		$db->reinit();
		$uid = $db->user_get_id($_SESSION["user"]);
		$rechte = $db->rechte($uid);

		// bla

		if ($rechte < 4)
			{
				$smarty->assign("msg",'Du Schelm... du bist kein Administrator!');
				$smarty->display("error.tpl");
				die();
			}

		if (isset($_POST['register']))
			$register = $_POST['register'];
		else
			$register = 0;

		if (isset($_POST['ugruende']))
			$ugruende = $_POST['ugruende'];
		else
			$ugruende = 0;

		if (isset($_POST['u9']))
			$u9 = $_POST['u9'];
		else
			$u9 = 0;

		// setze ugruende und register
		$db->set_ugruende($ugruende);
		$db->set_register($register);
		$db->set_u9($u9);
		$db->set_proa($_POST['proa']);
		$db->set_pro1($_POST['pro1']);
		$db->set_ckk($_POST['ckk']);
		$db->set_eckk($_POST['eckk']);
		$db->set_fckk($_POST['fckk']);
		$db->set_feckk($_POST['feckk']);
		$db->set_forsch($_POST['forsch']);
		$db->set_update($_POST['update']);
		$db->set_lev($_POST['lev']);
		$db->set_aus($_POST['aus']);
		$db->set_proa1($_POST['proa1']);
		$db->set_pro11($_POST['pro11']);
		$db->set_ckk1($_POST['ckk1']);
		$db->set_eckk1($_POST['eckk1']);
		$db->set_fckk1($_POST['fckk1']);
		$db->set_feckk1($_POST['feckk1']);
		$db->set_forsch1($_POST['forsch1']);
		$db->set_update1($_POST['update1']);
		$db->set_lev1($_POST['lev1']);
		$db->set_aus1($_POST['aus1']);
		$users = $db->get_allusers(); // nur die IDs



		// jetzt noch die Einstellungen lesen...
		$register = $db->getallow_register();
		$ugrund = $db->get_v_grund();

		// Und ab dafür!
		$smarty->assign("rechte",$db->rechte($uid));
		$smarty->assign("register",$register);
		$smarty->assign("ugrund",$ugrund);
		$smarty->assign("u9",$db->get_u9());
		$smarty->assign("proa",$db->get_proa());
		$smarty->assign("pro1",$db->get_pro1());
		$smarty->assign("ckk",$db->get_ckk());
		$smarty->assign("eckk",$db->get_eckk());
		$smarty->assign("fckk",$db->get_fckk());
		$smarty->assign("feckk",$db->get_feckk());
		$smarty->assign("forsch",$db->get_forsch());
		$smarty->assign("update",$db->get_update());
		$smarty->assign("lev",$db->get_lev());
		$smarty->assign("aus",$db->get_aus());
		$smarty->assign("proa1",$db->get_proa1());
		$smarty->assign("pro11",$db->get_pro11());
		$smarty->assign("ckk1",$db->get_ckk1());
		$smarty->assign("eckk1",$db->get_eckk1());
		$smarty->assign("fckk1",$db->get_fckk1());
		$smarty->assign("feckk1",$db->get_feckk1());
		$smarty->assign("forsch1",$db->get_forsch1());
		$smarty->assign("update1",$db->get_update1());
		$smarty->assign("lev1",$db->get_lev1());
		$smarty->assign("aus1",$db->get_aus1());
        $smarty->assign("user",$flotte);
		$smarty->assign("user2",$flotte);
		$smarty->assign("user3",$flotte);
		$smarty->assign("summeckk",$allyfleet);
		$smarty->display("setup.tpl");
	}

	// Keine Session? Schade...
	else
   {
		session_destroy();
	   $smarty->display("error.tpl");
	}
?>