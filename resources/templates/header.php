<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Lecturate</title>
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<link rel="stylesheet" href="css/buttons.css" type="text/css">
</head>

<body>
<div id="topbar">
	<h1>Lecturate</h1>
	<p>Bewerten, Verbessern, Profitieren!</p>
</div>
<div id="navbar">
<?=T::iconButton(false, "Admin", "admin")?>
<?=T::iconButton(false, "Vorlesung", "lecture")?>
<?=T::iconButton(false, "Dozent", "docent")?>
<?=T::iconButton(false, "SGL", "advisor")?>
<?=T::iconButton(false, "Kurs", "classs")?>
<?=T::iconButton(false, "Dozent hält Vorlesung", "docent_lecture")?>
<?=T::iconButton(false, "Kurs hört gehaltene Vorlesung", "classs_docent_lecture")?>
<?=T::iconButton(false, "Einmal-PW", "otpw")?>
<?=T::iconButton(false, "Bewertung", "Rating")?>
</div>