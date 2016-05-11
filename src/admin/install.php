<head>
	<title>..:: Installation Yet Another Ally Manager!</title>
	<link rel="stylesheet" type="text/css" href="../yaam.css">
</head>

<body>
	<div align="center">
		<img border="0" src="../bilder/logo.png">
			<?php
				if(!isset($_GET['install']) && !isset($_GET['add']))
				{
				echo '
				<table class="install">
					<tr bgcolor="#565656">
						<td>
							<p align="center">
							<b><font color="#FF00FF" size="4">INSTALL</font>
						</td>
					</tr>
					<tr bgcolor="#565656">
						<td>
							<b><center><font color="#00FF00">
							Die Datenbank muss komplett restauriert werden.
							Bitte l&ouml;sche den gesamten Inhalt, falls die DB nicht leer sein sollte.
							</font>
						</td>
					</tr>
					<tr bgcolor="#565656">
						<th>
							<font color="#00FFFF">
							Den CHMOD fehler ignorieren. Der kann einen
							Fehler aufrufen, wenn der Server dies nicht
							unterst&uuml;tzt..
						</th>
					</tr>
					<tr bgcolor="#6F6F6F">
						<th>
							<font color="#FFFFFF">Die config.php &auml;ndern.</font>
						</th>
					</tr>
					<tr bgcolor="#6F6F6F">
						<th>
							<font color="#FFFFFF">.. :: Datenbank Daten :: ..</font>
						</th>
					</tr>
					<tr>
						<td>
	<form action="install.php?install&add=true" method="post">
	<table border="1" bordercolor="#000000" width="100%" style="border-collapse: collapse" cellpadding="0" cellspacing="0">
		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Datenbank Host</td>
    		<td width="50%">
    			<input type="text" name="dbhost" size="25" value="localhost">
    		</td>
		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Datenbank User:</td>
    		<td width="50%"><input type="text" name="dbuser" size="25"></td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Datenbank Passwort:</td>
   			<td width="50%"><input type="password" name="dbpass" size="25"></td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Datenbank Name</td>
    		<td width="50%"><input type="text" name="dbname" size="25"></td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Pfad zum Verzeichnis</td>
			<td width="50%"><input type="text" name="dbpfad" value="http://xxxx.xx.funpic.de/yaam/" size="25"></td>
		</tr>
		<tr bgcolor="#6F6F6F">
			<td width="50%"><font color="#FFFFFF">Datebank Pr&auml;fix</td>
    		<td width="50%"><input type="text" name="prefix" VALUE="fs_" size="25"></td>
		</tr>
		<tr bgcolor="#6F6F6F">
			<td colspan="2"><font color="#FFFFFF">
				<b><center>Admin Daten...</b></center>
			</td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Admin Nick</td>
    		<td width="50%"><input type="text" name="a_nick" size="25"></td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Admin E-Mail</td>
    		<td width="50%"><input type="text" name="a_email" size="25"></td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td width="50%"><font color="#FFFFFF">Admin Passwort</td>
    		<td width="50%"><input type="password" name="a_pass" size="25"></td>
  		</tr>
  		<tr bgcolor="#6F6F6F">
    		<td colspan="2">
    			<p align="center"><input type="submit" name="submit" value="Installieren">
    		</td>
 		</tr>
 	</table>
 	</form>
 						</td>
 					</tr>
				</table>
			</div>';
				}
				elseif( isset( $_GET['install'] ) && isset( $_GET['add']) )
				{
			#############################
			$dbhost = $_POST['dbhost'];
			$dbuser = $_POST['dbuser'];
			$dbpass = $_POST['dbpass'];
			$dbname = $_POST['dbname'];
			$dbpfad = $_POST['dbpfad'];
			$prefix = $_POST['prefix'];
			#############################
			$a_nick = $_POST['a_nick'];
			$a_pass = $_POST['a_pass'];
			$a_email = $_POST['a_email'];
			#############################
			
			if ( empty( $_POST['a_nick'] ) OR empty( $_POST['a_pass'] ) OR empty( $_POST['a_email'] ) OR
				empty( $_POST['dbuser'] ) OR empty( $_POST['dbname'] ) OR empty( $_POST['dbhost']) )
			{
			echo '
			<div align="center"></div>
			<table class="install">
				<tr>
					<td class="Cnorm">
						Folgende Angaben sind unbedingt erforderlich:<br />
						<ul>
							<li>Hostname</li>
							<li>Username</li>
							<li>Datenbank</li>
							<li>AdminPassword</li>
							<li>AdminE-Mail</li>
							<li>AdminName</li>
						</ul>
						&nbsp;<a href="javascript:history.back(-1)">zur&uuml;ck</a>
					</td>
				</tr>
			</table>
			</div>';
			die ();
			}	else	{
				$eintragungen = '<?php
						$CONFIG["mysql"]["host"] = "'.$dbhost.'";
						$CONFIG["mysql"]["user"] = "'.$dbuser.'";
						$CONFIG["mysql"]["pass"] = "'.$dbpass.'";
						$CONFIG["mysql"]["db"] = "'.$dbname.'";
						$CONFIG["mysql"]["prefix"] = "'.$prefix.'";
						require("version.inc.php");
						$CONFIG["internal"]["serverpath"] = "'.$dbpfad.'";
						$CONFIG["internal"]["sqlconf"] = "config/";
						$CONFIG["internal"]["smarty_dir"] = "smarty/";
						$CONFIG["internal"]["path"] = ".";
					?>';
				$open = fopen("../config/config.php", "w");
    			$write = fwrite($open, "$eintragungen");
    			fclose($open);
    			
    			chmod("../config/config.php", 0644);

				mysql_connect("$dbhost", "$dbuser","$dbpass") or die ("Keine Verbindung moeglich");
				mysql_select_db("$dbname") or die ("Die Datenbank existiert nicht");
	
mysql_query("
CREATE TABLE `".$prefix."ausbau` (
  `A_KID` smallint(5) unsigned NOT NULL,
  `A_KZ` tinyint(3) unsigned NOT NULL,
  `A_FZ` tinyint(3) unsigned NOT NULL,
  `A_FeMine` tinyint(3) unsigned NOT NULL,
  `A_LutRaff` tinyint(3) unsigned NOT NULL,
  `A_Bohr` tinyint(3) unsigned NOT NULL,
  `A_Chem` tinyint(3) unsigned NOT NULL,
  `A_ErwChem` tinyint(3) unsigned NOT NULL,
  `A_FeSpeicher` tinyint(3) unsigned NOT NULL,
  `A_LutSpeicher` tinyint(3) unsigned NOT NULL,
  `A_WasSpeicher` tinyint(3) unsigned NOT NULL,
  `A_H2Speicher` tinyint(3) unsigned NOT NULL,
  `A_SF` tinyint(3) unsigned NOT NULL,
  `A_OV` tinyint(3) unsigned NOT NULL,
  `A_Fusi` tinyint(3) unsigned NOT NULL,
  `A_Schild` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`A_KID`)
) ENGINE=MyISAM;");

mysql_query("
CREATE TABLE `".$prefix."forschung` (
  `F_UID` smallint(5) unsigned NOT NULL,
  `F_VbA` smallint(5) unsigned NOT NULL,
  `F_IoA` smallint(5) unsigned NOT NULL,
  `F_RkA` smallint(5) unsigned NOT NULL,
  `F_RfA` smallint(5) unsigned NOT NULL,
  `F_Ionis` smallint(5) unsigned NOT NULL,
  `F_Energ` smallint(5) unsigned NOT NULL,
  `F_Explo` smallint(5) unsigned NOT NULL,
  `F_Spio` smallint(5) unsigned NOT NULL,
  `F_Panzer` smallint(5) unsigned NOT NULL,
  `F_LadeKapa` smallint(5) unsigned NOT NULL,
  `F_Recycler` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`F_UID`)
) ENGINE=MyISAM;");

mysql_query("
CREATE TABLE `".$prefix."koordinaten` (
  `K_KID` smallint(5) unsigned NOT NULL auto_increment,
  `K_Koord` varchar(10) NOT NULL,
  `K_UID` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`K_KID`),
  UNIQUE KEY `K_Koord` (`K_Koord`)
) ENGINE=MyISAM AUTO_INCREMENT=1;");

mysql_query("
CREATE TABLE `".$prefix."schiffe` (
  `S_KID` mediumint(8) unsigned NOT NULL,
  `S_Sonden` int(10) unsigned NOT NULL,
  `S_Recycler` mediumint(8) unsigned NOT NULL,
  `S_Tjugar` mediumint(8) unsigned NOT NULL,
  `S_Cougar` mediumint(8) unsigned NOT NULL,
  `S_LeV` mediumint(8) unsigned NOT NULL,
  `S_Noah` mediumint(8) unsigned NOT NULL,
  `S_LeX` mediumint(8) unsigned NOT NULL,
  `S_Schakal` int(10) unsigned NOT NULL,
  `S_Rene` int(10) unsigned NOT NULL,
  `S_Raid` int(10) unsigned NOT NULL,
  `S_Tarn` int(10) unsigned NOT NULL,
  `S_Kolo` int(10) unsigned NOT NULL,
  `S_Klein` int(10) unsigned NOT NULL,
  `S_Gross` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`S_KID`)
) ENGINE=MyISAM;");

mysql_query("
CREATE TABLE `".$prefix."users` (
  `U_ID` tinyint(3) unsigned NOT NULL auto_increment COMMENT 'User-ID',
  `U_Nick` varchar(16) NOT NULL,
  `U_Pass` varchar(80) NOT NULL,
  `U_LastChg` datetime default NULL COMMENT 'Wann zuletzt aktualisiert?',
  `U_Email` varchar(24) NOT NULL,
  `U_Rechte` tinyint(1) unsigned NOT NULL default 0 COMMENT '0-4',
  `U_Tag` varchar(8) default NULL Comment 'z.B.   [Main]',
  `U_Main` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`U_ID`),
  UNIQUE KEY `U_Nick` (`U_Nick`),
  UNIQUE KEY `U_Email` (`U_Email`)
) ENGINE=MyISAM AUTO_INCREMENT=1;");

mysql_query("
CREATE TABLE `".$prefix."news` (
  `N_NID` mediumint(9) NOT NULL auto_increment,
  `N_UID` tinyint(3) unsigned NOT NULL default '0',
  `N_timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `N_Text` text NOT NULL,
  PRIMARY KEY  (`N_NID`)
) TYPE=MyISAM AUTO_INCREMENT=1;");

mysql_query("
CREATE TABLE `".$prefix."settings` (
  `Set_Name` varchar(20) NOT NULL,
  `Set_Value` tinyint(1) NOT NULL,
  PRIMARY KEY  (`Set_Name`)
) ENGINE=MyISAM;");

mysql_query("
CREATE TABLE `".$prefix."vacation` (
`V_UID` MEDIUMINT NOT NULL ,
`V_Sitter` VARCHAR( 20 ) NOT NULL ,
`V_Start` DATE NOT NULL ,
`V_Ende` DATE NOT NULL ,
`V_Grund` VARCHAR( 80 ) NOT NULL ,
PRIMARY KEY ( `V_UID` )
) ENGINE = MYISAM;");

// Hinzugefuegt durch Sebastian Meese aka JabbaTheHood
// benoetigt fuer Kb-Upload-Tool
mysql_query("
CREATE TABLE `".$prefix."kbs` (
  `KB_ID` smallint(12) unsigned NOT NULL auto_increment,
  `KB_UPLOADER` varchar(32) NOT NULL default '',
  `KB_DATEADD` varchar(32) NOT NULL default '',
  `KB_DATEDONE` varchar(32) NOT NULL default '',
  `KB_PLANIA` varchar(32) NOT NULL default '',
  `KB_SCHAKALA1` int(12) unsigned NOT NULL default '0',
  `KB_SCHAKALA2` int(12) unsigned NOT NULL default '0',
  `KB_RECYCA1` int(12) unsigned NOT NULL default '0',
  `KB_RECYCA2` int(12) unsigned NOT NULL default '0',
  `KB_SPIOA1` int(12) unsigned NOT NULL default '0',
  `KB_SPIOA2` int(12) unsigned NOT NULL default '0',
  `KB_RENEA1` int(12) unsigned NOT NULL default '0',
  `KB_RENEA2` int(12) unsigned NOT NULL default '0',
  `KB_RAIDA1` int(12) unsigned NOT NULL default '0',
  `KB_RAIDA2` int(12) unsigned NOT NULL default '0',
  `KB_TARNA1` int(12) unsigned NOT NULL default '0',
  `KB_TARNA2` int(12) unsigned NOT NULL default '0',
  `KB_KOLOA1` int(12) unsigned NOT NULL default '0',
  `KB_KOLOA2` int(12) unsigned NOT NULL default '0',
  `KB_TJUGA1` int(12) unsigned NOT NULL default '0',
  `KB_TJUGA2` int(12) unsigned NOT NULL default '0',
  `KB_COUGA1` int(12) unsigned NOT NULL default '0',
  `KB_COUGA2` int(12) unsigned NOT NULL default '0',
  `KB_LEVA1` int(12) unsigned NOT NULL default '0',
  `KB_LEVA2` int(12) unsigned NOT NULL default '0',
  `KB_NOAHA1` int(12) unsigned NOT NULL default '0',
  `KB_NOAHA2` int(12) unsigned NOT NULL default '0',
  `KB_KLEINA1` int(12) unsigned NOT NULL default '0',
  `KB_KLEINA2` int(12) unsigned NOT NULL default '0',
  `KB_GROSSA1` int(12) unsigned NOT NULL default '0',
  `KB_GROSSA2` int(12) unsigned NOT NULL default '0',
  `KB_LEXA1` int(12) unsigned NOT NULL default '0',
  `KB_LEXA2` int(12) unsigned NOT NULL default '0',
  `KB_PLANID` varchar(32) NOT NULL default '',
  `KB_SCHAKALD1` int(12) unsigned NOT NULL default '0',
  `KB_SCHAKALD2` int(12) unsigned NOT NULL default '0',
  `KB_RECYCD1` int(12) unsigned NOT NULL default '0',
  `KB_RECYCD2` int(12) unsigned NOT NULL default '0',
  `KB_SPIOD1` int(12) unsigned NOT NULL default '0',
  `KB_SPIOD2` int(12) unsigned NOT NULL default '0',
  `KB_RENED1` int(12) unsigned NOT NULL default '0',
  `KB_RENED2` int(12) unsigned NOT NULL default '0',
  `KB_RAIDD1` int(12) unsigned NOT NULL default '0',
  `KB_RAIDD2` int(12) unsigned NOT NULL default '0',
  `KB_TARND1` int(12) unsigned NOT NULL default '0',
  `KB_TARND2` int(12) unsigned NOT NULL default '0',
  `KB_KOLOD1` int(12) unsigned NOT NULL default '0',
  `KB_KOLOD2` int(12) unsigned NOT NULL default '0',
  `KB_TJUGD1` int(12) unsigned NOT NULL default '0',
  `KB_TJUGD2` int(12) unsigned NOT NULL default '0',
  `KB_COUGD1` int(12) unsigned NOT NULL default '0',
  `KB_COUGD2` int(12) unsigned NOT NULL default '0',
  `KB_LEVD1` int(12) unsigned NOT NULL default '0',
  `KB_LEVD2` int(12) unsigned NOT NULL default '0',
  `KB_KLEIND1` int(12) unsigned NOT NULL default '0',
  `KB_KLEIND2` int(12) unsigned NOT NULL default '0',
  `KB_GROSSD1` int(12) unsigned NOT NULL default '0',
  `KB_GROSSD2` int(12) unsigned NOT NULL default '0',
  `KB_NOAHD1` int(12) unsigned NOT NULL default '0',
  `KB_NOAHD2` int(12) unsigned NOT NULL default '0',
  `KB_LEXD1` int(12) unsigned NOT NULL default '0',
  `KB_LEXD2` int(12) unsigned NOT NULL default '0',
  `KB_LEICHTD1` int(12) unsigned NOT NULL default '0',
  `KB_LEICHTD2` int(12) unsigned NOT NULL default '0',
  `KB_LASERD1` int(12) unsigned NOT NULL default '0',
  `KB_LASERD2` int(12) unsigned NOT NULL default '0',
  `KB_EMPD1` int(12) unsigned NOT NULL default '0',
  `KB_EMPD2` int(12) unsigned NOT NULL default '0',
  `KB_PLASMAD1` int(12) unsigned NOT NULL default '0',
  `KB_PLASMAD2` int(12) unsigned NOT NULL default '0',
  `KB_RAKSD1` int(12) unsigned NOT NULL default '0',
  `KB_RAKSD2` int(12) unsigned NOT NULL default '0',
  `KB_EISEN` int(10) unsigned NOT NULL default '0',
  `KB_LUTINUM` int(10) unsigned NOT NULL default '0',
  `KB_WASSER` int(10) unsigned NOT NULL default '0',
  `KB_WASSERSTOFF` int(10) unsigned NOT NULL default '0',
  `KB_CKK` double unsigned NOT NULL default '0',
  `KB_RESSIS` int(12) unsigned NOT NULL default '0',
  PRIMARY KEY  (`KB_ID`),
  UNIQUE KEY `KB_DATEDONE` (`KB_DATEDONE`)
) TYPE=MyISAM ;");

// Hinzugefuegt durch Hahue [-V-]
// benoetigt fuer Karte
mysql_query("
CREATE TABLE `".$prefix."highscore` (
  `name` varchar(50) NOT NULL default '',
  `punkteFo` int(10) NOT NULL default '0',
  `punktePl` int(10) NOT NULL default '0',
  `anzahlPl` int(2) NOT NULL default '0',
  `tag` varchar(20) NOT NULL default '',
  `updatedate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`name`),
  KEY `tag` (`tag`)
) TYPE=MyISAM;");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('Uni9', 1);");
	
mysql_query("
INSERT INTO `".$prefix."kbs` ( `KB_UPLOADER` , `KB_DATEADD` , `KB_DATEDONE` , `KB_PLANIA` , `KB_SCHAKALA1` , `KB_SCHAKALA2` , `KB_RECYCA1` , `KB_RECYCA2` , `KB_SPIOA1` , `KB_SPIOA2` , `KB_RENEA1` , `KB_RENECA2` , `KB_RAIDA1` , `KB_RAIDA2` , `KB_TARNA1` , `KB_TARNA2` , `KB_KOLOA1` , `KB_KOLOA2` , `KB_TJUGA1` , `KB_TJUGA2` , `KB_COUGA1` , `KB_COUGA2` , `KB_LEVA1` , `KB_LEVA2` , `KB_KLEINA1` , `KB_KLEINA2` , `KB_GROSSA1` , `KB_GROSSA2` , `KB_NOAHA1` , `KB_NOAHA2` , `KB_LEXA1` , `KB_LEXA2` , `KB_PLANID` , `KB_SCHAJALD1` , `KB_SCHAKALD2` , `KB_RECYCD1` , `KB_RECYCD2` , `KB_SPIOD1` , `KB_SPIOD2` , `KB_RENED1` , `KB_RENED2` , `KB_RAIDD1` , `KB_RAIDD2` , `KB_TARND1` , `KB_TARND2` , `KB_KOLOD1` , `KB_KOLOD2` , `KB_TJUGD1` , `KB_TJUGD2` , `KB_COUGD1` , `KB_COUGD2` , `KB_LEVD1` , `KB_LEVD2` , `KB_KLEIND1` , `KB_KLEIND2` , `KB_GROSSD1` , `KB_GROSSD2` , `KB_NOAHD1` , `KB_NOAHD2` , `KB_LEXD1` , `KB_LEXD2` , `KB_LEICHTD1` , `KB_LEICHTD2` , `KB_LASERD1` , `KB_LASERD2` , `KB_EMPD1` , `KB_EMPD2` , `KB_PLASMAD1` , `KB_PLASMAD2` , `KB_RAKSD1` , `KB_RAKSD2` , `KB_EISEN` , `KB_LUTINUM` , `KB_WASSER` , `KB_WASSERSTOFF` , `KB_CKK` , `KB_RESSIS` ) 
VALUES (
' ', ' ', ' ', ' ', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ' ', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
);");
// Ende hinzugefuegt durch Sebastian Meese aka JabbaTheHood

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('Register', 1);");
	
mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('repl_grund', 1);");	

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('Pro_Alli', 5);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('Pro_Erster', 5);");
	
mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('CKK', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('ECKK', 3);");	          

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('FCKK', 3);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('FECKK', 3);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('FORSCH', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('UPDATE', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('LEV', 3);");
	
mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('AUS', 3);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('Pro_Alli1', 5);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('Pro_Erster1', 5);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('CKK1', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('ECKK1', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('FCKK1', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('FECKK1', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('FORSCH1', 1);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('UPDATE1', 1);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('LEV1', 2);");

mysql_query("
INSERT INTO `".$prefix."settings` ( `Set_Name` , `Set_Value` )
	VALUES ('AUS1', 2);");	
	
mysql_query("
INSERT INTO `".$prefix."forschung` ( `F_UID` )
	VALUES (1);");

mysql_query("
INSERT INTO `".$prefix."news` (`N_UID`, `N_timestamp`, `N_Text`)
	VALUES (1, NOW(), 'Herzlichen Gl&uuml;hstrumpf!<br>
	Du hast Yaam! erfolgreich eingerichtet! Viel Spa&szlig; mit dem Script!<br>
	<br>
	Beste Gr&uuml;&szlig;e,<br>');");
				
mysql_query("
INSERT INTO ".$prefix."users( U_Nick, U_Pass, U_LastChg, U_Email, U_Rechte) VALUES ('".$a_nick."', '".md5($a_pass)."', NOW(), '".$a_email."', '4')");
	
	echo '
		<table width="70%" class="border" border="0" cellspacing="0" cellpadding="25" align="center">
			<tr>
   		<td>
    		<h2><b><font color="#FFFFFF">Installation abgeschlossen</b></h2>
			<br><br>Sofern keine Fehler aufgetreten sind ist die Installation abgescholssen.
			<br>Die Seite kann jetzt unter <a href="../index.php">hier Aufgerufen werden</a>.
			<br><br>Bitte unbedingt die install.php l&ouml;schen!</font>
   		</td>
	</tr>
</table>';

				} /* of hinzufügen */
				
		}; /* of sowieso bei add */
?>