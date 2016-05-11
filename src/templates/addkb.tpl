<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>YAAM! 5.1 Yet another Allianz Manager Version 5.1</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

<br clear="all" />

	<form method="post" action="addkb.php">
	<div align="center">
	<table width="50%">
		{if $changed == 1}
		<tr>
			<th colspan="2" style="color: #fec22f;">&Auml;nderungen erfolgreich &uuml;bernommen!<br>KB-ID ist : {$kbid}<br>Link zum Kb ist <a href="{$path}showkb.php?kbid={$kbid}" target="_blank">{$path}showkb.php?kbid={$kbid}</a></th>		
		</tr>
		{/if}
		
		{if $wrongdata == 1 }
		<tr>
			<th colspan="2" style="color: #fec22f;">Fehlerhafte Daten oder Link kopiert!</th>		
		</tr>
		{/if}
		
		<tr>
			<th colspan="2"><b>Kb durch Copy&amp;Paste einf&uuml;gen und eintragen</b></th><br>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="10" wrap="soft" name="kb_raw">Kb-Kopieren. Einfach den KB wie gewohnt &ouml;ffnen mit STRG + A alles markieren und hier mit STRG + V einfügen. Dann auf KB eintragen klicken... Ganz einfach ;)</textarea>			
			    </td>		
		</tr>

		<tr>
			<td class="none" width="50%">
				<input type="hidden" name="update2" value="true">
				<input type="hidden" name="kid" value="{$kid}">			
			</td>
			<td width="50%"><input type="submit" value="Kb eintragen"></td>		
		</tr>
	</table>
	</div>	
	</form>

		<br clear="all" />
	</body>
</html>