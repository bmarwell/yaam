<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script language="JavaScript" type="text/javascript" src="pwgen.js"></script>
</head>

<body>
	<div align="center">
	<table>
		<tr>
			<th colspan="2">RdW Passwort-Generator</th>
		</tr>
		<tr>
			<td colspan="2">Empfehlung: Passw&ouml;rter nicht unter 8 Zeichen!<br>
	Einfach Anzahl der gew&uuml;nschten Zeichen angeben und auf den Button klicken!</td>
		</tr>
		<tr>
			<td align="center"><form name="pgenerate">Passwortl&auml;nge:</td>
			<td align="center"><input type="text" name="laenge" size="3" value="8" maxlength="2">&nbsp;Zeichen</td>
		</tr>
		<tr>
			<td align="center"><input type="button" value="Passwort erzeugen" onClick="populateform(this.form.laenge.value)"></td>
			<td align="center"><input type="text" size="18" name="output"></form></td>
		</tr>
	</table>
	</div>
	
</body>
</html>