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
			<th>Rest</td>
			<th>Tjuger</td>
			<th>Cougar</td>
			<th>LeV</td>
			<th>Noah</td>
			<th>LeX</td>
			<th>ckk</td>
			<th>eckk</td>
			<th>fckk</td>
			<th>feckk</td>
		</tr>
		
	{foreach from=$flotte item=flotte}
		<tr>
			<td align="center">{$flotte.koord}</td>
			{if $flotte.Rest == '0'}<td align="center">{$flotte.Rest}</td>{/if}
			{if $flotte.Rest >= '1'}<td align="center"><a href="uebersicht.php?page=flotte1">{$flotte.Rest}</a></td>{/if}
            <td align="center">{$flotte.Tjugar}</td>
			<td align="center">{$flotte.Cougar}</td>
			<td align="center">{$flotte.LeV}</td>
			<td align="center">{$flotte.Noah}</td>
			<td align="center">{$flotte.LeX}</td>
		    <td align="center">{$flotte.ckk}</td>
            <td align="center">{$flotte.eckk}</td>
            <td align="center">{$flotte.fckk}</td>
            <td align="center">{$flotte.feckk}</td>
        </tr>
	{/foreach}
	
		<tr>
			<th align="center">Summe:</th>
			<th align="center">{$summe.Rest}</th>
			<th align="center">{$summe.Tjugar}</th>
			<th align="center">{$summe.Cougar}</th>
			<th align="center">{$summe.LeV}</th>
			<th align="center">{$summe.Noah}</th>
			<th align="center">{$summe.LeX}</th>
		</tr>	

	</table>
 	</div>
 
		<br clear="all" />
	</body>
</html>