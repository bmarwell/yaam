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
			<th style="font-size: 8pt;">Koords</td>
			<th>Schaks</td>
			<th>Recycs</td>
			<th>Spios</td>
			<th>Renes</td>
			<th>Raiders</td>
			<th>Tarnis</td>
			<th>Kolos</td>
			<th>Kleine</td>
			<th>Gro&szlig;e</td>
		</tr>
		
	{foreach from=$flotte item=flotte}
		<tr>
			<td align="center">{$flotte.koord}</td>
			<td align="center">{$flotte.Schakal}</td>
            <td align="center">{$flotte.Recycler}</td>
			<td align="center">{$flotte.Sonden}</td>
			<td align="center">{$flotte.Rene}</td>
            <td align="center">{$flotte.Raid}</td>
			<td align="center">{$flotte.Tarn}</td>
			<td align="center">{$flotte.Kolo}</td>
            <td align="center">{$flotte.Klein}</td>
			<td align="center">{$flotte.Gross}</td>
        </tr>
	{/foreach}
	
		<tr>
			<th align="center">Summe:</th>
			<th align="center">{$summe.Schakal}</th>
			<th align="center">{$summe.Recycler}</th>
			<th align="center">{$summe.Sonden}</th>
			<th align="center">{$summe.Rene}</th>
			<th align="center">{$summe.Raid}</th>
			<th align="center">{$summe.Tarn}</th>
			<th align="center">{$summe.Kolo}</th>
			<th align="center">{$summe.Klein}</th>
			<th align="center">{$summe.Gross}</th>
		</tr>	

	</table>
 	</div>
 
		<br clear="all" />
	</body>
</html>