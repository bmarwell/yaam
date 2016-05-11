<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<script type="text/javascript" language="JavaScript">
		image9 = new Image;
		image9.src = "./bilder/navi/_ausbau2_on.png";
		image10 = new Image;
		image10.src = "./bilder/navi/_ausbau2.png";
		
		image13 = new Image;
		image13.src = "./bilder/navi/_flotten_on.png";
		image14 = new Image;
		image14.src = "./bilder/navi/_flotten.png";
		
		image15 = new Image;
		image15.src = "./bilder/navi/_uebersicht2_on.png";
		image16 = new Image;
		image16.src = "./bilder/navi/_uebersicht2.png";   
		
		image17 = new Image;
		image17.src = "./bilder/navi/_ressourcen_on.png";
		image18 = new Image;
		image18.src = "./bilder/navi/_ressourcen.png";  
   </script>
</head>

<body>

	<div align="center">
	
	<table width="90%">{$menu}</table>	
	
	<table width="90%">
		<tr>
			<th colspan="8"><font size="4" color="yellow">Ressourcen pro Stunde / Tag</font></th>
		</tr>
		
		<tr>
			<th>Koords</td>
			<th colspan="2" width="12%">Eisen</td>
			<th colspan="2" width="11%">Lutinum</td>
			<th colspan="2" width="11%">Wasser</td>
			<th colspan="2" width="11%">Wasserstoff</td>
		</tr>
		
	{foreach from=$ressourcen item=ress}
		<tr>
			<td align="center" width="12%">{$ress.koord}</td>
			<td align="center" width="10%">{$ress.Eisen}</td>
			<td align="center" width="12%">{$ress.Eisen24}</td>
			<td align="center" width="10%">{$ress.Lutinum}</td>
			<td align="center" width="12%">{$ress.Lutinum24}</td>
			<td align="center" width="10%">{$ress.Wasser}</td>
			<td align="center" width="12%">{$ress.Wasser24}</td>
			<td align="center" width="10%">{$ress.Wasserstoff}</td>
			<td align="center" width="12%">{$ress.Wasserstoff24}</td>
		</tr>
	{/foreach}
	
	{if $summe.Eisen != 0}
		<tr>
			<th class="none" width="12%">Summe 24h:</th>
			<th colspan="2">{$summe.Eisen}</th>
			<th colspan="2">{$summe.Lutinum}</th>
			<th colspan="2">{$summe.Wasser}</th>
			<th colspan="2">{$summe.Wasserstoff}</th>
		</tr>	
	{/if}
	</table>
 	</div>
 
		<br clear="all" />
	</body>
</html>