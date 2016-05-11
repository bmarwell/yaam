<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>YAAM! 5.1 Yet another Allianz Manager Version 5.1</title>
	<link rel="stylesheet" type="text/css" href="yaam.css">
	<base target="hauptframe">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript">
<!--

image1 = new Image;
image1.src = "./bilder/navi/_kbupload_on.png";
image2 = new Image;
image2.src = "./bilder/navi/_kbupload.png";

image3 = new Image;
image3.src = "./bilder/navi/_kbranking_on.png";
image4 = new Image;
image4.src = "./bilder/navi/_kbranking.png";

image5 = new Image;
image5.src = "./bilder/navi/_logout_on.png";
image6 = new Image;
image6.src = "./bilder/navi/_logout.png";

image7 = new Image;
image7.src = "./bilder/navi/_planeten_on.png";
image8 = new Image;
image8.src = "./bilder/navi/_planeten.png";

image9 = new Image;
image9.src = "./bilder/navi/_ausbau_on.png";
image10 = new Image;
image10.src = "./bilder/navi/_ausbau.png";

image11 = new Image;
image11.src = "./bilder/navi/_forschung_on.png";
image12 = new Image;
image12.src = "./bilder/navi/_forschung.png";

image13 = new Image;
image13.src = "./bilder/navi/_info_on.png";
image14 = new Image;
image14.src = "./bilder/navi/_info.png";

image15 = new Image;
image15.src = "./bilder/navi/_uebersicht_on.png";
image16 = new Image;
image16.src = "./bilder/navi/_uebersicht.png";

image19 = new Image;
image19.src = "./bilder/navi/_einstellungen_on.png";
image20 = new Image;
image20.src = "./bilder/navi/_einstellungen.png";

image21 = new Image;
image21.src = "./bilder/navi/_news_on.png";
image22 = new Image;
image22.src = "./bilder/navi/_news.png";

image31 = new Image;
image31.src = "./bilder/navi/_admin_on.png";
image32 = new Image;
image32.src = "./bilder/navi/_admin.png";

image33 = new Image;
image33.src = "./bilder/navi/_ranking_on.png";
image34 = new Image;
image34.src = "./bilder/navi/_ranking.png";

image35 = new Image;
image35.src = "./bilder/navi/_bashranking_on.png";
image36 = new Image;
image36.src = "./bilder/navi/_bashranking.png";

image37 = new Image;
image37.src = "./bilder/navi/_karte_on.png";
image38 = new Image;
image38.src = "./bilder/navi/_karte.png";

image39 = new Image;
image39.src = "./bilder/navi/_finder_on.png";
image40 = new Image;
image40.src = "./bilder/navi/_finder.png";

// End -->
</script>	
	
</head>

<body background="bilder/sidebar.png">
<img src="./bilder/navi/menue.png"><br />

<a href="news.php" onmouseover="news.src=image21.src" onmouseout="news.src=image22.src">
<img border="0" src="./bilder/navi/_news.png" name="news"></a><br />

{if $rechte == '4'}
<a href="admin/index.php" onmouseover="admin.src=image31.src" onmouseout="admin.src=image32.src">
<img border="0" src="./bilder/navi/_admin.png" name="admin"></a><br />
{/if}

{if $rechte == '4'}
<a href="admin/setup.php" onmouseover="settings.src=image19.src" onmouseout="settings.src=image20.src">
<img border="0" src="./bilder/navi/_einstellungen.png" name="settings"></a><br />
{/if}

<br /><img src="./bilder/navi/status.png"><br />

<a href="uebersicht.php" onmouseover="uebersicht.src=image15.src" onmouseout="uebersicht.src=image16.src">
<img border="0" src="./bilder/navi/_uebersicht.png" name="uebersicht"></a><br />

<a href="planeten.php" onmouseover="planeten.src=image7.src" onmouseout="planeten.src=image8.src">
<img border="0" src="./bilder/navi/_planeten.png" name="planeten"></a><br />

{if $u9 == '1'}
<a href="gesamtausbau.php" onmouseover="ausbau.src=image9.src" onmouseout="ausbau.src=image10.src">
<img border="0" src="./bilder/navi/_ausbau.png" name="ausbau"></a><br />
{/if}

<a href="forschung.php" onmouseover="button06.src=image11.src" onmouseout="button06.src=image12.src">
<img border="0" src="./bilder/navi/_forschung.png" name="button06"></a><br />

<a href="ranking.php" onmouseover="ranking.src=image33.src" onmouseout="ranking.src=image34.src">
<img border="0" src="./bilder/navi/_ranking.png" name="ranking"></a><br />


{if $u9 == '1'}
<br /><img src="././bilder/navi/tools.png"><br />

<a href="karte.php" onmouseover="karte.src=image37.src" onmouseout="karte.src=image38.src">
<img border="0" src="./bilder/navi/_karte.png" name="karte"></a><br />

<a href="finder.php" onmouseover="finder.src=image39.src" onmouseout="finder.src=image40.src">
<img border="0" src="./bilder/navi/_finder.png" name="finder"></a><br />

<a href="addkb.php" onmouseover="kbupload.src=image1.src" onmouseout="kbupload.src=image2.src">
<img border="0" src="./bilder/navi/_kbupload.png" name="kbupload"></a><br />

<a href="kbranking.php" onmouseover="kbranking.src=image3.src" onmouseout="kbranking.src=image4.src">
<img border="0" src="./bilder/navi/_kbranking.png" name="kbranking"></a><br />

<a href="bashranking.php" onmouseover="bashranking.src=image35.src" onmouseout="bashranking.src=image36.src">
<img border="0" src="./bilder/navi/_bashranking.png" name="bashranking"></a><br />
{/if}

<br /><img src="././bilder/navi/script.png"><br />

<a href="info.php" onmouseover="info12.src=image13.src" onmouseout="info12.src=image14.src">
<img border="0" src="./bilder/navi/_info.png" name="info12"></a><br />

<a href="einstellungen.php" onmouseover="settings.src=image19.src" onmouseout="settings.src=image20.src">
<img border="0" src="./bilder/navi/_einstellungen.png" name="settings"></a><br />

<a target="_top" href="logout.php" onmouseover="logout.src=image5.src" onmouseout="logout.src=image6.src">
<img border="0" src="./bilder/navi/_logout.png" name="logout"></a><br />

</body>
</html>