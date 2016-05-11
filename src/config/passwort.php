<?php
	$subject = "Dein neues Passwort";
	$message = 'Hallo '.$_POST['nick'].',
	
	Bitte halte diese E-Mail gespeichert, falls du dein Passwort vergessen solltest.
	Deine Login-Daten sind die Folgenden:
	
	|--------------------------------|
	|- Nick: '.$_POST['nick'].'
	|- Passwort: '.$newautopw.'
	|--------------------------------|
	
	Liebe Gr&uuml;&szlig;e';
	
	$headers = "From: Yaam! Administrator <".$db->user_get_mail(1).">";

	mail($_POST['email'], $subject, $message, $headers);
?>