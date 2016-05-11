<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
   
   <script language="JavaScript" type="text/javascript">
		f_off = new Image; f_on = new Image;
		a_off = new Image; a_on = new Image;
		
		a_off.src = "./bilder/navi/a.png"
		a_on.src = "./bilder/navi/a_on.png"
		f_off.src = "./bilder/navi/f.png"
		f_on.src = "./bilder/navi/f_on.png"
		
	</script>
		
</head>

<body>
	<div align="center">	<table width="65%">
	
{if $user_koords != NULL && !isset($geloescht)}
	<tr>
		<td colspan="2">Koordinaten &auml;ndern und Abschicken, um die &Auml;nderungen vorzunehmen.
		<br />
		Koordinaten l&ouml;schen, um den gesamten Planeten mit Schiffen und Ausbau<br />
		aus der Datenbank zu entfernen.</td>	
	</tr>
{/if}
{if isset($geloescht)}
	<tr>
		<th colspan="2" style="color: #fec22f;">Planet erfolgreich gel&ouml;scht!</th>	
	</tr>
{/if}


{* Ab hier die koordinaten 1 - 20 [0 - 19] *}
{* Beachte: Gibts die grade zahl nicht, so kanns auch die darauffolgende ung. Zahl nicht geben. *}


{if isset($user_koords[0])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[0].kid}" size="15" maxlength="10" value="{$user_koords[0].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[0].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[0].kid}" onmouseover="a{$user_koords[0].kid}.src = a_on.src" onmouseout="a{$user_koords[0].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[0].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[0].kid}" onmouseover="f{$user_koords[0].kid}.src = f_on.src" onmouseout="f{$user_koords[0].kid}.src = f_off.src" alt="Flotte"></a>
		</td>	
		
		<td width="50%">
		{if isset($user_koords[1])}
			<input type="text" name="{$user_koords[1].kid}" size="15" maxlength="10" value="{$user_koords[1].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[1].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[1].kid}" onmouseover="a{$user_koords[1].kid}.src = a_on.src" onmouseout="a{$user_koords[1].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[1].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[1].kid}"  onmouseover="f{$user_koords[1].kid}.src = f_on.src" onmouseout="f{$user_koords[1].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 2 / 10 || [2] und [3] *}

{if isset($user_koords[2])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[2].kid}" size="15" maxlength="10" value="{$user_koords[2].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[2].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[2].kid}" onmouseover="a{$user_koords[2].kid}.src = a_on.src" onmouseout="a{$user_koords[2].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[2].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[2].kid}"  onmouseover="f{$user_koords[2].kid}.src = f_on.src" onmouseout="f{$user_koords[2].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[3])}
			<input type="text" name="{$user_koords[3].kid}" size="15" maxlength="10" value="{$user_koords[3].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[3].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[3].kid}" onmouseover="a{$user_koords[3].kid}.src = a_on.src" onmouseout="a{$user_koords[3].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[3].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[3].kid}"  onmouseover="f{$user_koords[3].kid}.src = f_on.src" onmouseout="f{$user_koords[3].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 3 / 10 || [4] und [5] *}

{if isset($user_koords[4])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[4].kid}" size="15" maxlength="10" value="{$user_koords[4].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[4].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[4].kid}" onmouseover="a{$user_koords[4].kid}.src = a_on.src" onmouseout="a{$user_koords[4].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[4].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[4].kid}" onmouseover="f{$user_koords[4].kid}.src = f_on.src" onmouseout="f{$user_koords[4].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[5])}
			<input type="text" name="{$user_koords[5].kid}" size="15" maxlength="10" value="{$user_koords[5].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[5].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[5].kid}" onmouseover="a{$user_koords[5].kid}.src = a_on.src" onmouseout="a{$user_koords[5].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[5].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[5].kid}" onmouseover="f{$user_koords[5].kid}.src = f_on.src" onmouseout="f{$user_koords[5].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 4 / 10 || [6] und [7] *}

