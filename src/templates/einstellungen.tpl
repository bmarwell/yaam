<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

	<div align="center">
	<table width="500">
		<tr>
			<th colspan="2">Einstellungen</th>		
		</tr>	
		{if isset($pw_erfolg)}		
		<tr>
			<th colspan="2" style="color: #fec22f;">Passwort erfolgreich geändert!</th>		
		</tr>			
		{/if}
		{if isset($error)}		
		<tr>
			<th colspan="2" style="color: #fec22f;">{$error}</th>		
		</tr>			
		{/if}		
		<tr>
			<th colspan="2">Passwort &auml;ndern:</th>		
		</tr>				
		<tr>
			<td>
				<form action="einstellungen.php" method="post">
				Altes Passwort:
			</td>
			<td><input type="password" name="pw_alt" size="15" maxlength="40"></td>		
		</tr>	
		<tr>
			<td>Neues Passwort:</td>
			<td><input type="password" name="pw_neu1" size="15" maxlength="40"></td>		
		</tr>
		<tr>
			<td>Neues Passwort:<br />(Kontrolle)</td>
			<td><input type="password" name="pw_neu2" size="15" maxlength="40"></td>		
		</tr>
		<tr>
			<td class="none"></td>
			<td><input type="submit" value="&Auml;ndern!"></form></td>		
		</tr>
		
		<tr>
			<td colspan="2" class="none">&nbsp;</td>		
		</tr>		
		
		{if !isset($urlaub) || $urlaub.Start == NULL || $urlaub.Start == ''}
		<tr>
			<th colspan="2">Urlaubsantrag:</th>		
		</tr>				
		<tr>
			<td>
				<form action="einstellungen.php" method="post">
				Von Datum:
			</td>
			<td><input type="text" name="vdatum" size="15" maxlength="40"></td>		
		</tr>	
		<tr>
			<td>Bis Datum:</td>
			<td><input type="text" name="bdatum" size="15" maxlength="40"></td>		
		</tr>
		<tr>
			<td>Sitter:</td>
			<td><input type="text" name="sitter" size="15" maxlength="40"></td>		
		</tr>
		<tr>
			<td>Grund (optional):</td>
			<td><input type="text" name="grund" size="35" maxlength="80"></td>		
		</tr>
		<tr>
			<td class="none"><input type="hidden" name="urlaub" value="true"></td>
			<td><input type="submit" value="Antrag"></form></td>		
		</tr>		
		{else} {* nur Abbruch zeigen... *}	
		<tr>
			<th colspan="2">Urlaubsmodus</th>		
		</tr>	
		<tr>
			<td colspan="2" align="center">
				Vom {$urlaub.Start} bis zum {$urlaub.Ende} im Urlaub.<br />
				Grund: {$urlaub.Grund}. Sitter: {$urlaub.Sitter}.<br />
				<a href="einstellungen.php?del=true">U-Modus Aufheben</a>
			</td>		
		</tr>
		{/if}
		
 	</table>
 	</div>
 
		<br clear="all" />
	</body>
</html>