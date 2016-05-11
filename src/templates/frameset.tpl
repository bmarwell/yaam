<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Yet another alliance manager!</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<frameset rows="150,*" border="0">
	<frame name="topframe" scrolling="no" noresize src="topframe.php">
		<frameset cols="174,*" border="0">
		<frame name="navi" src="navi.php" scrolling="auto">
		{if $u9 == 1}<frame name="hauptframe" src="ranking.php" scrolling="auto">{/if}
		{if $u9 == 0}<frame name="hauptframe" src="ranking.php" scrolling="auto">{/if}
	</frameset>
</frameset>

<noframes>
	<p>Diese Seite verwendet Frames. Frames werden von Ihrem Browser aber nicht unterst&uuml;tzt.</p>
</noframes>

</html>