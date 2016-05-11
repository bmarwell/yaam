<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>



    <form method="post" action="flotte.php">
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
			<th colspan="2"><b>Flottenstatus f&uuml;r Planet: {$koord}</b></th>
		</tr>
        <tr>
			<td colspan="2" align="center">
				<textarea cols="40" onfocus="this.value = ''" width="100%" rows="10" wrap="soft" name="flotte_raw">Oder hier einfach das FLOTTENMEN&Uuml; hier reinkopieren und weiter unten abschicken.</textarea>
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
<form action="flotte.php" method="post">
		<br clear="all" />
		
	<div align="center">
	<table width="50%">
		
		<tr>
			<td width="50%">Spionagesonden:</td>
			<td width="50%"><input name="Sonden" value="{$flotte.Sonden}" maxlength="10" size="15"></td>		
		</tr>
		<tr>
			<td>Recycler:</td>
			<td><input name="Recycler" value="{$flotte.Recycler}" maxlength="8" size="15"></td>		
		</tr>
		<tr>
			<td>Tjuger:</td>
			<td><input name="Tjugar" value="{$flotte.Tjugar}" maxlength="8" size="15"></td>		
		</tr>
		<tr>
			<td>Cougar:</td>
			<td><input name="Cougar" value="{$flotte.Cougar}" maxlength="8" size="15"></td>		
		</tr>
		<tr>
			<td>Longeagle V:</td>
			<td><input name="LeV" value="{$flotte.LeV}" maxlength="8" size="15"></td>		
		</tr>
		<tr>
			<td>Ikarus:</td>
			<td><input name="Noah" value="{$flotte.Noah}" maxlength="8" size="15"></td>		
		</tr>
		<tr>
			<td>Longeagle X:</td>
			<td><input name="LeX" value="{$flotte.LeX}" maxlength="8" size="15"></td>		
		</tr>
		<tr>
			<td>Schakal:</td>
			<td><input name="Schakal" value="{$flotte.Schakal}" maxlength="10" size="15"></td>
		</tr>
		<tr>
			<td>Renegade:</td>
			<td><input name="Rene" value="{$flotte.Rene}" maxlength="8" size="15"></td>
		</tr>
		<tr>
			<td>Raider:</td>
			<td><input name="Rene" value="{$flotte.Rene}" maxlength="8" size="15"></td>
		</tr>
		<tr>
			<td>Tarnbomber:</td>
			<td><input name="Tarn" value="{$flotte.Tarn}" maxlength="8" size="15"></td>
		</tr>
		<tr>
			<td>Kolonisationsschiff:</td>
			<td><input name="Kolo" value="{$flotte.Kolo}" maxlength="8" size="15"></td>
		</tr>
		<tr>
			<td>Kleines Handelsschiff:</td>
			<td><input name="Klein" value="{$flotte.Klein}" maxlength="8" size="15"></td>
		</tr>
		<tr>
			<td>Gro&szlig;es Handelsschiff:</td>
			<td><input name="Gross" value="{$flotte.Gross}" maxlength="8" size="15"></td>
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

	
	</body>
</html>