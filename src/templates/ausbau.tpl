<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

<form action="ausbau.php" method="post">


	<div align="center">
	<table width="50%">
		{if $changed == 1}
		<tr>
			<th colspan="2" style="color: #fec22f;">&Auml;nderungen erfolgreich &uuml;bernommen!</th>		
		</tr>
		{/if}
		{if $noint == 1 }
		<tr>
			<th colspan="2" style="color: #fec22f;">Das war keine g&uuml;ltige Seite!</th>		
		</tr>
		{/if}
		<tr>
			<th colspan="2"><b>Ausbaustatus f&uuml;r Planet: {$koord}</b></th>
		</tr>
		<tr>
			<th colspan="2">Hauptgeb&auml;ude</th>
		</tr>
		<tr>
			<td width="50%">Kommandozentrale:</td>
			<td width="50%"><input name="KZ" value="{$ausbau.KZ}" maxlength="3" size="15"></td>		
		</tr>	
		<tr>
			<td>Forschungszentrum:</td>
			<td><input name="FZ" value="{$ausbau.FZ}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<th colspan="2">Rohstoffgeb&auml;ude</th>
		</tr>
		<tr>
			<td>Eisenmine:</td>
			<td><input name="FeMine" value="{$ausbau.FeMine}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Siliziummine:</td>
			<td><input name="LutRaff" value="{$ausbau.LutRaff}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Bohrturm:</td>
			<td><input name="Bohr" value="{$ausbau.Bohr}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Chemiefabrik:</td>
			<td><input name="Chem" value="{$ausbau.Chem}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Erw. Chemiefabrik:</td>
			<td><input name="ErwChem" value="{$ausbau.ErwChem}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Eisenspeicher:</td>
			<td><input name="FeSpeicher" value="{$ausbau.FeSpeicher}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Siliziummspeicher:</td>
			<td><input name="LutSpeicher" value="{$ausbau.LutSpeicher}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>H<sub>2</sub>O-Speicher:</td>
			<td><input name="WasSpeicher" value="{$ausbau.WasSpeicher}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>H<sub>2</sub>-Speicher:</td>
			<td><input name="H2Speicher" value="{$ausbau.H2Speicher}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<th colspan="2">Verteidigung</th>
		</tr>
		<tr>
			<td>Schiffsfabrik:</td>
			<td><input name="SF" value="{$ausbau.SF}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Orbitale Verteidigung:</td>
			<td><input name="OV" value="{$ausbau.OV}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Planetarer Schild:</td>
			<td><input name="Schild" value="{$ausbau.Schild}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Fusionsreaktor:</td>
			<td><input name="Fusi" value="{$ausbau.Fusi}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td class="none">
				<input type="hidden" name="update">
				<input type="hidden" name="kid" value="{$kid}">
			</td>
			<td><input type="submit" value="&Auml;nderungen &uuml;bernehmen"></td>		
		</tr>
 	</table>
 	</div>
 
 </form>

<br clear="all" />

	<form method="post" action="ausbau.php">
	<div align="center">
	<table width="50%">
		<tr>
			<td colspan="2" align="center">
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="10" wrap="soft" name="ausbau_raw">Oder hier einfach die Seite reinkopieren und weiter unten abschicken.</textarea>			
			</td>		
		</tr>
		<tr>
			<td class="none" width="50%">
				<input type="hidden" name="update2" value="true">
				<input type="hidden" name="kid" value="{$kid}">			
			</td>
			<td width="50%"><input type="submit" value="Auslesen &amp; &uuml;bernehmen"></td>		
		</tr>
	</table>
	</div>
	
	</form>

		<br clear="all" />
	</body>
</html>
