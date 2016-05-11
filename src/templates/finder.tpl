<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>

<br clear="all" />

	<form method="post" action="finder.php">
	<div align="center">
	<table width="50%">
		{if $changed == 1}
		<tr>
			<th colspan="2" style="color: #fec22f;">&Auml;nderungen erfolgreich &uuml;bernommen!</th>		
		</tr>
		{/if}
		{if $wrongdata == 1 }
		<tr>
			<th colspan="2" style="color: #fec22f;">Fehlerhafte Daten kopiert!</th>		
		</tr>
		{/if}
		<tr>
			<th colspan="2"><b>Highscoredaten ({$hsanz} eingetragen)</b></th><br>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<textarea cols="40" width="100%" onfocus="this.value = ''" rows="10" wrap="soft" name="highscoredaten_raw">Highscore Seite f&uuml;r Seite einfach hier reinkopieren und Button dr&uuml;cken.</textarea>			
			</td>		
		</tr>

		<tr>
			<td  width="50%">
				{if $rechte >= '3'}
					<input type="hidden" name="update2" value="true">
					<input type="hidden" name="kid" value="{$kid}">			
					<input type="submit" name="sub2" value="Inaktive suchen">
				{/if}				
			</td>			
			<td width="50%">
				{if $rechte >= '4'}
					<input type="submit" name="sub1" value="Auslesen &amp; &uuml;bernehmen">
				{/if}	
			</td>		
		</tr>
		</form>
		
		
	{if $rechte >= '3'}
		<form method="post" action="finder.php">
		  <tr> 
			<td width="50%">
				AllyTag:<input name="allytag"/>
				<input type="submit" value="Allymember suchen">
				<input type="hidden" name="update1" value="true">
			</td>
		  </tr>
		</form>				
	{/if}
	

	
	</table>
	</div>

	{if (isset($erg))} 
		<div align="center">
		<table width="50%">		
			<tr>
				<td>
					Name
				</td>
				<td>
					Punkte Forschung
				</td>
				<td>
					Punkte Planeten					
				</td>
				<td>
					Anzahl Planeten
				</td>
				<td>
					Ally Tag
				</td>
				<td>
					Update Date
				</td>				
			</tr>
		
			{foreach from=$erg item=erg name=erg}
				<tr>
					<td>
						{$erg.name}
					</td>
					<td>
						{$erg.punkteFo}
					</td>
					<td>
						{$erg.punktePl}					
					</td>
					<td>
						{$erg.anzahlPl}
					</td>
					<td>
						{$erg.tag}
					</td>
					<td>
						{$erg.updatedate}
					</td>					
				</tr>
			{/foreach}
		</table>
		</div>
	{/if}
		<br clear="all" />
	</body>
</html>