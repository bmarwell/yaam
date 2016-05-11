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
	
	if(isset($_GET['kbid']) || isset($_POST['kbid'])){
		if(isset($_GET['kbid'])) $kbid = $_GET['kbid'];
		else $kbid = $_POST['kbid'];
		$kb = $db->kb_get($kbid);
	
?>


<html>
<head>
	<title>Kampfbericht - ID <?php echo $kbid ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

	<style type="text/css">
	<!--
	body{color:#FFFFFF;margin-top:1px; margin-left:1px;background:#333745}
	.Stil5 {
	        font-size: 12px;
	        font-weight: bold;
	        font-family: Arial, Helvetica, sans-serif;
	        color: #FFFFFF;
	}
	.Stil6 {
	        font-size: 12px;
	        font-weight: bold;
	        font-family: Arial, Helvetica, sans-serif;
	        color: #FF0000;
	}
	.Stil11 {color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
	.Stil26 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #FFFFFF; }
	.Stil27 {font-size: 10px; font-weight: bold; color: #FFFFFF; }
	.Stil28 {color: #FFFFFF}
	.Stil31 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #ee0011; }
	.Stil32 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #00cc00; }
	.Stil33 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #ffffff; }
	.Stil34 {color: #00CC00}
	.Stil35 {font-size: 12px}
	-->

	</style>
</head>
<body text=#FFFFFF>
	<center>

	<table width=519><tr>
	<td colspan=5 bgcolor="#103050" ><div align="center"><span class="Stil5">Kampfbericht ( Universum 3 - ID <?php echo $kbid ?> )</span></div></td>
	</tr>
	<tr>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">Eingereicht von </span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil11"><?php echo $kb['KB_UPLOADER'] ?></span></th>
	</tr>
	<tr>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">am</span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil11"><?php echo $kb['KB_DATEADD'] ?></span></th>
	</tr>
	<tr>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">Datum/Zeit des Berichts </span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil26"><?php echo $kb['KB_DATEDONE'] ?></span></th>
	</tr>
	<td colspan=5  class=c Stil12 Stil13><div align="center"><span class="Stil5"></span></div></td>
	</tr>

	<td colspan=5 bgcolor="#103050" class=c Stil12 Stil13><div align="center"><span class="Stil5">Schiffe des Angreifers (<?php echo $kb['KB_PLANIA'] ?>)</span></div></td>
	</tr>
	<tr>
	<th bgcolor="#111111"><span class="Stil28"></span></th>
	<th bgcolor="#111111"><span class="Stil26">Gesamt</span></th>
	<th bgcolor="#111111"><span class="Stil26">Verluste</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">CKK</span></th>
	</tr>
	
<?php 
	if ($kb['KB_SCHAKALA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Schakal</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_SCHAKALA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_SCHAKALA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_SCHAKALA2"]*0.018490),2).'</span></th>
	</tr>';
	
    if ($kb['KB_RECYCA1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Recycler</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RECYCA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RECYCA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RECYCA2"]*0.045291),2).'</span></th>
	</tr>';
	
	if ($kb['KB_SPIOA1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Spionagesonde</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_SPIOA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_SPIOA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_SPIOA2"]*0.000261),2).'</span></th>
	</tr>';
	
	if ($kb['KB_RENEA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Renegade</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RENEA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RENEA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RENEA2"]*0.052298),2).'</span></th>
	</tr>';
	
	if ($kb['KB_RAIDA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Raider</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RAIDA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RAIDA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RAIDA2"]*0.055470),2).'</span></th>
	</tr>';
	
	if ($kb['KB_TARNA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Tarnbomber</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_TARNA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_TARNA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_TARNA2"]*0.115470),2).'</span></th>
	</tr>';
	
	if ($kb['KB_KOLOA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Kolonisationsschiff</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_KOLOA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_KOLOA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_KOLOA2"]*0.008269),2).'</span></th>
	</tr>';
	
	if ($kb['KB_TJUGA1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Tjuger</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_TJUGA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_TJUGA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_TJUGA2"]*0.350823),2).'</span></th>
	</tr>';
	
	if ($kb['KB_COUGA1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Cougar</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_COUGA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_COUGA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.($kb["KB_COUGA2"]*1).'</span></th>
	</tr>'; 

	if ($kb['KB_LEVA1']>0) echo'	
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Longeagle V</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_LEVA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_LEVA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_LEVA2"]*5.991447),2).'</span></th>
	</tr>';
	
	if ($kb['KB_KLEINA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Kleines Handelsschiff</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_KLEINA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_KLEINA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_KLEINA2"]*0.005847),2).'</span></th>
	</tr>';
	
	if ($kb['KB_GROSSA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Groﬂes Handelsschiff</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_GROSSA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_GROSSA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_GROSSA2"]*0.110940),2).'</span></th>
	</tr>';
	
	if ($kb['KB_NOAHA1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Noah</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_NOAHA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_NOAHA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_NOAHA2"]*1.281025),2).'</span></th>
	</tr>';

	if ($kb['KB_LEXA1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Longeagle X</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_LEXA1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_LEXA2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_LEXA2"]*17.734991),2).'</span></th>
	</tr>';
?>
	

	<tr>
	<th bgcolor="#111111"><span class="Stil32"><i>Gesamt </i></span></th>
	<th bgcolor="#111111"><span class="Stil32"><i><?php echo $kb["KB_SCHAKALA1"]+$kb["KB_RECYCA1"]+$kb["KB_SPIOA1"]+$kb["KB_RENEA1"]+$kb["KB_RAIDA1"]+$kb["KB_TARNA1"]+$kb["KB_KOLOA1"]+$kb["KB_TJUGA1"]+$kb['KB_COUGA1']+$kb['KB_LEVA1']+$kb["KB_KLEINA1"]+$kb["KB_GROSSA1"]+$kb["KB_NOAHA1"]+$kb['KB_LEXA1'] ?></i></span></th>
	<th bgcolor="#111111"><span class="Stil32"><i><?php echo $kb["KB_SCHAKALA2"]+$kb["KB_RECYCA2"]+$kb["KB_SPIOA2"]+$kb["KB_RENEA2"]+$kb["KB_RAIDA2"]+$kb["KB_TARNA2"]+$kb["KB_KOLOA2"]+$kb["KB_TJUGA2"]+$kb['KB_COUGA2']+$kb['KB_LEVA2']+$kb["KB_KLEINA2"]+$kb["KB_GROSSA2"]+$kb["KB_NOAHA2"]+$kb['KB_LEXA2'] ?></i></span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil32"><i><?php echo round(($kb["KB_SCHAKALA2"]*0.018490+$kb["KB_RECYCA2"]*0.045291+$kb["KB_SPIOA2"]*0.000261+$kb["KB_RENEA2"]*0.052298+$kb["KB_RAIDA2"]*0.055470+$kb["KB_TARNA2"]*0.115470+$kb["KB_KOLOA2"]*0.008269+$kb["KB_TJUGA2"]*0.350823+$kb['KB_COUGA2']*1+$kb['KB_LEVA2']*5.991447+$kb["KB_KLEINA2"]*0.005847+$kb["KB_GROSSA2"]*0.110940+$kb["KB_NOAHA2"]*1.281025+$kb['KB_LEXA2']*17.734991),2) ?></i></span></th>
	</tr>
    <tr>
	<th bgcolor="#111111"><span class="Stil32"><i>Flotten CKK </i></span></th>
	<th bgcolor="#111111"><span class="Stil32"></span></th>
	<th bgcolor="#111111"><span class="Stil32"></span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil32"><i><?php echo round(sqrt((($kb["KB_SCHAKALA2"]*50+$kb["KB_RECYCA2"]*300+$kb["KB_SPIOA2"]*1+$kb["KB_RENEA2"]*200+$kb["KB_RAIDA2"]*150+$kb["KB_TARNA2"]*1300+$kb["KB_KOLOA2"]*1+$kb["KB_TJUGA2"]*2000+$kb['KB_COUGA2']*2250+$kb['KB_LEVA2']*15000+$kb["KB_KLEINA2"]*1+$kb["KB_GROSSA2"]*15+$kb["KB_NOAHA2"]*1000+$kb['KB_LEXA2']*92000)*($kb["KB_SCHAKALA2"]*100+$kb["KB_RECYCA2"]*100+$kb["KB_SPIOA2"]*1+$kb["KB_RENEA2"]*200+$kb["KB_RAIDA2"]*300+$kb["KB_TARNA2"]*150+$kb["KB_KOLOA2"]*1000+$kb["KB_TJUGA2"]*900+$kb['KB_COUGA2']*6500+$kb['KB_LEVA2']*35000+$kb["KB_KLEINA2"]*500+$kb["KB_GROSSA2"]*12000+$kb["KB_NOAHA2"]*24000+$kb['KB_LEXA2']*50000))/(2250*6500)),2) ?></i></span></th>
	</tr>
	<tr>
	<td colspan=6  class=c Stil12 Stil13><div align="center"><span class="Stil5"></span></div></td>
	</tr>
	<tr>
	<td colspan=6  class=c Stil12 Stil13><div align="center"><span class="Stil5"></span></div></td>
	</tr>
	  <tr>
	<td colspan=5 bgcolor="#103050" class=c Stil12 Stil13><div align="center"><span class="Stil5">Schiffe des Verteidigers (<?php echo $kb['KB_PLANID'] ?>)</span></div></td>
	</tr>

<?php
    if ($kb['KB_SCHAKALD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Schakal</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_SCHAKALD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_SCHAKALD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_SCHAKALD2"]*0.018490),2).'</span></th>
	</tr>';
     
	if ($kb['KB_RECYCD1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Recycler</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RECYCD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RECYCD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RECYCD2"]*0.045291),2).'</span></th>
	</tr>';
	
	if ($kb['KB_SPIOD1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Spionagesonde</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_SPIOD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_SPIOD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_SPIOD2"]*0.000261),2).'</span></th>
	</tr>';
	
	if ($kb['KB_RENED1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Renegade</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RENED1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RENED2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RENED2"]*0.052298),2).'</span></th>
	</tr>';

	if ($kb['KB_RAIDD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Raider</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RAIDD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RAIDD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RAIDD2"]*0.055470),2).'</span></th>
	</tr>';

	if ($kb['KB_TARND1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Tarnbomber</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_TARND1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_TARND2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_TARND2"]*0.115470),2).'</span></th>
	</tr>';

	if ($kb['KB_KOLOD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Kolonisationsschiff</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_KOLOD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_KOLOD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_KOLOD2"]*0.008269),2).'</span></th>
	</tr>';
	if ($kb['KB_TJUGD1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Tjuger</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_TJUGD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_TJUGD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_TJUGD2"]*0.350823),2).'</span></th>
	</tr>'; 
	
	if ($kb['KB_COUGD1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Cougar</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_COUGD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_COUGD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.($kb["KB_COUGD2"]*1).'</span></th>
	</tr>'; 

	if ($kb['KB_LEVD1']>0) echo'	
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Longeagle V</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_LEVD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_LEVD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_LEVD2"]*5.991447),2).'</span></th>
	</tr>';
	
	if ($kb['KB_KLEIND1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Kleines Handelsschiff</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_KLEIND1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_KLEIND2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_KLEIND2"]*0.005847),2).'</span></th>
	</tr>';

	if ($kb['KB_GROSSD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Groﬂes Handelsschiff</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_GROSSD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_GROSSD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_GROSSD2"]*0.110940),2).'</span></th>
	</tr>';
	
	if ($kb['KB_NOAHD1']>0) echo'    
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Noah</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_NOAHD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_NOAHD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_NOAHD2"]*1.281025),2).'</span></th>
	</tr>';

	if ($kb['KB_LEXD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Longeagle X</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_LEXD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_LEXD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_LEXD2"]*17.734991),2).'</span></th>
	</tr>';
	
	if ($kb['KB_LEICHTD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Leichter Laserturm</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_LEICHTD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_LEICHTD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_LEICHTD2"]*0.059914),2).'</span></th>
	</tr>';
	
	if ($kb['KB_LASERD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Laserturm</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_LASERD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_LASERD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_LASERD2"]*0.218777),2).'</span></th>
	</tr>';
	
	if ($kb['KB_EMPD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">EMP-Werfer</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_EMPD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_EMPD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_EMPD2"]*0.350823),2).'</span></th>
	</tr>';
	
	if ($kb['KB_PLASMAD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Plasmaturm</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_PLASMAD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_PLASMAD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_PLASMAD2"]*0.258860),2).'</span></th>
	</tr>';
	
	if ($kb['KB_RAKSD1']>0) echo'
	<tr>
	<th bgcolor="#111111"><span class="Stil26">Raks</span></th>
	<th bgcolor="#111111"><span class="Stil26">'.$kb["KB_RAKSD1"].'</span></th>
	<th bgcolor="#111111"><span class="Stil31">'.$kb["KB_RAKSD2"].'</span></th>
	<th colspan=2 bgcolor="#111111"><span class="Stil26">'.round(($kb["KB_RAKSD2"]*1.578704),2).'</span></th>
	</tr>';
	
?>


	<tr>
	<th bgcolor="#111111"><span class="Stil32"><i>Gesamt </i></span></th>
	<th bgcolor="#111111"><span class="Stil32"><i><?php echo $kb["KB_SCHAKALD1"]+$kb["KB_RECYCD1"]+$kb["KB_SPIOD1"]+$kb["KB_RENED1"]+$kb["KB_RAIDD1"]+$kb["KB_TARND1"]+$kb["KB_KOLOD1"]+$kb["KB_TJUGD1"]+$kb['KB_COUGD1']+$kb['KB_LEVD1']+$kb["KB_KLEIND1"]+$kb["KB_GROSSD1"]+$kb["KB_NOAHD1"]+$kb['KB_LEXD1']+$kb["KB_LEICHTD1"]+$kb["KB_LASERD1"]+$kb["KB_EMPD1"]+$kb["KB_PLASMAD1"]+$kb["KB_RAKSD1"] ?></i></span></th>
	<th bgcolor="#111111"><span class="Stil32"><i><?php echo $kb["KB_SCHAKALD2"]+$kb["KB_RECYCD2"]+$kb["KB_SPIOD2"]+$kb["KB_RENED2"]+$kb["KB_RAIDD2"]+$kb["KB_TARND2"]+$kb["KB_KOLOD2"]+$kb["KB_TJUGD2"]+$kb['KB_COUGD2']+$kb['KB_LEVD2']+$kb["KB_KLEIND2"]+$kb["KB_GROSSD2"]+$kb["KB_NOAHD2"]+$kb['KB_LEXD2']+$kb["KB_LEICHTD2"]+$kb["KB_LASERD2"]+$kb["KB_EMPD2"]+$kb["KB_PLASMAD2"]+$kb["KB_RAKSD2"] ?></i></span></th>
	<th bgcolor="#111111"><span class="Stil32"><i><?php echo round(($kb["KB_SCHAKALD2"]*0.018490+$kb["KB_RECYCD2"]*0.045291+$kb["KB_SPIOD2"]*0.000261+$kb["KB_RENED2"]*0.052298+$kb["KB_RAIDD2"]*0.055470+$kb["KB_TARND2"]*0.115470+$kb["KB_KOLOD2"]*0.008269+$kb["KB_TJUGD2"]*0.350823+$kb['KB_COUGD2']*1+$kb['KB_LEVD2']*5.991447+$kb["KB_KLEIND2"]*0.005847+$kb["KB_GROSSD2"]*0.110940+$kb["KB_NOAHD2"]*1.281025+$kb['KB_LEXD2']*17.734991+$kb["KB_LEICHTD2"]*0.059914+$kb["KB_LASERD2"]*0.218777+$kb["KB_EMPD2"]*0.350823+$kb["KB_PLASMAD2"]*0.258860+$kb["KB_RAKSD2"]*1.578704),2) ?></i></span></th>
	</tr>
    <tr>
	<th bgcolor="#111111"><span class="Stil32"><i>Flotten CKK </i></span></th>
	<th bgcolor="#111111"><span class="Stil32"></span></th>
	<th bgcolor="#111111"><span class="Stil32"></span></th>
	<th bgcolor="#111111"><span class="Stil32"><i><?php echo round(sqrt((($kb["KB_SCHAKALD2"]*50+$kb["KB_RECYCD2"]*300+$kb["KB_SPIOD2"]*1+$kb["KB_RENED2"]*200+$kb["KB_RAIDD2"]*150+$kb["KB_TARND2"]*1300+$kb["KB_KOLOD2"]*1+$kb["KB_TJUGD2"]*2000+$kb['KB_COUGD2']*2250+$kb['KB_LEVD2']*15000+$kb["KB_KLEIND2"]*1+$kb["KB_GROSSD2"]*15+$kb["KB_NOAHD2"]*1000+$kb['KB_LEXD2']*92000+$kb["KB_LEICHTD2"]*150+$kb["KB_LASERD2"]*700+$kb["KB_EMPD2"]*1000+$kb["KB_PLASMAD2"]*1400+$kb["KB_RAKSD2"]*8100)*($kb["KB_SCHAKALD2"]*100+$kb["KB_RECYCD2"]*100+$kb["KB_SPIOD2"]*1+$kb["KB_RENED2"]*200+$kb["KB_RAIDD2"]*300+$kb["KB_TARND2"]*150+$kb["KB_KOLOD2"]*1000+$kb["KB_TJUGD2"]*900+$kb['KB_COUGD2']*6500+$kb['KB_LEVD2']*35000+$kb["KB_KLEIND2"]*500+$kb["KB_GROSSD2"]*12000+$kb["KB_NOAHD2"]*24000+$kb['KB_LEXD2']*50000+$kb["KB_LEICHTD2"]*300+$kb["KB_LASERD2"]*1000+$kb["KB_EMPD2"]*1800+$kb["KB_PLASMAD2"]*700+$kb["KB_RAKSD2"]*4500))/(2250*6500)),2) ?></i></span></th>
	</tr>

	<tr>
	<td colspan=6  class=c Stil12 Stil13><div align="center"><span class="Stil5"></span></div></td>
	</tr>
	<tr>
	<td colspan=6  class=c Stil12 Stil13><div align="center"><span class="Stil5"></span></div></td>
	</tr>
	  <tr>
	<td colspan=5 bgcolor="#103050" class=c Stil12 Stil13><div align="center"><span class="Stil5">Erbeutete/Recycelte Ressourcen</span></div></td>
	</tr>

	<th colspan=2 bgcolor="#111111"><span class="Stil32">Eisen</span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil33"><?php echo $kb['KB_EISEN'] ?></span></th>
	</tr>

	<tr>
	<th colspan=2 bgcolor="#111111"><span allign="left" class="Stil32">Lutinum</span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil33"><?php echo $kb['KB_LUTINUM'] ?></span></th>
	</tr>
	
	<th colspan=2 bgcolor="#111111"><span class="Stil32">Wasser</span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil33"><?php echo $kb['KB_WASSER'] ?></span></th>

	</tr>

	<tr>
	<th colspan=2 bgcolor="#111111"><span allign="left" class="Stil32">Wasserstoff</span></th>
	<th colspan=3 bgcolor="#111111"><span class="Stil33"><?php echo $kb['KB_WASSERSTOFF'] ?></span></th>

	</tr>
	
	<tr>
	<td colspan=6 bgcolor="#103050" class=c Stil12 Stil13><div align="center"><span class="Stil5"></span></div></td>
	</tr>
	</table>
	</center>
</body>
</html>


<?php } ?>