<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
	{if $summeckk > 0}
		<div align="center">
		<table width="*">
			<tr>
				<th colspan="8">Allianzranking MAIN</th>
			</tr>

			{if $rechte > '0'} 
			
			{* Urlaubsmodus? Irgendwer? *}
			{foreach from=$urlaub item=urlaub name=urlaub}	
			{if $urlaub.Start != ''}
			<tr>
				<td align="center" colspan="8" class="urlaub">
					<b>{$urlaub.nick}:</b> Vom {$urlaub.Start} bis zum {$urlaub.Ende}.
					<b>Grund:</b> {$urlaub.Grund}
					<b>Sitter:</b> {$urlaub.Sitter}</td>
			</tr>		
			{/if}
			{/foreach}
			
			
			<tr>
				<td align="center">&nbsp;Platz&nbsp;</td>
				<td align="center">&nbsp;Tag&nbsp;</td>			
				<td align="center">&nbsp;Spieler&nbsp;</td>
				{if $rechte >= $proa}<td align="center">&nbsp;% Alliflotte&nbsp;</td>{/if}
				{if $rechte >= $pro1}<td align="center">&nbsp;% am 1.&nbsp;</td>{/if}
				{if $rechte >= $ckk}<td align="center">&nbsp;[ckk]&nbsp;</td>{/if}
			
				{if $rechte >= $eckk}<td align="center">&nbsp;[eckk]&nbsp;</td>{/if}
			
			
				{if $rechte >= $fckk}<td align="center">&nbsp;[fckk]&nbsp;</td>{/if}
				
				{if $rechte >= $feckk}<td align="center">&nbsp;[feckk]&nbsp;</td>{/if}
			
				{if $rechte >= $forsch}<td align="center">&nbsp;Forschung&nbsp;</td>{/if}
				{if $rechte >= $update}<td align="center">&nbsp;Letztes Update&nbsp;</td>{/if}
				{if $rechte >= $lev}<td align="center">&nbsp;LEV pro Tag&nbsp;</td>{/if}
			</tr>
			
			{$i++}
			{foreach from=$user item=user name=rankzeile}
			{if $user.Main == 1}
			<tr>
				<td align="center">{$i++}</td>
				
				<td align="center">
					&nbsp;{$user.Tag}&nbsp;
				</td>
				
				<td align="center">
					&nbsp;{if $rechte >= $aus}<a href="admin/ausbau.php?uid={$user.uid}">{/if}{$user.Nick}{if $rechte >= $aus}</a>{/if}&nbsp;
				</td>
				
				{if $rechte >= $proa}<td align="right">&nbsp;{$user.ProGes}&nbsp;%&nbsp;</td>{/if}
				
				{if $rechte >= $pro1}<td align="right">&nbsp;{$user.ProErst}&nbsp;%&nbsp;</td>{/if}
				
				{if $rechte >= $ckk}<td align="right">
					&nbsp;{if $rechte >= '4'}<a href="admin/flotte.php?uid={$user.uid}">{/if}{$user.ckk}{if $rechte >= $ckk}</a>{/if}&nbsp;
				</td>{/if}
				
			
				{if $rechte >= $eckk}<td align="right">
					&nbsp;{$user.eckk}&nbsp;
				</td>
				{/if}
				
				
				{if $rechte >= $fckk}<td align="right">
					&nbsp;{$user.fckk}&nbsp;
				</td>
				{/if}
				
				
				{if $rechte >= $feckk}<td align="right">
					&nbsp;{$user.feckk}&nbsp;
				</td>
				{/if}
				
				{if $rechte >= $forsch}<td align="right">
					&nbsp;{if $rechte >= $aus}<a href="admin/forschung.php?uid={$user.uid}">{/if}{$user.Forschung} Pkt.{if $rechte >= $aus}</a>{/if}&nbsp;
				</td>{/if}
				
				{if $rechte >= $update}
					{* Länger als 7 Tage tot: *}
					{if (time()-$user.Unixzeit > 60*60*24*8) }
					<td style="color: #Ff0000;" align="center">Strafe Erhalten&nbsp;</td>
					{elseif (time()-$user.Unixzeit > 60*60*24*4) }
                    <td style="color: #Ff5B5B;" align="center">Sofort Eintragen&nbsp;</td>
					{elseif (time()-$user.Unixzeit > 60*60*24*2) }
					<td style="color: #F5F23A;" align="center">Eintragen&nbsp;</td>
					{else}
					<td style="color: #70ff50;" align="center">{$user.LastChg}&nbsp;</td>
					{/if}			
				{/if}
				
				{if $rechte >= $lev}<td align="right">&nbsp;{$user.ProdLev}&nbsp;Stk.&nbsp;</td>{/if}		
					
				
			</tr>
			{/if}
			{/foreach}
			
			{if $rechte >= '3'}
			<tr>
				<th align="left" colspan="2">Summe Allianz:</th>
				<th align="right">&nbsp;{$summeckk}&nbsp;ckk&nbsp;</th>
				
			</tr>{/if}
			{if $rechte >= '3'}
			<tr>
				<th align="left" colspan="2">Schnitt Allianz:</th>
				<th align="right">&nbsp;{$schnittckk}&nbsp;ckk&nbsp;</th>
				
			</tr>{/if}
			{/if} {* Größer 0? *}
			{if $rechte == '0'}
			<tr>
				<th colspan="8"><br />Du hast nicht genügend Rechte, um das Ranking zu sehen!</th>
			</tr>
			{/if}
		</table>
		</div>
	{/if}
	
	
	
	<p> <p> 
	
	
	{if $summeckk1 > 0}
		<div align="center">
		<table width="*">
			<tr>
				<th colspan="8">Allianzranking WING</th>
			</tr>

			{if $rechte > '0'} 
			
			{* Urlaubsmodus? Irgendwer? *}
			{foreach from=$urlaub1 item=urlaub name=urlaub}	
			{if $urlaub.Start != ''}
			<tr>
				<td align="center" colspan="8" class="urlaub">
					<b>{$urlaub.nick}:</b> Vom {$urlaub.Start} bis zum {$urlaub.Ende}.
					<b>Grund:</b> {$urlaub.Grund}
					<b>Sitter:</b> {$urlaub.Sitter}</td>
			</tr>		
			{/if}
			{/foreach}
			
			
			<tr>
				<td align="center">&nbsp;Platz&nbsp;</td>
				<td align="center">&nbsp;Tag&nbsp;</td>			
				<td align="center">&nbsp;Spieler&nbsp;</td>
				{if $rechte >= $proa1}<td align="center">&nbsp;% Alliflotte&nbsp;</td>{/if}
				{if $rechte >= $pro11}<td align="center">&nbsp;% am 1.&nbsp;</td>{/if}
				{if $rechte >= $ckk1}<td align="center">&nbsp;[ckk]&nbsp;</td>{/if}
			
				{if $rechte >= $eckk1}<td align="center">&nbsp;[eckk]&nbsp;</td>{/if}
			
				{if $rechte >= $fckk1}<td align="center">&nbsp;[fckk]&nbsp;</td>{/if}
			
				{if $rechte >= $feckk1}<td align="center">&nbsp;[feckk]&nbsp;</td>{/if}
			
				{if $rechte >= $forsch1}<td align="center">&nbsp;Forschung&nbsp;</td>{/if}
				{if $rechte >= $update1}<td align="center">&nbsp;Letztes Update&nbsp;</td>{/if}
				{if $rechte >= $lev1}<td align="center">&nbsp;LEV pro Tag&nbsp;</td>{/if}
			</tr>
			
			{$a++}
			{foreach from=$user1 item=user name=rankzeile}
			{if $user.Main == 2}
			<tr>
				<td align="center">{$a++}</td>
				
				<td align="center">
					&nbsp;{$user.Tag}&nbsp;
				</td>
				
				<td align="center">
					&nbsp;{if $rechte >= $aus1}<a href="admin/ausbau.php?uid={$user.uid}">{/if}{$user.Nick}{if $rechte >= $aus1}</a>{/if}&nbsp;
				</td>
				
				{if $rechte >= $proa1}<td align="right">&nbsp;{$user.ProGes}&nbsp;%&nbsp;</td>{/if}
				
				{if $rechte >= $pro11}<td align="right">&nbsp;{$user.ProErst}&nbsp;%&nbsp;</td>{/if}
				
				{if $rechte >= $ckk1}<td align="right">
					&nbsp;{if $rechte >= '4'}<a href="admin/flotte.php?uid={$user.uid}">{/if}{$user.ckk}{if $rechte >= '2'}</a>{/if}&nbsp;
				</td>{/if}
				
			
				{if $rechte >= $eckk1}<td align="right">
					&nbsp;{$user.eckk}&nbsp;
				</td>
				{/if}
				
			
				{if $rechte >= $fckk1}<td align="right">
					&nbsp;{$user.fckk}&nbsp;
				</td>
				{/if}

			
				{if $rechte >= $feckk1}<td align="right">
					&nbsp;{$user.feckk}&nbsp;
				</td>
				{/if}
				
				{if $rechte >= $forsch1}<td align="right">
					&nbsp;{if $rechte >= $aus1}<a href="admin/forschung.php?uid={$user.uid}">{/if}{$user.Forschung} Pkt.{if $rechte >= $aus1}</a>{/if}&nbsp;
				</td>{/if}
				
				{if $rechte >= $update1}
					{* Länger als 7 Tage tot: *}
					{if (time()-$user.Unixzeit > 60*60*24*8) }
					<td style="color: #Ff0000;" align="center">Strafe Erhalten&nbsp;</td>
					{elseif (time()-$user.Unixzeit > 60*60*24*4) }
                    <td style="color: #Ff5B5B;" align="center">Sofort Eintragen&nbsp;</td>
					{elseif (time()-$user.Unixzeit > 60*60*24*2) }
					<td style="color: #F5F23A;" align="center">Eintragen&nbsp;</td>
					{else}
					<td style="color: #70ff50;" align="center">{$user.LastChg}&nbsp;</td>
					{/if}			
				{/if}
				
				{if $rechte >= $lev1}<td align="right">&nbsp;{$user.ProdLev}&nbsp;Stk.&nbsp;</td>{/if}		
					
				
			</tr>
			{/if}
			{/foreach}
			
			{if $rechte >= '2'}
			<tr>
				<th align="left" colspan="2">Summe Allianz:</th>
				<th align="right">&nbsp;{$summeckk1}&nbsp;ckk&nbsp;</th>
			
			</tr>{/if}
		    {if $rechte >= '2'}
            <tr>
				<th align="left" colspan="2">Schnitt Allianz:</th>
				<th align="right">&nbsp;{$schnittckk1}&nbsp;ckk&nbsp;</th>
			
			</tr>{/if}
			{/if} {* Größer 0? *}
		
			
			{if $rechte == '0'}
			<tr>
				<th colspan="8"><br />Du hast nicht genügend Rechte, um das Ranking zu sehen!</th>
			</tr>
			{/if}
		</table>
		</div>
	{/if}
	
	
	
</body>
</html>