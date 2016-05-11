<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="../yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script type="text/Javascript" language="Javascript">
		var user = new Array();
			
		{foreach from=$user3 item=user3}
		user[{$user3.ID}] = new Object();
		user[{$user3.ID}]['Tag'] = "{$user3.Tag}";
		user[{$user3.ID}]['Rechte'] = "{$user3.Rechte}";
		user[{$user3.ID}]['Main'] = "{$user3.Main}";		
		{/foreach}
				
		function FillIn(UserID)		
		{ldelim}
			//alert(UserID);
			document.forms['userchange'].elements['tag'].value = user[UserID]['Tag'];
			document.forms['userchange'].elements['rechte'].value = user[UserID]['Rechte'];
			document.forms['userchange'].elements['main'].value = user[UserID]['Main'];
		{rdelim}
		
	</script>
</head>

<body>
	<div align="center">
	<table width="*">
		<tr>
			<th colspan="6">Benutzer&uuml;bersicht</th>
		</tr>
		
		{* Tag - Nick - Rechte - ckk - lastUpdt. *}
		
		<tr>
			<td align="center">&nbsp;<b>ID</b>&nbsp;</td>
			<td align="center">&nbsp;<b>Tag</b>&nbsp;</td>
			<td align="center">&nbsp;<b>Nick</b>&nbsp;</td>
			<td align="center">&nbsp;<b>Rechte</b>&nbsp;</td>
			<td align="center">&nbsp;<b>Flotte</b> [ckk]&nbsp;</td>
			<td align="center">&nbsp;<b>Letztes Update</b>&nbsp;</td>
			<td align="center">&nbsp;<b>Allianz</b>&nbsp;</td>
		</tr>
		
		
		{foreach from=$user item=user name=rankzeile}		
		<tr>
			<td align="center">&nbsp;{$user.ID}&nbsp;</td>
			<td align="center">&nbsp;{$user.Tag}&nbsp;</td>			
			<td align="center">&nbsp;{$user.Nick}&nbsp;</td>
			<td align="center">&nbsp;{$user.Rechte}&nbsp;</td>
			<td align="right">&nbsp;{$user.ckk} ckk&nbsp;</td>
			

				{* Länger als 14 Tage tot: *}
				{if (time()-$user.Unixzeit > 60*60*24*14) }
				<td style="color: #Ff5B5B;" align="center">{$user.LastChg}&nbsp;</td>
				{elseif (time()-$user.Unixzeit > 60*60*24*7) }
				<td style="color: #F5F23A;" align="center">{$user.LastChg}&nbsp;</td>
				{else}
				<td style="color: #70ff50;" align="center">{$user.LastChg}&nbsp;</td>
				{/if}		
			
			{if $user.Main == 0}<td align="center">&nbsp;Keine&nbsp;</td>{/if}
			{if $user.Main == 1}<td align="center">&nbsp;Main&nbsp;</td>{/if}
			{if $user.Main == 2}<td align="center">&nbsp;Wing&nbsp;</td>{/if}

		</tr>
		{/foreach}

		<tr>
			<th align="left" colspan="4">Summe Allianz:</th>
			<th align="right">&nbsp;{$summeckk}&nbsp;ckk&nbsp;</th>
			<th></th>
		</tr>
		
		<tr>
			<td class="none" colspan="5">&nbsp;</td>		
		</tr>
		<tr>
			<th colspan="6">Benutzerverwaltung</th>
		</tr>
		<form action="index.php" method="post" name="userchange">
		
		<tr>
			<td colspan="2" align="center">Name</td>
			<td colspan="2" align="center">Tag</td>
			<td colspan="1" align="center">Rechte</td>
			<td colspan="1" align="center">Ally</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<select name="nick" size="1" onchange="javascript:FillIn(document.forms['userchange'].elements['nick'].value)">
				<option value="">&nbsp;</option>
				{foreach from=$user2 item=liste name=loeschen}
					<option value="{$liste.ID}" name="{$liste.ID}">{$liste.Nick}</option>		
				{/foreach}		
				</select>	
			</td>
			<td colspan="2" align="center">
				<input type="text" size="10" maxlength="7" name="tag">
			</td>
			<td colspan="1" align="center">
				<select name="rechte" size="1" style="width: 80px;">
					<option selected>&nbsp;</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>				
				</select>
			</td>
			
			<td colspan="1" align="center">
				<select name="main" size="1" style="width: 80px;">
					<option selected>&nbsp;</option>
					<option value="0">Keine</option>					
					<option value="1">Main</option>
					<option value="2">Wing</option>				
				</select>
			</td>
			
			<td colspan="1" align="right">
				<input type="hidden" value="true" name="change"> 
				<input type="submit" value="&Auml;ndern">
			</td>
		</tr>
		</form>

		<form action="index.php" method="post">
		<tr>
			<td colspan="2">
				<select name="nick" size="1">
					<option value="">&nbsp;</option>				
				{foreach from=$user2 item=liste name=loeschen}
					<option value="{$liste.ID}">{$liste.Nick}</option>		
				{/foreach}		
				</select>		
			</td>	
			<td colspan="2" align="center">
				<input type="hidden" value="true" name="delete"> 
				<input type="submit" value="L&ouml;schen">
			</td>
		</tr>
		</form>
	</table>
	</div>
	
</body>
</html>