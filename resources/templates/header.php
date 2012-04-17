<div id="topbar">
	<div id="contentTopBar">
		<h1>Lecturate</h1>
		<img id="logo" src="img/logo.png" alt="DHBW-Logo">
		<p>Bewerten, Verbessern, Profitieren!</p>
	</div>
	<div id="background"></div>
</div>
<div id="navbar" class="leftRight">
	<div class="left">
		<?php
		if (array_key_exists("login", $_SESSION)) {
			echo T::iconButton(false, "Admin", "admin");
			echo T::iconButton(false, "Vorlesung", "lecture");
			echo T::iconButton(false, "Dozent", "docent");
			echo T::iconButton(false, "SGL", "advisor");
			echo T::iconButton(false, "Kurs", "classs");
			echo T::iconButton(false, "Dozent hält Vorlesung", "docent_lecture");
			echo T::iconButton(false, "Kurs hört gehaltene Vorlesung", "classs_docent_lecture");
			echo T::iconButton(false, "Einmal-PW", "otpw");
			echo T::iconButton(false, "Bewertung", "rating");
			echo T::iconButton(false, "Auswertung", "evaluation");
		} else {
			echo T::iconButton(false, "Bewerten", "student");
		}
		?>
	</div>
	<div class="right">
		<?php 
		if (array_key_exists("login", $_SESSION))
			echo T::iconButton(T::LOGOUT, "Abmelden", "login", "logout");
		else
			echo T::iconButton(T::LOGIN, "Anmelden", "login", "login");
		?>
		<br>
		<?=T::iconButton(T::HOME, "Start", "welcome"); ?>
		<br>
	</div>
</div>

