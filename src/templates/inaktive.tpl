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

	<form method="post" action="inaktive.php">
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
		{if $wrongfields == 1 }
		<tr>
			<th colspan="2" style="color: #fec22f;">Nicht alle Felder ausgef&uuml;llt!</th>		
		</tr>
		{/if}
		<tr>
			<th colspan="2"><b>Highscore hier reinkopieren!</b><br>Achtung! Nur mit InternetExplorer funktionsfaehig!</th><p>
		</tr>
		<tr>
			<td colspan="2" align="center">
				1-100<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part1"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				101-200<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part2"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				201-300<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part3"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				301-400<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part4"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				401-500<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part5"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				501-600<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part6"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				601-700<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part7"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				701-800<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part8"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				801-900<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part9"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				901-1000<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part10"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1001-1100<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part11"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1101-1200<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part12"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1201-1300<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part13"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1301-1400<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part14"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1401-1500<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part15"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1501-1600<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part16"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1601-1700<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part17"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1701-1800<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part18"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1801-1900<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part19"></textarea>			
			</td>		
		</tr>
		<tr>
			<td colspan="2" align="center">
				1901-2000<br>
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="3" wrap="soft" name="part20"></textarea>			
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