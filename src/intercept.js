function zeitSecToString(zeitsec) {
	var zeith = Math.floor(zeitsec / 3600);
	if (zeith < 10) {zeith = "0" + zeith}
	var zeitm = Math.floor((zeitsec-zeith*3600) / 60);
	if (zeitm < 10) {zeitm = "0" + zeitm}
	var zeits = zeitsec-zeith*3600 - zeitm*60;
	if (zeits < 10) {zeits = "0" + zeits}
	return zeith + ":" + zeitm + ":" + zeits;
}

function zeitSec(zeit) {
	return zeit.substring(0,zeit.indexOf(":"))*3600 + zeit.substring(zeit.indexOf(":")+1,zeit.lastIndexOf(":"))*60 + zeit.substring(zeit.lastIndexOf(":")+1,zeit.length)*1;
}

function berechnen() {
	var abzeit = document.Formular.Abzeit.value;
	var anzeit = document.Formular.Anzeit.value;
	var flugdauer = document.Formular.Flugdauer.value;
	
	var abzeitsec = zeitSec(abzeit);
	var anzeitsec = zeitSec(anzeit);
	var flugdauersec = zeitSec(flugdauer);
	
	var seineflugdauersec = anzeitsec - abzeitsec;
	if (seineflugdauersec < 0 ) {seineflugdauersec = seineflugdauersec + 86400;}
	var rueckkehrzeitsec = seineflugdauersec + anzeitsec;
	if (rueckkehrzeitsec >= 86400 ) {rueckkehrzeitsec = rueckkehrzeitsec - 86400;}
	var losschickzeitsec = rueckkehrzeitsec - flugdauersec;
	if (losschickzeitsec < 0 ) {losschickzeitsec = losschickzeitsec + 86400;}
	
	document.Formular.Ausgabe.value=zeitSecToString(losschickzeitsec);
	document.Formular.Rueckkehr.value=zeitSecToString(rueckkehrzeitsec);
	document.Formular.SeineFlugDauer.value=zeitSecToString(seineflugdauersec);
}