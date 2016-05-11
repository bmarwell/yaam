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
	<table width="*">

		
		<tr>
			<td class="none" colspan="5">&nbsp;</td>		
		</tr>
		<tr>
			<th colspan="6">Script-Optionen</th>
		</tr>
		<form action="index.php" method="post">
		<tr>
			<td colspan="4" align="right">
				Registrierung erlauben?&nbsp;<input type="checkbox" name="register" value="1" {if $register == 1}checked{/if}>
			</td>	
			<td colspan="3" align="right">
				Lustige Urlaubsgr&uuml;nde?&nbsp;<input type="checkbox" name="ugruende" value="1" {if $ugrund == 1}checked{/if}>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right">
				Optionen U9 aktivieren?&nbsp;<input type="checkbox" name="u9" value="1" {if $u9 == 1}checked{/if}>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Main % vom der Alliflotte
        	</td>
            <td colspan="1" align="right">
				<select name="proa" size="1" style="width: 80px;">
					<option selected>{$proa}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		
        	<td colspan="1" align="right">
        	Main % vom Ersten
        	</td>
            <td colspan="1" align="right">
				<select name="pro1" size="1" style="width: 80px;">
					<option selected>{$pro1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Main CKK
        	</td>
            <td colspan="1" align="right">
				<select name="ckk" size="1" style="width: 80px;">
					<option selected>{$ckk}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		
        	<td colspan="1" align="right">
        	Main ECKK
        	</td>
            <td colspan="1" align="right">
				<select name="eckk" size="1" style="width: 80px;">
					<option selected>{$eckk}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Main FCKK
        	</td>
            <td colspan="1" align="right">
				<select name="fckk" size="1" style="width: 80px;">
					<option selected>{$fckk}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		
        	<td colspan="1" align="right">
        	Main FECKK
        	</td>
            <td colspan="1" align="right">
				<select name="feckk" size="1" style="width: 80px;">
					<option selected>{$feckk}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Main Forschung
        	</td>
            <td colspan="1" align="right">
				<select name="forsch" size="1" style="width: 80px;">
					<option selected>{$forsch}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
	
        	<td colspan="1" align="right">
        	Main Update
        	</td>
            <td colspan="1" align="right">
				<select name="update" size="1" style="width: 80px;">
					<option selected>{$update}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Main LEV Prod
        	</td>
            <td colspan="1" align="right">
				<select name="lev" size="1" style="width: 80px;">
					<option selected>{$lev}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
	
        	<td colspan="1" align="right">
        	Main Ausbau und Forschung Einsehen
        	</td>
            <td colspan="1" align="right">
				<select name="aus" size="1" style="width: 80px;">
					<option selected>{$aus}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
        <tr>
        	<td colspan="4" align="right">
        	Wing % vom der Alliflotte
        	</td>
            <td colspan="1" align="right">
				<select name="proa1" size="1" style="width: 80px;">
					<option selected>{$proa1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>	
	
        	<td colspan="1" align="right">
        	Wing % vom Ersten
        	</td>
            <td colspan="1" align="right">
				<select name="pro11" size="1" style="width: 80px;">
					<option selected>{$pro11}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Wing CKK
        	</td>
            <td colspan="1" align="right">
				<select name="ckk1" size="1" style="width: 80px;">
					<option selected>{$ckk1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
	
        	<td colspan="1" align="right">
        	Wing ECKK
        	</td>
            <td colspan="1" align="right">
				<select name="eckk1" size="1" style="width: 80px;">
					<option selected>{$eckk1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Wing FCKK
        	</td>
            <td colspan="1" align="right">
				<select name="fckk1" size="1" style="width: 80px;">
					<option selected>{$fckk1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>

        	<td colspan="1" align="right">
        	Wing FECKK
        	</td>
            <td colspan="1" align="right">
				<select name="feckk1" size="1" style="width: 80px;">
					<option selected>{$feckk1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Wing Forschung
        	</td>
            <td colspan="1" align="right">
				<select name="forsch1" size="1" style="width: 80px;">
					<option selected>{$forsch1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
	
        	<td colspan="1" align="right">
        	Wing Update
        	</td>
            <td colspan="1" align="right">
				<select name="update1" size="1" style="width: 80px;">
					<option selected>{$update1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
        	<td colspan="4" align="right">
        	Wing LEV Prod
        	</td>
            <td colspan="1" align="right">
				<select name="lev1" size="1" style="width: 80px;">
					<option selected>{$lev1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
	
        	<td colspan="1" align="right">
        	Wing Ausbau und Forschung Einsehen
        	</td>
            <td colspan="1" align="right">
				<select name="aus1" size="1" style="width: 80px;">
					<option selected>{$aus1}</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="none" colspan="5">&nbsp;</td>
			<td colspan="2" align="right">
				 <input type="hidden" value="true" name="settings"> 
				<input type="submit" value="Sichern">
			</td>		
		</tr>

		</form>
		
		
	</table>
	</div>
	
</body>
</html>