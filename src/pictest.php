<?php
	require("config/config.php");
	$PATH=$CONFIG['internal']['sqlconf'];  
	require("$PATH/config.php");
	require("$PATH/mysql.inc.php");
	require("log/hlog.php");
	define('SMARTY_DIR', $CONFIG['internal']['smarty_dir']);
	require(SMARTY_DIR.'Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty->assign("CONFIG_internal_serverpath",$CONFIG["internal"]["serverpath"]);

	session_start();	

	$db = new cl_extended_database;
	
	if(isset($_SESSION["user"])) {
	    $feind=$_POST['feind'];
	    $size=$_POST['size'];

		if (!isset($size)) {
			$size=12;
			$feind=1;
		}
		
		$users=$db->get_allusersNick();
		$cu=count($users)/2;
		$xsize=300*$size;
		$ysize=200*$size;
		$feindNr=0;
		$feindDisplayMover=0;
		$feindDisplayMoverY=0;
		
		
		$im = imagecreatetruecolor($xsize, $ysize+(50*21));
		$grey = imagecolorallocate($im, 211, 211, 211);
		$green = imagecolorallocate($im, 0, 255, 0);
		
		for ($i = 0; $i < $xsize; $i+=10*$size) {
			imageline($im, $i, 0, $i, $ysize, $grey);
			
			if ($size>=4 && $i>0) {
				imagestring($im, 1, $i+3, 5,  "S ".$i/$size, imagecolorallocate($im, 255, 255, 255));			
			}
		}
		
		for ($i = 0; $i <= $ysize; $i+=10*$size) {
			imageline($im, 0, $i, $xsize,$i, $grey);
			
			if ($size>=4) {
				imagestring($im, 1, 5, $i+3,  "G ".$i/$size, imagecolorallocate($im, 255, 255, 255));			
			}
			
		}
	
		//h_debug_array("users=",$users);
	
		for ($i = 0; $i < $cu; $i++) {
			$gcolR=$users[$i]*367%235+20;
			$gcolG=$users[$i]*601%175+80;
			$gcolB=$users[$i]*919%215+40;

			imagestring($im, 2, 5, $ysize+20+($i*10),  $users[$i.'nick'], imagecolorallocate($im, $gcolR, $gcolG, $gcolB));
		}
		
		if ($feind==1) {
			imagefilledarc($im, $xsize-150*$size,$ysize+20,12,12,270,280, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
			imagefilledarc($im, $xsize-150*$size,$ysize+20,12,12,0,10, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
			imagefilledarc($im, $xsize-150*$size,$ysize+20,12,12,90,100, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
			imagefilledarc($im, $xsize-150*$size,$ysize+20,12,12,180,190, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
			
			imagestring($im, 2, $xsize-200*$size, $ysize+15,  "Feindangriff von ", imagecolorallocate($im, 255,0, 0));		
		}		
		$koords=$db->get_allusersCoordinates();		
		
		//h_debug_array("koords=",$koords);
		
		for ($i = 0; $i < count($koords); $i++) {
			// Feindkoordinaten haben id 255
			if ($koords[$i.'uid']!=255) {		
				$koor=preg_split("/:/",$koords[$i]);
				//h_debug_array("koor=",$koords);
				$gcolR=$koords[$i.'uid']*367%235+20;
				$gcolG=$koords[$i.'uid']*601%175+80;
				$gcolB=$koords[$i.'uid']*919%215+40;
							
				if (count($koor)>1) {
					/*
					h_debug_array("id=",$koords[$i]);
					h_debug_array("R=",$gcolR);
					h_debug_array("G=",$gcolG);		
					h_debug_array("B=",$gcolB);
					h_debug_array("koor=",$koor);			
					*/
					imagefilledarc($im, $koor[1]*$size, $koor[0]*$size,5,5,0,360, imagecolorallocate($im, $gcolR, $gcolG, $gcolB),IMG_ARC_PIE); 
					
					if ($size>=4) {
						imagestring($im, 1, $koor[1]*$size-10, $koor[0]*$size+2, searchNick($users,$koords[$i.'uid']) , imagecolorallocate($im, $gcolR, $gcolG, $gcolB));
					}
				}
			} else {
				if ($feind==1) {
					$koor=preg_split("/:/",$koords[$i]);
					if (count($koor)>1) {
						$feindNr++;
						imagefilledarc($im, $koor[1]*$size, $koor[0]*$size,12,12,270,280, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
						imagefilledarc($im, $koor[1]*$size, $koor[0]*$size,12,12,0,10, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
						imagefilledarc($im, $koor[1]*$size, $koor[0]*$size,12,12,90,100, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 
						imagefilledarc($im, $koor[1]*$size, $koor[0]*$size,12,12,180,190, imagecolorallocate($im, 255, 0, 0),IMG_ARC_PIE); 					
						
						if ($size>=4) {
							if (($feindNr-1)%50==0 && $feindNr-1>0) {
								$feindDisplayMover+=120;
								$feindDisplayMoverY=10;
							} else {
								$feindDisplayMoverY+=10;
							}
							imagestring($im, 2, $koor[1]*$size-2,$koor[0]*$size-20, "".$feindNr , imagecolorallocate($im, 255, 0, 0));														
							imagestring($im, 2, $xsize-200*$size+$feindDisplayMover, $ysize+25+$feindDisplayMoverY,  "Feind ".$feindNr."=".$koor[0].":".$koor[1].":".$koor[2], imagecolorallocate($im, 255,0, 0));
						}
						
					}
				}
			}
		}
	
		
		header("content-type:image/jpeg");
		imagejpeg($im);
		
		// Free up memory
		imagedestroy($im);
		
	} else {
		session_destroy();
	    $smarty->display("error.tpl");
	}
	
	function searchNick($users, $uid) {
		$cu=count($users)/2;
		
		for ($i = 0; $i < $cu; $i++) {
			if ($users[$i]==$uid) {
				return $users[$i.'nick'];
			}
		}
		
		return "X";
	}
?>