{if isset($user_koords[6])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[6].kid}" size="15" maxlength="10" value="{$user_koords[6].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[6].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[6].kid}" onmouseover="a{$user_koords[6].kid}.src = a_on.src" onmouseout="a{$user_koords[6].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[6].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[6].kid}" onmouseover="f{$user_koords[6].kid}.src = f_on.src" onmouseout="f{$user_koords[6].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[7])}
			<input type="text" name="{$user_koords[7].kid}" size="15" maxlength="10" value="{$user_koords[7].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[7].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[7].kid}" onmouseover="a{$user_koords[7].kid}.src = a_on.src" onmouseout="a{$user_koords[7].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[7].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[7].kid}" onmouseover="f{$user_koords[7].kid}.src = f_on.src" onmouseout="f{$user_koords[7].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 5 / 10 || [8] und [9] *}

{if isset($user_koords[8])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[8].kid}" size="15" maxlength="10" value="{$user_koords[8].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[8].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[8].kid}" onmouseover="a{$user_koords[8].kid}.src = a_on.src" onmouseout="a{$user_koords[8].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[8].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[8].kid}" onmouseover="f{$user_koords[8].kid}.src = f_on.src" onmouseout="f{$user_koords[8].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[9])}
			<input type="text" name="{$user_koords[9].kid}" size="15" maxlength="10" value="{$user_koords[9].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[9].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[9].kid}" onmouseover="a{$user_koords[9].kid}.src = a_on.src" onmouseout="a{$user_koords[9].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[9].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[9].kid}" onmouseover="f{$user_koords[9].kid}.src = f_on.src" onmouseout="f{$user_koords[9].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 6 / 10 || [10] und [11] *}

{if isset($user_koords[10])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[10].kid}" size="15" maxlength="10" value="{$user_koords[10].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[10].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[10].kid}" onmouseover="a{$user_koords[10].kid}.src = a_on.src" onmouseout="a{$user_koords[10].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[10].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[10].kid}" onmouseover="f{$user_koords[10].kid}.src = f_on.src" onmouseout="f{$user_koords[10].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[11])}
			<input type="text" name="{$user_koords[11].kid}" size="15" maxlength="10" value="{$user_koords[11].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[11].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[11].kid}" onmouseover="a{$user_koords[11].kid}.src = a_on.src" onmouseout="a{$user_koords[11].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[11].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[11].kid}" onmouseover="f{$user_koords[11].kid}.src = f_on.src" onmouseout="f{$user_koords[11].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 7 / 10 || [12] und [13] *}

{if isset($user_koords[12])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[12].kid}" size="15" maxlength="10" value="{$user_koords[12].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[12].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[12].kid}" onmouseover="a{$user_koords[12].kid}.src = a_on.src" onmouseout="a{$user_koords[12].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[12].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[12].kid}" onmouseover="f{$user_koords[12].kid}.src = f_on.src" onmouseout="f{$user_koords[12].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[13])}
			<input type="text" name="{$user_koords[13].kid}" size="15" maxlength="10" value="{$user_koords[13].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[13].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[13].kid}" onmouseover="a{$user_koords[13].kid}.src = a_on.src" onmouseout="a{$user_koords[13].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[13].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[13].kid}" onmouseover="f{$user_koords[13].kid}.src = f_on.src" onmouseout="f{$user_koords[13].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 8 / 10 || [14] und [15] *}

{if isset($user_koords[14])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[14].kid}" size="15" maxlength="10" value="{$user_koords[14].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[14].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[14].kid}" onmouseover="a{$user_koords[14].kid}.src = a_on.src" onmouseout="a{$user_koords[14].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[14].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[14].kid}" onmouseover="f{$user_koords[14].kid}.src = f_on.src" onmouseout="f{$user_koords[14].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[15])}
			<input type="text" name="{$user_koords[15].kid}" size="15" maxlength="10" value="{$user_koords[15].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[15].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[15].kid}" onmouseover="a{$user_koords[15].kid}.src = a_on.src" onmouseout="a{$user_koords[15].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[15].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[15].kid}" onmouseover="f{$user_koords[15].kid}.src = f_on.src" onmouseout="f{$user_koords[15].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 9 / 10 || [16] und [17] *}

