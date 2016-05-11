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
	
	<table width="90%">{$menu}</table>	
	
	
	<table width="90%">
		<tr>
			<th style="font-size: 8pt;">Koords</td>
			<th>Sonden</td>
			<th>Recycler</td>
			<th>Tjugar</td>
			<th>Cougar</td>
			<th>Longeagle V</td>
			<th>Noah</td>
			<th>Longeagle X</td>
		</tr>
		
	{foreach from=$flotte item=flotte}
		<tr>
			<td align="center">{$flotte.koord}</td>
			<td align="center">{$flotte.Sonden}</td>
			<td align="center">{$flotte.Recycler}</td>
			<td align="center">{$flotte.Tjugar}</td>
			<td align="center">{$flotte.Cougar}</td>
			<td align="center">{$flotte.LeV}</td>
			<td align="center">{$flotte.Noah}</td>
			<td align="center">{$flotte.LeX}</td>
		</tr>
	{/foreach}
	
		<tr>
			<th align="center">Summe:</th>
			<th align="center">{$summe.Sonden}</th>
			<th align="center">{$summe.Recycler}</th>
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