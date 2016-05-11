<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="../yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

	<div align="center">
	<table width="90%">
		<tr><th colspan="5">Forschungsstatus des Spielers {$user}:</th></tr>
		
		<tr><td colspan="5" class="none"></td></tr>
		
		<tr><th colspan="5">Antriebsforschung:</th></tr>
		<tr>
			<td width="25%">Verbrennungsantrieb:</td>
			<td colspan="2" align="center">{$forschung.VbA}</td>		
			<td width="25%">Ionenantrieb:</td>
			<td width="25%" align="center">{$forschung.IoA}</td>			
		</tr>
		<tr>
			<td width="25%">Raumkr&uuml;mmungsantrieb:</td>
			<td colspan="2" align="center">{$forschung.RkA}</td>		
			<td width="25%">Raumfaltungsantrieb:</td>
			<td width="25%" align="center">{$forschung.RfA}</td>			
		</tr>
		<tr><th colspan="5">Waffenforschung:</th></tr>
		<tr>
			<td width="25%">Ionisation:</td>
			<td colspan="2" align="center">{$forschung.Ionis}</td>		
			<td width="25%">Energieb&uuml;ndelung:</td>
			<td width="25%" align="center">{$forschung.Energ}</td>			
		</tr>		
		<tr>
			<td width="25%">Explosivgeschosse:</td>
			<td colspan="2" align="center">{$forschung.Explo}</td>		
			<td width="25%">Spionagetechnik:</td>
			<td width="25%" align="center">{$forschung.Spio}</td>			
		</tr>		
		<tr>
			<td width="25%">Schiffspanzerung:</td>
			<td colspan="2" align="center">{$forschung.Panzer}</td>		
			<td width="25%">Erh&ouml;hte Ladekapazit&auml;t:</td>
			<td width="25%" align="center">{$forschung.LadeKapa}</td>			
		</tr>	
		<tr>
			<td width="25%">Recyclingtechnik:</td>
			<td colspan="2" align="center">{$forschung.Recycler}</td>		
			<td width="25%" class="none"></td>
			<td width="25%" class="none"></td>			
		</tr>	
 	</table>
 	</div>
 
		<br clear="all" />
	</body>
</html>