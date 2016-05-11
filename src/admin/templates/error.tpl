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
		{if !isset($msg) }<img border="0" src="../bilder/logo.png" alt="Yaam! Logo">{/if}
		<table width="520">
		{if !isset($msg) }
			<tr> 
				<td align="center">
					Deine Session ist ung&uuml;ltig!<br />
          		Bitte logge dich erneut ein!
          	</td>
			</tr>
         {else}
			<tr> 
				<td align="center">{$msg}</td>
			</tr>
         {/if}
          <tr> 
          	<td align="center"><a href="../login.php" target="_top">Zum Login</a>
          	</td>
          </tr>          
        </table>
     </div>
     
  </body>
</html>
