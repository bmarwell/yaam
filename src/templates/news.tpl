<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>


<body>	<div align="center">
	<table width="65%">
    <tr>
      <td width="100%" colspan="3" align="center"><b>News von Administrator</b></td>
    </tr>
	{if $rechte !=0}
	{if !$news}
    <tr>
      <td colspan="3" align="center" class="news">Zur Zeit sind keine News vorhanden</td>
    </tr>
	{else}
	{foreach from=$news item=fill}
    <tr>
      <td width="20%" class="news">{$fill.timestamp}<br />von {$fill.nick}</td>
      <td width="70%" class="news">{$fill.text}</td>
		<td width="10%" class="news">
			{if $rechte == 4}<a href="news.php?del={$fill.id}">L&ouml;schen</a>{/if}
		</td>
    </tr>
	{/foreach}
	{/if}
	{/if} {*of newsrechte 0*}

	{if $rechte == 0}
	<tr>
      <td colspan="3" align="center" class="news">Zur Zeit sind keine News vorhanden</td>
    </tr>
	{/if}	

	{* Admins dürfen sogar posten *}
	{if $rechte == 4}
    <tr>
    	<td colspan="3" class="none">&nbsp;</td>
    </tr>
	<tr>
      <td colspan="2" class="none" align="center">
      	<form action="news.php" method="post">
      	<textarea name="text" rows="10" cols="40%">Hier neue News schreiben.</textarea>
      </td>
	</tr>
	<tr>
		<td colspan="2" class="none">&nbsp;</td>
		<td align="right"><input type="submit" accesskey="s" value="Hinzuf&uuml;gen"></form></td>	
	</tr>
	{/if}
	</table>
	</div>
</body>