{if isset($user_koords[16])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[16].kid}" size="15" maxlength="10" value="{$user_koords[16].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[16].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[16].kid}" onmouseover="a{$user_koords[16].kid}.src = a_on.src" onmouseout="a{$user_koords[16].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[16].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[16].kid}" onmouseover="f{$user_koords[16].kid}.src = f_on.src" onmouseout="f{$user_koords[16].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[17])}
			<input type="text" name="{$user_koords[17].kid}" size="15" maxlength="10" value="{$user_koords[17].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[17].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[17].kid}" onmouseover="a{$user_koords[17].kid}.src = a_on.src" onmouseout="a{$user_koords[17].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[17].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[17].kid}" onmouseover="f{$user_koords[17].kid}.src = f_on.src" onmouseout="f{$user_koords[17].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}

{* 10 / 10 || [18] und [19] *}

{if isset($user_koords[18])}
	<tr>
		<td width="50%">
			<input type="text" name="{$user_koords[18].kid}" size="15" maxlength="10" value="{$user_koords[18].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[18].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[18].kid}" onmouseover="a{$user_koords[18].kid}.src = a_on.src" onmouseout="a{$user_koords[18].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[18].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[18].kid}" onmouseover="f{$user_koords[18].kid}.src = f_on.src" onmouseout="f{$user_koords[18].kid}.src = f_off.src" alt="Flotte">
		</td>	
		
		<td width="50%">
		{if isset($user_koords[19])}
			<input type="text" name="{$user_koords[19].kid}" size="15" maxlength="10" value="{$user_koords[19].koord}">
			&nbsp;<a href="ausbau.php?kid={$user_koords[19].kid}"><img src="./bilder/navi/a.png" alt="Ausbau eintragen" title="Ausbau eintragen" name="a{$user_koords[19].kid}" onmouseover="a{$user_koords[19].kid}.src = a_on.src" onmouseout="a{$user_koords[19].kid}.src = a_off.src" "width="16" height="16" border="0" alt="Ausbau"></a>
			&nbsp;<a href="flotte.php?kid={$user_koords[19].kid}"><img src="./bilder/navi/f.png" alt="Flotte eintragen" title="Flotte eintragen" width="16" height="16" border="0" name="f{$user_koords[19].kid}" onmouseover="f{$user_koords[19].kid}.src = f_on.src" onmouseout="f{$user_koords[19].kid}.src = f_off.src" alt="Flotte">
		{/if}
		</td>	
	</tr>	
{/if}


{if $user_koords != NULL}
	<tr style="height: 50px;">
		<td colspan="2" class="none"></td>	
	</tr>
{/if}
{* Das bitte nur anzeigen, wenn er maximal 19 Planeten hat *}
{if count($user_koords) <= 19}	
	<form action="planeten.php" method="post">
	<tr>
		<td>
			<input type="text" name="koordinate" size="15" maxlength="10">&nbsp;Format: xxx:xxx:xx
			<input type="hidden" name="add" value="true">
		</td>
		<td><input type="submit" value="Hinzuf&uuml;gen"></td>	
	</tr>
	</form>
{/if}
{* Planeten löschen, sofern es welche gibt *}	
{if $user_koords != NULL}
	<form action="planeten.php" method="post">
	<tr>
		<td>
			<select name="koordinate" size="1">
			{foreach from=$user_koords item=koords}
				<option value="{$koords.koord}">{$koords.koord}</option>		
			{/foreach}		
			</select>		
		</td>	
		<td>
			<input type="hidden" value="true" name="delete"> 
			<input type="submit" value="L&ouml;schen">
		</td>
	</tr>
	</form>
{/if}	
  </table>
  </div>
  
 </body>
</html>
