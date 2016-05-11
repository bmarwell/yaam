<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

<br clear="all" />

	<form method="post" action="karte.php">
	<div align="center">
	<table width="50%">
		{if $changed == 1}
		<tr>
			<th colspan="2" style="color: #fec22f;">&Auml;nderungen erfolgreich &uuml;bernommen!</th>		
		</tr>
		{/if}
		{if $wrongdata == 1 }
		<tr>
			<th colspan="2" style="color: #fec22f;">Fehlerhafte Daten kopiert!</th>		
		</tr>
		{/if}
		<tr>
			<th colspan="2"><b>Angriffsdaten aus Nachrichten</b></th><br>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="10" wrap="soft" name="angriffsdaten_raw">Nachrichten einfach hier reinkopieren und Button dr&uuml;cken.</textarea>			
			</td>		
		</tr>

		<tr>
			<td  width="50%">
				<input type="hidden" name="update2" value="true">
				<input type="hidden" name="kid" value="{$kid}">			
			</td>
			<td width="50%"><input type="submit" value="Auslesen &amp; &uuml;bernehmen"></td>		
		</tr>
		</form>
		
		
	{if $rechte >= '3'}
		<form method="post" action="pictest.php">
		  <tr> 
			<td width="50%">
				<select name="size" size="1">
				  <option value="2">Size S</option>
				  <option value="4">Size M</option>
				  <option value="6">Size L</option>
				  <option value="8">Size XL</option>
				  <option value="12">Size XXL</option>
				  <option value="30">MEGA</option>			  			  
				</select>
				<input type="submit" value="Ally &Uuml;bersichtskarte">
			</td>
		</form>		
		<form method="post" action="pictest.php">
			<td width="50%">
				<select name="size" size="1">
				  <option value="2">Size S</option>
				  <option value="4">Size M</option>
				  <option value="6">Size L</option>
				  <option value="8">Size XL</option>
				  <option value="12">Size XXL</option>
				  <option value="30">MEGA</option>			  			  
				</select>
				<input type="hidden" name="feind" value="1">
				<input type="submit" value="Ally &Uuml;bersichtskarte + Feinde">
			</td>		
		</form>		
	{/if}
	
	</table>
	</div>
	
	

		<br clear="all" />
	</body>
</html>