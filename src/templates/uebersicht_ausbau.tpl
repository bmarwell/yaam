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
			<th>HQ</td>
			<th>FZ</td>
			<th>Fe</td>
			<th>Sil<th>Bohr</td>
			<th style="font-size: 8pt;">Chemie</td>
			<th style="font-size: 10pt;">eChem</td>
			<th>Fesp.</td>
			<th>Silsp.</td>
			<th style="font-size: 8pt;">Wassp.</td>
			<th>H2sp.</td>
			<th>SF</td>
			<th>Orbi</td>
			<th style="font-size: 8pt;">Schild</td>
			<th>Fusi</td>
		</tr>
		
	{foreach from=$ausbau item=ausbau}
		<tr>
			<td align="center">{$ausbau.koord}</td>
			<td align="center">{$ausbau.KZ}</td>
			<td align="center">{$ausbau.FZ}</td>
			<td align="center">{$ausbau.FeMine}</td>
			<td align="center">{$ausbau.LutRaff}</td>
			<td align="center">{$ausbau.Bohr}</td>
			<td align="center">{$ausbau.Chem}</td>
			<td align="center">{$ausbau.ErwChem}</td>
			<td align="center">{$ausbau.FeSpeicher}</td>
			<td align="center">{$ausbau.LutSpeicher}</td>
			<td align="center">{$ausbau.WasSpeicher}</td>
			<td align="center">{$ausbau.H2Speicher}</td>
			<td align="center">{$ausbau.SF}</td>
			<td align="center">{$ausbau.OV}</td>
			<td align="center">{$ausbau.Schild}</td>
			<td align="center">{$ausbau.Fusi}</td>
		</tr>
	{/foreach}
	
		<tr>
			<th>Schnitt:</th>	
			<th align="center" class="none">{$schnitt.KZ}</th>
			<th align="center" class="none">{$schnitt.FZ}</th>
			<th align="center" class="none">{$schnitt.FeMine}</th>
			<th align="center" class="none">{$schnitt.LutRaff}</th>
			<th align="center" class="none">{$schnitt.Bohr}</th>
			<th align="center" class="none">{$schnitt.Chem}</th>
			<th align="center" class="none">{$schnitt.ErwChem}</th>
			<th align="center" class="none">{$schnitt.FeSpeicher}</th>
			<th align="center" class="none">{$schnitt.LutSpeicher}</th>
			<th align="center" class="none">{$schnitt.WasSpeicher}</th>
			<th align="center" class="none">{$schnitt.H2Speicher}</th>
			<th align="center" class="none">{$schnitt.SF}</th>
			<th align="center" class="none">{$schnitt.OV}</th>
			<th align="center" class="none">{$schnitt.Schild}</th>
			<th align="center" class="none">{$schnitt.Fusi}</th>	
		</tr>
	</table>
 	</div>
 
		<br clear="all" />
	</body>
</html>