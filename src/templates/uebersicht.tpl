<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script type="text/javascript" language="JavaScript">
		image9 = new Image;
		image9.src = "./bilder/navi/_ausbau2_on.png";
		image10 = new Image;
		image10.src = "./bilder/navi/_ausbau2.png";
		
		image13 = new Image;
		image13.src = "./bilder/navi/_flotten_on.png";
		image14 = new Image;
		image14.src = "./bilder/navi/_flotten.png";
		
		image15 = new Image;
		image15.src = "./bilder/navi/_uebersicht2_on.png";
		image16 = new Image;
		image16.src = "./bilder/navi/_uebersicht2.png";   
		
		image17 = new Image;
		image17.src = "./bilder/navi/_ressourcen_on.png";
		image18 = new Image;
		image18.src = "./bilder/navi/_ressourcen.png";  
   </script>
</head>

<body>

	<div align="center">
	<table width="90%">
		{$menu}
		<tr>
			<th colspan="5"><font size="4" color="yellow">Flotten&uuml;bersicht</font></th>		
		</tr>	
		<tr>
			<th colspan="2">Schiffstyp / Wertung</th>		
			<th colspan="1" align="center">Anzahl</th>
			<th align="center">Cougar Kampfkraft</th>
			<th colspan="1" align="center">eCKK</th>
		</tr>
		
		<tr>
			<td colspan="2">Sonde = 0,000262 ckk <br />{$eckk.Sonden} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.Sonden}</td>
			<td align="center"><br />{$fckk.Sonden}</td>
            <td colspan="1" align="center"><br />{$eeckk.Sonden}</td>		
		</tr>
		<tr>
			<td colspan="2">Recycler = 0,045291 ckk <br />{$eckk.Recycler} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.Recycler}</td>
			<td align="center"><br />{$fckk.Recycler}</td>
			<td colspan="1" align="center"><br />{$eeckk.Recycler}</td>
		</tr>
		<tr>
			<td colspan="2">Tjuger = 0,<span style="text-decoration: overline">3</span> ckk <br />{$eckk.Tjugar} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.Tjugar}</td>		
			<td align="center"><br />{$fckk.Tjugar}</td>
			<td colspan="1" align="center"><br />{$eeckk.Tjugar}</td>
		</tr>
		<tr>
			<td colspan="2">Cougar = 1 ckk <br />{$eckk.Cougar} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.Cougar}</td>	
			<td align="center"><br />{$fckk.Cougar}</td>
            <td colspan="1" align="center"><br />{$eeckk.Cougar}</td>	
		</tr>
		<tr>
			<td colspan="2">Longeagle V = 6 ckk <br />{$eckk.LeV} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.LeV}</td>	
			<td align="center"><br />{$fckk.LeV}</td>
            <td colspan="1" align="center"><br />{$eeckk.LeV}</td>	
		</tr>
		<tr>
			<td colspan="2">Noah = 1,3 ckk <br />{$eckk.Noah} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.Noah}</td>		
			<td align="center"><br />{$fckk.Noah}</td>
			<td colspan="1" align="center"><br />{$eeckk.Noah}</td>
		</tr>
		<tr>
			<td colspan="2">Longeagle X = 17,7 ckk <br />{$eckk.LeX} eckk</td>
			<td colspan="1" align="center"><br />{$fflotte.LeX}</td>	
			<td align="center"><br />{$fckk.LeX}</td>
            <td colspan="1" align="center"><br />{$eeckk.LeX}</td>	
		</tr>
		<tr>
			<td colspan="2">Rest<br /></td>
			<td colspan="1" align="center"><br />{$fflotte.Rest}</td>
			<td align="center"><br />{$fckk.Rest}</td>
            <td colspan="1" align="center"><br />{$eeckk.Rest}</td>
		</tr>
		<tr>
			<th colspan="2">Summe:</th>	
			<th colspan="1" align="center">{$fflotte.Summe} Schiffe</th>
			<th colspan="1" align="center">{$fckk.Summe} ckk</th>
			<th colspan="1" align="center">{$sumeckk} eckk</th>			
		</tr>	
		
		<tr><td colspan="5" class="none"></td></tr>
		
		<tr><th colspan="5"><font size="4" color="yellow"><br />Antriebsforschung</font></th></tr>
		<tr>
			<td width="25%">Verbrennungsantrieb:</td>
			<td colspan="2" align="center">{$forschung.VbA}</td>		
			<td width="25%">Ionenantrieb:</td>
			<td width="25%" align="center">{$forschung.IoA}</td>			
		</tr>
		<tr>
			<td width="25%">Raumkr&uuml;mmungsantrieb:</td>
			<td colspan="2" align="center">{$forschung.RkA}</td>		
			<td width="25%">Raumfaltungsantrieb:</td>
			<td width="25%" align="center">{$forschung.RfA}</td>			
		</tr>
		<tr><th colspan="5"><font size="4" color="yellow"><br />Waffenforschung</font></th></tr>
		<tr>
			<td width="25%">Ionisation:</td>
			<td colspan="2" align="center">{$forschung.Ionis}</td>		
			<td width="25%">Energieb&uuml;ndelung:</td>
			<td width="25%" align="center">{$forschung.Energ}</td>			
		</tr>		
		<tr>
			<td width="25%">Explosivgeschosse:</td>
			<td colspan="2" align="center">{$forschung.Explo}</td>		
			<td width="25%">Spionagetechnik:</td>
			<td width="25%" align="center">{$forschung.Spio}</td>			
		</tr>		
		<tr>
			<td width="25%">Schiffspanzerung:</td>
			<td colspan="2" align="center">{$forschung.Panzer}</td>		
			<td width="25%">Erh&ouml;hte Ladekapazit&auml;t:</td>
			<td width="25%" align="center">{$forschung.LadeKapa}</td>			
		</tr>	
		<tr>
			<td width="25%">Recyclingtechnik:</td>
			<td colspan="2" align="center">{$forschung.Recycler}</td>		
			<td width="25%" class="none"></td>
			<td width="25%" class="none"></td>			
		</tr>	
			
 	</table>
	<p><b><font color="yellow">Schiffsproduktion : {$prodlev} LEV / {$prodlex} LEX pro Tag <br />(theoretisch, wenn nur LEV / LEX produziert werden!)</font></b></p>
 	</div>
 
		<br clear="all" />
	</body>
</html>