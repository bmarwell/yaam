<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

<form action="forschung.php" method="post">


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
			<th colspan="2"><b>Forschungsstatus</b></th>
		</tr>
		<tr>
			<th colspan="2">Antriebsforschung:</th>		
		</tr>		
		<tr>
			<td width="50%">Verbrennungsantrieb:</td>
			<td width="50%"><input name="VbA" value="{$forschung.VbA}" maxlength="3" size="15"></td>		
		</tr>	
		<tr>
			<td>Ionenantrieb:</td>
			<td><input name="IoA" value="{$forschung.IoA}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Raumkr&uuml;mmungsantrieb:</td>
			<td><input name="RkA" value="{$forschung.RkA}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Raumfaltungsantrieb:</td>
			<td><input name="RfA" value="{$forschung.RfA}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<th colspan="2">Waffenforschung:</th>		
		</tr>
		<tr>
			<td>Ionisation:</td>
			<td><input name="Ionis" value="{$forschung.Ionis}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Energieb&uuml;ndelung:</td>
			<td><input name="Energ" value="{$forschung.Energ}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Explosivgeschosse:</td>
			<td><input name="Explo" value="{$forschung.Explo}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Spionagetechnik:</td>
			<td><input name="Spio" value="{$forschung.Spio}" maxlength="3" size="15"></td>		
		</tr>		
		<tr>
			<td>Schiffspanzerung:</td>
			<td><input name="Panzer" value="{$forschung.Panzer}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Ladekapazit&auml;t:</td>
			<td><input name="LadeKapa" value="{$forschung.LadeKapa}" maxlength="3" size="15"></td>		
		</tr>
		<tr>
			<td>Recyclingtechnik:</td>
			<td><input name="Recycler" value="{$forschung.Recycler}" maxlength="3" size="15"></td>		
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

	<form method="post" action="forschung.php">
	<div align="center">
	<table width="50%">
		<tr>
			<td colspan="2" align="center">
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="10" wrap="soft" name="forschung_raw">Oder hier einfach die Forschungsseite hier reinkopieren und weiter unten abschicken.</textarea>			
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