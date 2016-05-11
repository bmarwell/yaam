<?php
require("config.php");

class cl_extended_database
{
    var $started = TRUE;
    var $debug = false;
    var $var_sql;
    var $var_result;
    var $var_error;
    var $var_errno;
    var $var_link;
    var $db_connected = TRUE;
    var $db_selected = TRUE;

	function cl_extended_database()
	{
        global $CONFIG;
        $this->connect($CONFIG["mysql"]["host"], $CONFIG["mysql"]["user"], $CONFIG["mysql"]["pass"]);
        $this->select_db($CONFIG["mysql"]["db"]);
    }


    // Registrierung erlauben?
    function getallow_register()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'Register'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }

     // Registrierung erlauben?
    function set_register($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'Register'");
        $this->err();
    }

    function set_ugruende($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'repl_grund'");
        $this->err();
    }

    //--------- Login abfrage ----------------//
    function user_get_id($nick)
    {
        global $CONFIG;
        $this->query("SELECT U_ID FROM ".$CONFIG['mysql']['prefix']."users WHERE U_Nick = '$nick'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['U_ID'];
        }
    }

    function user_get_mail($uid)
    {
        global $CONFIG;
        $this->query("SELECT U_Email FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$uid'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['U_Email'];
        }
    }

    function user_get_id_mail($email)
    {
        global $CONFIG;
        $this->query("SELECT U_ID FROM ".$CONFIG['mysql']['prefix']."users WHERE U_Email = '$email'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['U_ID'];
        }
    }

	function user_add($nick,$pass,$email)
	{
		global $CONFIG;
		$pass = md5($pass);
		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."users (`U_Nick`, `U_Email`, `U_Pass`, `U_LastChg`)
			VALUES ('$nick', '$email', '$pass', NOW()) ");

		$uid = $this->user_get_id($nick);

		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."forschung (`F_UID`)
			VALUES ('$uid') ");
		$this->err();
	}

	function user_delete($uid)
	{
		global $CONFIG;
		$userdel = new cl_extended_database;
		// Koordinaten:
		$userdel->query("SELECT K_KID FROM ".$CONFIG['mysql']['prefix']."koordinaten
			WHERE K_UID = '$uid'");
		$koords =  array();

		$ptr = 0;
		while ($row = $userdel->fetch())
		{
          $koords[$ptr] = $row['K_KID'];
          $ptr++;
      }

		foreach ($koords as $k)
		{
			// Den Ausbau...
			$userdel->query("DELETE FROM ".$CONFIG['mysql']['prefix']."ausbau
				WHERE A_KID = '$k'");
			// Den Ausbau...
			$userdel->query("DELETE FROM ".$CONFIG['mysql']['prefix']."schiffe
				WHERE S_KID = '$k'");
		}

		// Jetzt die koordinaten...
		$userdel->query("DELETE FROM ".$CONFIG['mysql']['prefix']."koordinaten
			WHERE K_UID = '$uid'");
		// Dann den Spieler selbst...
		$userdel->query("DELETE FROM ".$CONFIG['mysql']['prefix']."users
			WHERE U_ID = '$uid'");
		// Seinen Dauerurlaub weg...
		$userdel->query("DELETE FROM ".$CONFIG['mysql']['prefix']."vacation
			WHERE V_UID = '$uid'");
		// Forschung
		$userdel->query("DELETE FROM ".$CONFIG['mysql']['prefix']."forschung
			WHERE F_UID = '$uid'");

		$userdel->err();

		$userdel->dbclose();
		unset($userdel);
	}

	function user_get_pass($id)
	{
		global $CONFIG;
		$this->query("SELECT U_Pass FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$id'");
		$this->err();
		if ($this->numrows() <= 0)
		{
			return "[unbekannt - nicht gefunden]";
		}
		else
		{
			$row = $this->fetch();
			return $row['U_Pass'];
		}
	}

    function change_pw($id, $md5pw)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."users SET U_Pass = '$md5pw' WHERE U_ID = '$id'");
        $this->err();
    }

    function user_get_name($id)
    {
        global $CONFIG;
        $this->query("SELECT U_Nick FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$id'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return "[unbekannt - nicht gefunden]";
        }
        else
        {
            $row = $this->fetch();
            return $row['U_Nick'];
        }
    }

	function get_allusersNick()
	{
		global $CONFIG;
		$userlist = new cl_extended_database;
		$userlist->query("SELECT U_ID, U_Nick FROM ".$CONFIG['mysql']['prefix']."users");
		$userlist->err();
		$ret = array();
		$ptr = 0;
		while ($row = $userlist->fetch())
		{
          $ret[$ptr] = $row['U_ID'];
		  $ret[$ptr.'nick']= $row['U_Nick'];
          $ptr++;
      }
		$userlist->dbclose();
		unset($userlist);
      return $ret;
	}
	
	function get_allusers()
	{
		global $CONFIG;
		$userlist = new cl_extended_database;
		$userlist->query("SELECT U_ID FROM ".$CONFIG['mysql']['prefix']."users");
		$userlist->err();
		$ret = array();
		$ptr = 0;
		while ($row = $userlist->fetch())
		{
          $ret[$ptr] = $row['U_ID'];
          $ptr++;
      }
		$userlist->dbclose();
		unset($userlist);
      return $ret;
	}	

	function get_allusersCoordinates()
	{
		global $CONFIG;
		$userlist = new cl_extended_database;
		$userlist->query("SELECT k_koord, k_uid FROM ".$CONFIG['mysql']['prefix']."koordinaten");
		$userlist->err();
		$ret = array();
		$ptr = 0;
		while ($row = $userlist->fetch())
		{
          $ret[$ptr] = $row['k_koord'];
          $ret[$ptr.'uid'] = $row['k_uid'];
          $ptr++;
      }
		$userlist->dbclose();
		unset($userlist);
      return $ret;
	}
	// -- andere interessante user-abfragen -- //

    function rechte($id)
    {
        global $CONFIG;
        $this->query("SELECT U_Rechte FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$id'");
        $this->err();
		$row = $this->fetch();
		return $row['U_Rechte'];
	}

	function set_rechte($uid, $rechte)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."users SET U_Rechte = '$rechte' WHERE U_ID = '$uid'");
        $this->err();
	}

    function set_wprod($uid, $wprod)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."users SET U_Wprod = '$wprod' WHERE U_ID = '$uid'");
        $this->err();
	}

    function get_wprod($uid)
    {
        global $CONFIG;
        $this->query("SELECT U_Wprod FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$uid'");
        $this->err();
		$row = $this->fetch();
		return $row['U_Wprod'];
	}
    
	function set_tag($uid, $tag)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."users SET U_Tag = '$tag' WHERE U_ID = '$uid'");
        $this->err();
	}

    function get_tag($uid)
    {
        global $CONFIG;
        $this->query("SELECT U_Tag FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$uid'");
        $this->err();
		$row = $this->fetch();
		return $row['U_Tag'];
	}

	// -- allgemeine Funktionen -- //

	function news_from_admin()
   {
      global $CONFIG;
		$db_news_from_admin = new cl_extended_database;
      $db_news_from_admin->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."news n, ".$CONFIG['mysql']['prefix']."users u WHERE n.N_UID = u.U_ID ORDER BY N_NID");
      $db_news_from_admin->err();
      $ret = array();
      $ptr = 0;
      while ($row = $db_news_from_admin->fetch())
      {
          $ret[$ptr]['nick'] = $row['U_Nick'];
          $ret[$ptr]['timestamp'] = $row['N_timestamp'];
          $ret[$ptr]['text'] = $row['N_Text'];
          $ret[$ptr]['id'] = $row['N_NID'];
          $ptr++;
      }
      $db_news_from_admin->dbclose();
      unset($db_news_from_admin);
      $ret = array_reverse($ret);
      return $ret;
	}

	function news_add($text, $uid)
	{
		global $CONFIG;
		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."news (`N_UID`, `N_Text`, `N_timestamp`)
			VALUES ('$uid', '$text', NOW())");
		$this->query("OPTIMIZE TABLE ".$CONFIG['mysql']['prefix']."news");
		$this->err();
	}

	function news_delete($nid)
	{
		global $CONFIG;
		$this->query("DElETE FROM ".$CONFIG['mysql']['prefix']."news WHERE N_NID = '$nid'");
		$this->err();
	}

	//--- Wichtige DB--Funktionen -----//
    function __construct()
    {
        global $CONFIG;
        $this->connect($CONFIG["mysql"]["host"], $CONFIG["mysql"]["user"], $CONFIG["mysql"]["pass"]);
        $this->select_db($CONFIG["mysql"]["db"]);
    }


    function __destruct()
    {
        if ($this->debug) {
            echo "cl_database::__destruct();<br>";
        }
        @mysql_free_result($this->var_result);
        @mysql_close($this->var_link);
    }

    function dbclose()
    {
        $this->__destruct();
    }

	 function connect($host, $user, $password)
    {
        if ($this->debug) {
            echo "cl_database::connect('$host','$user','$password');<br>";
        }
        $this->var_link = mysql_connect($host, $user, $password);
        $this->db_connected = true;
    }

    function select_db($db)
    {
        if ($this->debug) {
            echo "cl_database::select_db();<br>";
        }
        $db_sel = mysql_select_db($db, $this->var_link);
        if (!$db_sel) {
            $this->var_sql = "SELECT DB '$db';";
            $this->var_error = mysql_error($this->var_link);
            $this->var_errno = mysql_errno($this->var_link);
            $this->var_result = false; //this->error() == true;
        } else {
            $this->var_sql = "SELECT DB '$db';";
            $this->var_result = true; //this->error() == false;
        }
        $this->db_selected = !$this->var_result;
    }

    function query($sql)
    {
        if ($this->debug) {
            echo "cl_database::query('$sql');<br>";
        }
        $db_query = new cl_extended_database;

        $this->var_sql = trim($sql);
        $this->var_result = mysql_query($this->var_sql, $db_query->var_link);

        if (!$this->var_result) {
            $this->var_errno = mysql_errno($db_query->var_link);
            $this->var_error = mysql_error($db_query->var_link);
        }
        unset($db_query);
    }


    //----------- Sonstige Nebenfunktionen-------//
    function err()
    {
        if ($this->debug) {
            echo "cl_database::err();<br>";
        }
        if ($this->error()) {
            echo $this->geterror();
        }
    }

    function error()
    {
        if ($this->debug) {
            echo "cl_database::error();<br>";
        }

        $tmp = $this->var_result;
        $tmp = (bool)$tmp;
        $tmp = !$tmp;
        return $tmp;
    }

    function fetch()
    {
        if ($this->debug)
		{
            echo "cl_database::fetch();<br>";
        }
        if ($this->error())
		{
            echo "<br>\nEs trat ein Fehler auf. Bitte überprüfen sie ihr MySQL-Query.\n<br>";
            $return = null;
        }
		else
		{
            $return = mysql_fetch_array($this->var_result);
        }
        return $return;
    }

    function geterror()
    {
        if ($this->debug) {
            echo "cl_database::geterror();<br>";
        }
        if ($this->error()) {
            $str = "<br>\n";
            $str .= "Query: <b>" . $this->var_sql . "</b><br>\n";
            $str .= "Error: <b>" . $this->var_error . "</b><br>\n";
            $str .= "Error Number: <b>" . $this->var_errno . "</b><br>\n";
        } else {
            $str = "Error: No Error!<br>";
        }
        return $str;
    }

    function numrows()
    {
        if ($this->debug) {
            echo "cl_database::numrows();<br>";
        }
        if ($this->error()) {
            $return = -1;
        } else {
            $return = mysql_num_rows($this->var_result);
        }
        return $return;
    }

    function reinit()
    {
        $this->__destruct();
        $this->__construct();
    }

 	/*
 	** Alles eigene Funktionen von [RdW]Sentinel
 	** Bitte nicht ohne Veröffentlichung benutzen!
 	**
 	**	Wer Fehler findet, darf diese mir per Mail
 	** melden: Sentinel (at) RdW-Allianz punkt de
 	**
 	**	Viel Spaß mit dem Script!
 	*/

	//--------- Koords von spieler auslesen --------//
   function sql_koords($uid)
	{
		global $CONFIG;
      $db_koords = new cl_extended_database;
      $db_koords->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_UID='$uid';");
      $db_koords->err();
      $ret = array();
      $ptr = 0;
      while ($row = $db_koords->fetch())
      {
         $ret[$ptr]['koord'] = $row['K_Koord'];
         $ret[$ptr]['kid'] = $row['K_KID'];
      	$ptr++;
      }
      $db_koords->dbclose();
      unset($db_koords);

      $i = 0;
      // Galas ordnen
   	while ($i < count($ret) )
      {
      	if ($i == 0)
      		$i++;
      	elseif ((int)substr($ret[$i-1]['koord'], 0, strpos($ret[$i-1]['koord'], ':') ) <= (int)substr($ret[$i]['koord'], 0, strpos($ret[$i]['koord'], ':')  ) )
			{
				$i++;
			}
   		else
      	{
				$temp = $ret[$i];
				$ret[$i] = $ret[$i-1];
				$ret[$i-1] = $temp;
				$i--;
			}
		}

 		$i = 0;
   	while ($i < count($ret) )
      {
      	if ($i == 0)
      		$i++;
      	elseif ((int)substr($ret[$i-1]['koord'], 0, strpos($ret[$i-1]['koord'], ':') ) == (int)substr($ret[$i]['koord'], 0, strpos($ret[$i]['koord'], ':')  ) )
				if (substr($ret[$i-1]['koord'], strpos($ret[$i-1]['koord'], ':') + 1, strrpos($ret[$i-1]['koord'], ':') - strpos($ret[$i-1]['koord'], ':') -1  ) <= substr($ret[$i]['koord'], strpos($ret[$i]['koord'], ':') + 1, strrpos($ret[$i]['koord'], ':') - strpos($ret[$i]['koord'], ':') -1 ) )
					$i++;
				else
		   	{
					$temp = $ret[$i];
					$ret[$i] = $ret[$i-1];
					$ret[$i-1] = $temp;
					$i--;
				}
			else
				$i++;
		}

		$i = 0;
   	while ($i < count($ret) )
      {
      	if ($i == 0)
      		$i++;
      	// Galas? gleich?
      	elseif ((int)substr($ret[$i-1]['koord'], 0, strpos($ret[$i-1]['koord'], ':') ) == (int)substr($ret[$i]['koord'], 0, strpos($ret[$i]['koord'], ':')  ) )
      		// Systeme gleich?
				if ((int)substr($ret[$i-1]['koord'], strpos($ret[$i-1]['koord'], ':') + 1, strrpos($ret[$i-1]['koord'], ':') - strpos($ret[$i-1]['koord'], ':') -1  ) == (int)substr($ret[$i]['koord'], strpos($ret[$i]['koord'], ':') + 1, strrpos($ret[$i]['koord'], ':') - strpos($ret[$i]['koord'], ':') -1 ) )
					// Planeten geordnet?
					if ( substr($ret[$i-1]['koord'], strrpos($ret[$i-1]['koord'], ':') + 1, strlen($ret[$i-1]['koord']) - 1 ) <= substr($ret[$i]['koord'], strrpos($ret[$i]['koord'], ':') + 1, strlen($ret[$i]['koord']) - 1 ) )
						$i++;
					else // planeten eines ss ungeordnet
					{
						$temp = $ret[$i];
						$ret[$i] = $ret[$i-1];
						$ret[$i-1] = $temp;
						$i--;
					}
				else // Wir sind nicht im gleichen sys
					$i++;
			else // nichtmal die richtige gala
				$i++;
		}


	return $ret;
	}

    // ------ Koordinate finden ----- //
	function find_koords($koordinate)
    {
        global $CONFIG;
        $this->query("SELECT K_Koord FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_KOORD = '$koordinate'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['K_Koord'];
        }
    }

    // ------ Koordinate finden ----- //
	function get_koord($kid)
    {
        global $CONFIG;
        $this->query("SELECT K_Koord FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_KID = '$kid'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['K_Koord'];
        }
    }

    // ------ Koordinate finden ----- //
	function get_uid($kid)
    {
        global $CONFIG;
        $this->query("SELECT K_UID FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_KID = '$kid'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['K_UID'];
        }
    }

   // ------ Spieler zu Koordinate finden ----- //
	function finde_besitzer($koordinate)
    {
        global $CONFIG;
        $this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."koordinaten k, ".$CONFIG['mysql']['prefix']."users u WHERE u.U_ID = k.K_UID AND k.K_KOORD = '$koordinate'");
        $this->err();
        if ($this->numrows() <= 0)
        {
            return -1;
        }
        else
        {
            $row = $this->fetch();
            return $row['U_Nick'];
        }
    }

   // ------ Koordinaten hinzufügen ----- //
	function add_koord($koordinate, $uid)
	{
   	global $CONFIG;
   	// Koordinate mit user verknüpfen
      $this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."koordinaten (`K_UID`, `K_Koord`)
      				VALUES('$uid','$koordinate')");
      $this->err();

      // K_KID kriegen
      $this->query("SELECT K_KID FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_Koord = '$koordinate'");
      $row = $this->fetch();
      $kid = $row['K_KID'];

      // Schiffe auf 0 setzen
      $this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."schiffe (`S_KID`)
      				VALUES('$kid')");
      // ausbau auf 0 setzen...
      $this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."ausbau (`A_KID`)
      				VALUES('$kid')");
      $this->err();
      $this->update_time($uid);
   }
   
	function add_koordOnly($koordinate, $uid)
	{
	  global $CONFIG;
      $this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."koordinaten (`K_UID`, `K_Koord`)
      				VALUES('$uid','$koordinate')");
      $this->update_time($uid);
   }   

   // ----- Planet löschen ---- //

   function del_koord($koordinate)
	{
		global $CONFIG;
		$uid = $this->query("SELECT K_UID FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_KID = '$koordinate'");
		$this->query("DELETE FROM ".$CONFIG['mysql']['prefix']."schiffe WHERE S_KID = (SELECT K_KID FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_Koord = '$koordinate')");
		$this->query("DELETE FROM ".$CONFIG['mysql']['prefix']."ausbau WHERE A_KID = (SELECT K_KID FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_Koord = '$koordinate')");
		$this->query("DELETE FROM ".$CONFIG['mysql']['prefix']."koordinaten WHERE K_Koord = '$koordinate'");
		$this->query("OPTIMIZE TABLE ".$CONFIG['mysql']['prefix']."schiffe");
		$this->query("OPTIMIZE TABLE ".$CONFIG['mysql']['prefix']."ausbau");
		$this->query("OPTIMIZE TABLE ".$CONFIG['mysql']['prefix']."koordinaten");
		$this->err();
      $this->update_time($uid);
   }

   // ---- ausbau ermitteln --- //
   function ausbau($kid)
	{
		global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."ausbau WHERE A_KID = '$kid'");
		$this->err();

		$row = $this->fetch();
      $ausbau['KZ'] = $row['A_KZ'];
      $ausbau['FZ'] = $row['A_FZ'];
      $ausbau['FeMine'] = $row['A_FeMine'];
		$ausbau['LutRaff'] = $row['A_LutRaff'];
		$ausbau['Bohr'] = $row['A_Bohr'];
		$ausbau['Chem'] = $row['A_Chem'];
		$ausbau['ErwChem'] = $row['A_ErwChem'];
		$ausbau['FeSpeicher'] = $row['A_FeSpeicher'];
		$ausbau['LutSpeicher'] = $row['A_LutSpeicher'];
		$ausbau['WasSpeicher'] = $row['A_WasSpeicher'];
		$ausbau['H2Speicher'] = $row['A_H2Speicher'];
		$ausbau['SF'] = $row['A_SF'];
		$ausbau['OV'] = $row['A_OV'];
		$ausbau['Fusi'] = $row['A_Fusi'];
		$ausbau['Schild'] = $row['A_Schild'];

      return $ausbau;
   }

   // ---- flotte ermitteln --- //
   function flotte($kid)
	{
		global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."schiffe WHERE S_KID = '$kid'");
		$this->err();

		$row = $this->fetch();
      $flotte['Sonden'] = $row['S_Sonden'];
	  $flotte['Recycler'] = $row['S_Recycler'];
      $flotte['Tjugar'] = $row['S_Tjugar'];
      $flotte['Cougar'] = $row['S_Cougar'];
		$flotte['LeV'] = $row['S_LeV'];
		$flotte['Noah'] = $row['S_Noah'];
		$flotte['LeX'] = $row['S_LeX'];
        $flotte['Schakal'] = $row['S_Schakal'];
	  $flotte['Rene'] = $row['S_Rene'];
      $flotte['Raid'] = $row['S_Raid'];
      $flotte['Tarn'] = $row['S_Tarn'];
		$flotte['Kolo'] = $row['S_Kolo'];
		$flotte['Klein'] = $row['S_Klein'];
		$flotte['Gross'] = $row['S_Gross'];
      return $flotte;
   }

   // ---- flotte ermitteln --- //
   function flotte_user($uid)
	{
		global $CONFIG;
		$this->query("SELECT sum(S_Sonden), sum(S_Recycler), sum(S_Tjugar), sum(S_Cougar), sum(S_LeV), sum(S_Noah), sum(S_LeX), sum(S_Schakal), sum(S_Rene), sum(S_Raid), sum(S_Tarn), sum(S_Kolo), sum(S_Klein), sum(S_Gross) FROM ".$CONFIG['mysql']['prefix']."koordinaten k, ".$CONFIG['mysql']['prefix']."schiffe s WHERE s.S_KID = k.K_KID AND k.K_UID = '$uid'");
		$this->err();

		$row = $this->fetch();
      $flotte['Sonden'] = $row['sum(S_Sonden)'];
	  $flotte['Recycler'] = $row['sum(S_Recycler)'];
      $flotte['Tjugar'] = $row['sum(S_Tjugar)'];
      $flotte['Cougar'] = $row['sum(S_Cougar)'];
		$flotte['LeV'] = $row['sum(S_LeV)'];
		$flotte['Noah'] = $row['sum(S_Noah)'];
		$flotte['LeX'] = $row['sum(S_LeX)'];
       $flotte['Schakal'] = $row['sum(S_Schakal)'];
	  $flotte['Rene'] = $row['sum(S_Rene)'];
      $flotte['Raid'] = $row['sum(S_Raid)'];
      $flotte['Tarn'] = $row['sum(S_Tarn)'];
		$flotte['Kolo'] = $row['sum(S_Kolo)'];
		$flotte['Klein'] = $row['sum(S_Klein)'];
		$flotte['Gross'] = $row['sum(S_Gross)'];
		
      return $flotte;
   }


   // ---- forschung ermitteln --- //
   function forschung($uid)
	{
		global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."forschung WHERE F_UID = '$uid'");
		$this->err();

		$row = $this->fetch();
      $forschung['VbA'] = $row['F_VbA'];
      $forschung['IoA'] = $row['F_IoA'];
      $forschung['RkA'] = $row['F_RkA'];
      $forschung['RfA'] = $row['F_RfA'];
		$forschung['Ionis'] = $row['F_Ionis'];
		$forschung['Energ'] = $row['F_Energ'];
		$forschung['Explo'] = $row['F_Explo'];
		$forschung['Spio'] = $row['F_Spio'];
		$forschung['Panzer'] = $row['F_Panzer'];
		$forschung['LadeKapa'] = $row['F_LadeKapa'];
		$forschung['Recycler'] = $row['F_Recycler'];

      return $forschung;
   }

   // -- Forschung ändern -- //
  function forschung_add($uid, $VbA, $IoA, $RkA, $RfA, $Ionis, $Energ, $Explo, $Spio, $Panzer, $LadeKapa, $Recycler)
	{
		global $CONFIG;
		$this->query("UPDATE ".$CONFIG['mysql']['prefix']."forschung SET `F_VbA` = '$VbA',
			`F_IoA` = '$IoA',
			`F_RkA` = '$RkA',
			`F_RfA` = '$RfA',
			`F_Ionis` = '$Ionis',
			`F_Energ` = '$Energ',
			`F_Explo` = '$Explo',
			`F_Spio` = '$Spio',
			`F_Panzer` = '$Panzer',
			`F_LadeKapa` = '$LadeKapa',
			`F_Recycler` = '$Recycler'
			WHERE F_UID = '$uid'");
		$this->err();
		$this->update_time($uid);
	}


   // -- Flotte ändern -- //
   function flotte_add($kid, $Sonden, $Recycler, $Tjugar, $Cougar, $LeV, $Noah, $LeX, $Schakal, $Rene, $Raid, $Tarn, $Kolo, $Klein, $Gross)
	{
		global $CONFIG;
		$this->query("UPDATE ".$CONFIG['mysql']['prefix']."schiffe SET `S_Sonden` = '$Sonden',
			`S_Recycler` = '$Recycler',
			`S_Tjugar` = '$Tjugar',
			`S_Cougar` = '$Cougar',
			`S_LeV` = '$LeV',
			`S_Noah` = '$Noah',
			`S_LeX` = '$LeX',
			`S_Schakal` = '$Schakal',
			`S_Rene` = '$Rene',
			`S_Raid` = '$Raid',
			`S_Tarn` = '$Tarn',
			`S_Kolo` = '$Kolo',
			`S_Klein` = '$Klein',
			`S_Gross` = '$Gross'
			WHERE S_KID = '$kid'");
		$this->err();
		$this->update_time($this->get_uid($kid));
	}

   // -- Ausbau ändern -- //
   function ausbau_add($kid, $KZ, $FZ, $FeMine, $LutRaff, $Bohr, $Chem, $ErwChem, $FeSpeicher, $LutSpeicher, $WasSpeicher, $H2Speicher, $SF, $OV, $Schild, $Fusi)
	{
		global $CONFIG;
		$uid = $this->get_uid($kid);

		$this->query("UPDATE ".$CONFIG['mysql']['prefix']."ausbau SET `A_KZ` = '$KZ',
			`A_FZ` = '$FZ',
			`A_FeMine` = '$FeMine',
			`A_LutRaff` = '$LutRaff',
			`A_Bohr` = '$Bohr',
			`A_Chem` = '$Chem',
			`A_ErwChem` = '$ErwChem',
			`A_FeSpeicher` = '$FeSpeicher',
			`A_LutSpeicher` = '$LutSpeicher',
			`A_WasSpeicher` = '$WasSpeicher',
			`A_H2Speicher` = '$H2Speicher',
			`A_SF` = '$SF',
			`A_OV` = '$OV',
			`A_Schild` = '$Schild',
			`A_Fusi` = '$Fusi'
			WHERE A_KID = '$kid'");
		$this->err();
		$this->update_time($uid);
	}

	// -- Urlaub löschen -- //
   function urlaub_del($uid)
	{
		global $CONFIG;

		$this->query("DELETE FROM ".$CONFIG['mysql']['prefix']."vacation WHERE V_UID = '$uid'");
		$this->err();

		$this->update_time($uid);
   }

	// -- Urlaub hinzufügen -- //
   function urlaub_add($uid, $start, $ende, $sitter, $grund)
	{
		global $CONFIG;

		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."vacation (`V_UID`, `V_Start`, `V_Ende`, `V_Sitter`, `V_Grund`) VALUES ('$uid', '$start', '$ende', '$sitter', '$grund')");
		$this->err();

		$this->update_time($uid);

	}

	// -- Urlaub auslesen... faule Sau! -- //
	function urlaub_read($uid)
	{
		global $CONFIG;

		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."vacation WHERE V_UID = '$uid'");
		$this->err();

		$row = $this->fetch();
      $urlaub['Sitter'] = $row['V_Sitter'];
      $urlaub['Start'] = $row['V_Start'];
      $urlaub['Ende'] = $row['V_Ende'];
      $urlaub['Grund'] = $row['V_Grund'];

      return $urlaub;
	}

	// Grund bei nichtexistenz ersetzen?
	function get_v_grund()
	{
		global $CONFIG;

		$this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'repl_grund'");
		$this->err();

		$row = $this->fetch();
      return $row['Set_Value'];
	}

   // Grund auslesen
	function getrandgrund()
	{
		global $CONFIG;
		require_once("ugruende.inc.php");
		srand((double)microtime() * 1000000);

		return $ugruende[ rand(0, count($ugruende)-1) ];
	}

	function get_LastChg($uid)
	{
		global $CONFIG;
		$this->query("SELECT U_LastChg FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$uid'");
		$this->err();

		$row = $this->fetch();
		return $row['U_LastChg'];
	}

	//-- Update profile --//
	function update_time($uid)
	{
		global $CONFIG;
		$this->query("UPDATE ".$CONFIG['mysql']['prefix']."users SET `U_LastChg` = NOW( ) WHERE `U_ID` = '$uid'");

		$this->err();
  	}



	/*
	Aenderungen durch JabbaTheHood
	*/

	// KB eintragen
	function kb_add($uploader, $dateadd, $datedone, $plania, $schakala1, $schakala2, $recyca1, $recyca2, $spioa1, $spioa2, $renea1, $renea2, $raida1, $raida2, $tarna1, $tarna2, $koloa1, $koloa2, $tjuga1, $tjuga2, $couga1, $couga2, $leva1, $leva2, $kleina1, $kleina2, $grossa1, $grossa2, $noaha1, $noaha2, $lexa1, $lexa2, $planid, $schakald1, $schakald2, $recycd1, $recycd2, $spiod1, $spiod2, $rened1, $rened2, $raidd1, $raidd2, $tarnd1, $tarnd2, $kolod1, $kolod2, $tjugd1, $tjugd2, $cougd1, $cougd2, $levd1, $levd2, $kleind1, $kleind2, $grossd1, $grossd2, $noahd1, $noahd2, $lexd1, $lexd2, $leichtd1, $leichtd2, $laserd1, $laserd2, $empd1, $empd2, $plasmad1, $plasmad2, $raksd1, $raksd2, $eisen, $lutinum, $wasser, $wasserstoff, $ckk, $ressis)
	{
	   	global $CONFIG;
	    $this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."kbs
						(`KB_UPLOADER`, `KB_DATEADD`, `KB_DATEDONE`, `KB_PLANIA`, `KB_SCHAKALA1`, `KB_SCHAKALA2`, `KB_RECYCA1`, `KB_RECYCA2`, `KB_SPIOA1`, `KB_SPIOA2`, `KB_RENEA1`, `KB_RENEA2`, `KB_RAIDA1`, `KB_RAIDA2`, `KB_TARNA1`, `KB_TARNA2`, `KB_KOLOA1`, `KB_KOLOA2`, `KB_TJUGA1`, `KB_TJUGA2`, `KB_COUGA1`, `KB_COUGA2`, `KB_LEVA1`, `KB_LEVA2`, `KB_KLEINA1`, `KB_KLEINA2`, `KB_GROSSA1`, `KB_GROSSA2`, `KB_NOAHA1`, `KB_NOAHA2`, `KB_LEXA1`, `KB_LEXA2`, `KB_PLANID`, `KB_SCHAKALD1`, `KB_SCHAKALD2`, `KB_RECYCD1`, `KB_RECYCD2`, `KB_SPIOD1`, `KB_SPIOD2`, `KB_RENED1`, `KB_RENED2`, `KB_RAIDD1`, `KB_RAIDD2`, `KB_TARND1`, `KB_TARND2`, `KB_KOLOD1`, `KB_KOLOD2`, `KB_TJUGD1`, `KB_TJUGD2`, `KB_COUGD1`, `KB_COUGD2`, `KB_LEVD1`, `KB_LEVD2`, `KB_KLEIND1`, `KB_KLEIND2`, `KB_GROSSD1`, `KB_GROSSD2`, `KB_NOAHD1`, `KB_NOAHD2`, `KB_LEXD1`, `KB_LEXD2`, `KB_LEICHTD1`, `KB_LEICHTD2`, `KB_LASERD1`, `KB_LASERD2`, `KB_EMPD1`, `KB_EMPD2`, `KB_PLASMAD1`, `KB_PLASMAD2`, `KB_RAKSD1`, `KB_RAKSD2`, `KB_EISEN`, `KB_LUTINUM`, `KB_WASSER`, `KB_WASSERSTOFF`, `KB_CKK`, `KB_RESSIS`)
	      				VALUES('$uploader','$dateadd', '$datedone', '$plania', '$schakala1', '$schakala2',  '$recyca1', '$recyca2', '$spioa1', '$spioa2', '$renea1', '$renea2', '$raida1', '$raida2', '$tarna1', '$tarna2', '$koloa1', '$koloa2', '$tjuga1', '$tjuga2', '$couga1', '$couga2', '$leva1', '$leva2', '$kleina1', '$kleina2', '$grossa1', '$grossa2', '$noaha1', '$noaha2', '$lexa1', '$lexa2', '$planid', '$schakald1', '$schakald2', '$recycd1', '$recycd2', '$spiod1', '$spiod2', '$rened1', '$rened2', '$raidd1', '$raidd2', '$tarnd1', '$tarnd2', '$kolod1', '$kolod2', '$tjugd1', '$tjugd2', '$cougd1', '$cougd2', '$levd1', '$levd2', '$kleind1', '$kleind2', '$grossd1', '$grossd2', '$noahd1', '$noahd2', '$lexd1', '$lexd2', '$leichtd1', '$leichtd2', '$laserd1', '$laserd2', '$empd1', '$empd2', '$plasmad1', '$plasmad2', '$raksd1', '$raksd2', '$eisen', '$lutinum', '$wasser', '$wasserstoff', '$ckk', '$ressis')");

		$this->query("SELECT MAX(KB_ID) as KB_ID FROM ".$CONFIG['mysql']['prefix']."kbs");
		$row = $this->fetch();

	    $this->err();
		return $row['KB_ID'];
	}

	// Kb-ID ermitteln
	function kb_get($kbid)
	{
		global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."kbs WHERE KB_ID='$kbid'");
		$row = $this->fetch();
	    $this->err();
		return $row;
	}

	// Top10 CKK
	function kb_topckk()
	{
		global $CONFIG;
		$this->query("SELECT KB_ID, KB_UPLOADER, KB_DATEDONE, KB_CKK FROM ".$CONFIG['mysql']['prefix']."kbs ORDER BY KB_CKK DESC LIMIT 5");
		$row = $this->fetch_all();
	    $this->err();
		return $row;
	}

	// Top10 Ressis
	function kb_topress()
	{
		global $CONFIG;
		$this->query("SELECT KB_ID, KB_UPLOADER, KB_DATEDONE, KB_RESSIS FROM ".$CONFIG['mysql']['prefix']."kbs ORDER BY KB_RESSIS DESC LIMIT 5");
		$row = $this->fetch_all();
	    $this->err();
		return $row;
	}

	// noch nicht funktionsfaehig! (solle evt. beim Loeschen eines Users ausgefuehrt werden)
	function kb_delete($user)
	{
		global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."kbs WHERE KB_UPLOADER='$user'");
	}

	// Komplette Tabelle auslesen
	function fetch_all() {
		$return="";
		while($row=mysql_fetch_array($this->var_result)) {
	       $return[] = $row;
		}
		$this->err();
		return $return;
	}

	// Spielerliste auslesen fuer Inaktivenliste
	function get_inaktive() {
		global $CONFIG;
		$this->query("DELETE FROM ".$CONFIG['mysql']['prefix']."inaktive WHERE `IA_FIRST`=0 AND `IA_SECOND`=0");
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."inaktive WHERE 1");
		$row = $this->fetch_all();
		$this->err();
		return $row;
	}

	// Spielerliste aktualisieren fuer Inaktivenliste
	function change_inaktive($user, $punkte) {
		global $CONFIG;
		$this->query("DELETE FROM ".$CONFIG['mysql']['prefix']."inaktive WHERE `IA_NAME`='$user';");
		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."inaktive (`IA_NAME`, `IA_FIRST`, `IA_SECOND`) VALUES ('$user','$punkte', 0)");
		$this->err();
	}

	function add_inaktive($user, $punkte) {
		global $CONFIG;
		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."inaktive (`IA_NAME`, `IA_SECOND`) VALUES ('$user','$punkte')");
		if ($this->error())	$this->query("UPDATE ".$CONFIG['mysql']['prefix']."inaktive SET `IA_SECOND`=$punkte WHERE `IA_NAME`='$user'");
		$this->err();
	}

	// Uni9 - Funktionen aktivieren?
    function set_u9($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'Uni9'");
        $this->err();
    }

	// Uni9 - Funktionen ändern
    function get_u9()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'Uni9'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }

	/*
	Aenderungen durch Airnight
	*/
    // Pro_Alli - Funktionen aktivieren?
    function set_proa($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'Pro_Alli'");
        $this->err();
    }

	// Pro_Alli - Funktionen ändern
    function get_proa()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'Pro_Alli'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // Pro_Erster - Funktionen aktivieren?
    function set_pro1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'Pro_Erster'");
        $this->err();
    }

	// Pro_Erster - Funktionen ändern
    function get_pro1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'Pro_Erster'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // CKK - Funktionen aktivieren?
    function set_ckk($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'CKK'");
        $this->err();
    }

	// CKK - Funktionen ändern
    function get_ckk()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'CKK'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // ECKK - Funktionen aktivieren?
    function set_eckk($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'ECKK'");
        $this->err();
    }

	// ECKK - Funktionen ändern
    function get_eckk()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'ECKK'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // FCKK - Funktionen aktivieren?
    function set_fckk($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'FCKK'");
        $this->err();
    }

	// FCKK - Funktionen ändern
    function get_fckk()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'FCKK'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // FECKK - Funktionen aktivieren?
    function set_feckk($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'FECKK'");
        $this->err();
    }

	// FECKK - Funktionen ändern
    function get_feckk()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'FECKK'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // FORSCH - Funktionen aktivieren?
    function set_forsch($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'FORSCH'");
        $this->err();
    }

	// FORSCH - Funktionen ändern
    function get_forsch()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'FORSCH'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // UPDATE - Funktionen aktivieren?
    function set_update($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'UPDATE'");
        $this->err();
    }

	// UPDATE - Funktionen ändern
    function get_update()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'UPDATE'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // LEV - Funktionen aktivieren?
    function set_lev($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'LEV'");
        $this->err();
    }
    // LEV - Funktionen ändern
    function get_lev()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'LEV'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // ausbau - Funktionen aktivieren?
    function set_aus($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'AUS'");
        $this->err();
    }
    // ausbau - Funktionen ändern
    function get_aus()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'AUS'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // Pro_Alli1 - Funktionen aktivieren?
    function set_proa1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'Pro_Alli1'");
        $this->err();
    }

	// Pro_Alli1 - Funktionen ändern
    function get_proa1()
    {
        global $CONFIG;                                                                                      
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'Pro_Alli1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // Pro_Erster1 - Funktionen aktivieren?
    function set_pro11($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'Pro_Erster1'");
        $this->err();
    }

	// Pro_Erster1 - Funktionen ändern
    function get_pro11()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'Pro_Erster1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // CKK1 - Funktionen aktivieren?
    function set_ckk1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'CKK1'");
        $this->err();
    }

	// CKK1 - Funktionen ändern
    function get_ckk1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'CKK1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // ECKK1 - Funktionen aktivieren?
    function set_eckk1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'ECKK1'");
        $this->err();
    }

	// ECKK1 - Funktionen ändern
    function get_eckk1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'ECKK1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // FCKK1 - Funktionen aktivieren?
    function set_fckk1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'FCKK1'");
        $this->err();
    }

	// FCKK1 - Funktionen ändern
    function get_fckk1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'FCKK1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // FECKK1 - Funktionen aktivieren?
    function set_feckk1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'FECKK1'");
        $this->err();
    }

	// FECKK1 - Funktionen ändern
    function get_feckk1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'FECKK1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // FORSCH1 - Funktionen aktivieren?
    function set_forsch1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'FORSCH1'");
        $this->err();
    }

	// FORSCH1 - Funktionen ändern
    function get_forsch1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'FORSCH1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // UPDATE1 - Funktionen aktivieren?
    function set_update1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'UPDATE1'");
        $this->err();
    }

	// UPDATE1 - Funktionen ändern
    function get_update1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'UPDATE1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // LEV1 - Funktionen aktivieren?
    function set_lev1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'LEV1'");
        $this->err();
    }

	// LEV1 - Funktionen ändern
    function get_lev1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'LEV1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
    // ausbau1 - Funktionen aktivieren?
    function set_aus1($bool)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."settings SET Set_Value = '$bool' WHERE Set_Name = 'AUS1'");
        $this->err();
    }

	// ausbau1 - Funktionen ändern
    function get_aus1()
    {
        global $CONFIG;
        $this->query("SELECT Set_Value FROM ".$CONFIG['mysql']['prefix']."settings WHERE Set_Name = 'AUS1'");
        $this->err();
        $row = $this->fetch();
        return $row['Set_Value'];
    }
	// Status Main/Wing auslesen
	function get_main($uid)
    {
        global $CONFIG;
        $this->query("SELECT U_Main FROM ".$CONFIG['mysql']['prefix']."users WHERE U_ID = '$uid'");
        $this->err();
		$row = $this->fetch();
		return $row['U_Main'];
	}

	function set_main($uid, $tag)
    {
        global $CONFIG;
        $this->query("UPDATE ".$CONFIG['mysql']['prefix']."users SET U_Main = '$tag' WHERE U_ID = '$uid'");
        $this->err();
	}
	
	function highscore_insertOrUpdate($name, $punkteFo, $punktePl, $anzPlani, $tag) {
		global $CONFIG;
		$this->query("DElETE FROM ".$CONFIG['mysql']['prefix']."highscore WHERE NAME = '$name'");
		
		$this->query("INSERT INTO ".$CONFIG['mysql']['prefix']."highscore (`name`, `punkteFo`, `punktePl`, `anzahlPl`, `tag`, `updatedate`) VALUES ('$name', $punkteFo, $punktePl, $anzPlani, '$tag',now())");
		$this->err();

	}

	function get_highscoreMemberWithTag($tag)
    {
        global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."highscore WHERE tag ='$tag'");
		$row = $this->fetch_all();
		$this->err();
		return $row;
	}
	
	function get_highscoreAnzahl()
    {
        global $CONFIG;
		$this->query("SELECT count(*) FROM ".$CONFIG['mysql']['prefix']."highscore");
		$row = $this->fetch_all();
		$this->err();
		return $row;
	}

	function get_inactiveHighscoreMember($name, $punkteFo, $punktePl)
    {
        global $CONFIG;
		$this->query("SELECT * FROM ".$CONFIG['mysql']['prefix']."highscore WHERE punkteFo=$punkteFo and punktePL=$punktePl and name='$name'");
		$row = $this->fetch_all();
		$this->err();
		return $row;
	}

}
?>