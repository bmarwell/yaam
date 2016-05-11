<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script language="JavaScript" type="text/javascript" src="intercept.js"></script>
</head>

<body>
	<div align="center">
	<table>
		<tr>
			<th colspan="2">Flottenabfangrechner</th>
		</tr>
		<tr>
			<td align="center"><form name="Formular">Absendezeit seiner Flotte:</td>
			<td align="center"><input type="text" size="18" name="Abzeit"></td>
		</tr>
		<tr>
			<td align="center">Ankunftszeit seiner Flotte :</td>
			<td align="center"><input type="text" size="18" name="Anzeit"></td>
		</tr>
		<tr>
			<td align="center">Eigene Flugdauer :</td>
			<td align="center"><input type="text" size="18" name="Flugdauer"></td>
		</tr>		
		<tr>
			<td align="none"></td>
			<td align="center"><input onclick="berechnen()" type="button" value="Berechnen!"></td>
		</tr>
		<tr>
			<td colspan="2" class="none">&nbsp;</td>		
		</tr>
		<tr>
			<td align="center">Flugdauer seiner Flotte:</td>
			<td align="center"><input name="SeineFlugDauer" type="text" value="???"></td>		
		</tr>
		<tr>
			<td align="center">R&uuml;ckkehr seiner Flotte:</td>	
			<td align="center"><input name="Rueckkehr" type="text" value="???"></td>	
		</tr>
		<tr>
			<td align="center"><span style="color: #ff6633;">Eigene Flotte losschicken:</span></td>
			<td align="center"><input name="Ausgabe" type="text" value="???"></form></td>
		</tr>
	 
		
	</table>
	</div>
	
</body>
</html>