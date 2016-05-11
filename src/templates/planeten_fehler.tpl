<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>


<body>
	<div align="center">	<table width="65%">
	{if $msg}
		<tr>
			<td>
				{$msg}
				<br /> <br />
				<a href="javascript:history.go(-1)">Zur&uuml;ck</a>
			</td>
		</tr>
	{else}
		<tr>
			<td>Unbekannter Fehler!<br /> <br />
				<a href="planeten.php">Zur&uuml;ck</a></td>
		</tr>
	{/if}
	</table>
	</div>
</body>
</html>