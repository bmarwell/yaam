<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
	<div align="center">
	
	{if $rechte > '0'}
	
	<table width="*">
		<tr>
			<th colspan="8"><font size="4" color="yellow">Ranking nach Kbs</font></th>
		</tr>
	
		
		<tr/><tr/><tr/>
		<tr>
			<th colspan="8">Vernichtete CKK</th>
		</tr>
		
		<tr>
			<td align="center">&nbsp;Platz&nbsp;</td>
			<td align="center">&nbsp;Spieler&nbsp;</td>			
			<td align="center">&nbsp;Datum&nbsp;</td>
			<td align="center">&nbsp;CKK&nbsp;</td>
		</tr>
		
		
		{foreach from=$ckk item=ckk name=rankzeile1}		
		<tr>
			<td align="center">{$smarty.foreach.rankzeile1.iteration}</td>
			<td align="center">
				&nbsp;<a href="{$path}showkb.php?kbid={$ckk.KB_ID}">{$ckk.KB_UPLOADER}</a>&nbsp;
			</td>
			<td align="center">
				&nbsp;{$ckk.KB_DATEDONE}&nbsp;
			</td>
			<td align="center">
				&nbsp;{$ckk.KB_CKK}&nbsp;
			</td>
		</tr>
		{/foreach}	
	</table>
	
	
	<p>
	<table width="*">
		<tr>
			<th colspan="8">Erbeutete Ressis</th>
		</tr>
		
		<tr>
			<td align="center">&nbsp;Platz&nbsp;</td>
			<td align="center">&nbsp;Spieler&nbsp;</td>			
			<td align="center">&nbsp;Datum&nbsp;</td>
			<td align="center">&nbsp;Ressis&nbsp;</td>
		</tr>
		
		
		{foreach from=$ressis item=ressis name=rankzeile2}		
		<tr>
			<td align="center">{$smarty.foreach.rankzeile2.iteration}</td>
			<td align="center">
				&nbsp;<a href="{$path}showkb.php?kbid={$ressis.KB_ID}">{$ressis.KB_UPLOADER}</a>&nbsp;
			</td>
			<td align="center">
				&nbsp;{$ressis.KB_DATEDONE}&nbsp;
			</td>
			<td align="center">
				&nbsp;{$ressis.KB_RESSIS}&nbsp;
			</td>
		</tr>
		{/foreach}
	</table>
	<p>
	Im Ressi-Ranking werden Eisen, Lutinum und Wasserstoff in einer Summe angezeigt.
	
	{/if} {* Größer 0? *}
	{if $rechte == '0'}
			<p><font size="4" color="red">Du hast nicht gen&uuml;gend Rechte, um das Kb-Ranking zu sehen!</font></p>
	{/if}

	</div>
	
</body>
</html>