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

	<form method="post" action="gesamtausbau.php">
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
		{if $wrongplani == 1 }
		<tr>
			<th colspan="2" style="color: #fec22f;">Anzahl der Planeten im Spiel unterscheiden sich von denen im AllyManager!</th>		
		</tr>
		{/if}
		<tr>
			<th colspan="2"><b>Ausbau aus Gesamt&uuml;bersicht</b></th><br>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="10" wrap="soft" name="gesamtausbau_raw">Die Gesamt&uuml;bersicht einfach hier reinkopieren und Button dr&uuml;cken.</textarea>			
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