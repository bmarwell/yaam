<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>	<div align="center">
	<img border="0" src="bilder/logo.png" alt="Yaam! Logo">
	<form method="POST" action="registrieren.php">
	
	<table width="65%">

		{if $msg}
		<tr>
			<th colspan="2">{$msg}</th>
		</tr>
		{/if}		
	
		<tr>
			<th colspan="2">Bitte mit Ingame-Nick registrieren</th>
		</tr>
		<tr>
			<td align="center">Nickname:</td>
			<td align="center"><input type="text" name="user" size="20" value="{$nick}"></td>	
		</tr>
		<tr>
			<td align="center">Passwort:</td>
			<td align="center"><input type="password" name="pass1" size="20"></td>
		</tr>
		<tr>
			<td align="center">Passwort wiederholen:</td>
			<td align="center"><input type="password" name="pass2" size="20"></td>
		</tr>
		<tr>
			<td align="center">E-Mailadresse:</td>
			<td align="center"><input type="text" name="email" size="20" value="{$mail}"></td>
		</tr>	
		<tr>
			<td colspan="2" align="center">
				<input type="hidden" name="submit" value="25">
				<input type="submit" value="Registrieren">&nbsp;<input type="reset" value="Zurücksetzen">
			</td>
		</tr>	
	</table>
	
	</form>
	</div>
</body>

	